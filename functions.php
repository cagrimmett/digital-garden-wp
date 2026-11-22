<?php
/**
 * Chuck's Garden child theme functions.
 *
 * @package chucks-garden
 */

/**
 * Child styles must load after Blockbase's ponyfill.css, which is enqueued by
 * the parent at the default priority. A child theme's functions.php is parsed
 * first, so registering at the same priority would put our stylesheet *before*
 * the parent's and lose every specificity tie. Priority 20 plus an explicit
 * dependency guarantees the child wins.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'blockbase-parent-style',
			get_template_directory_uri() . '/style.css',
			array(),
			wp_get_theme( get_template() )->get( 'Version' )
		);

		$deps = array( 'blockbase-parent-style' );
		if ( wp_style_is( 'blockbase-ponyfill', 'registered' ) ) {
			$deps[] = 'blockbase-ponyfill';
		}

		wp_enqueue_style(
			'chucks-garden-style',
			get_stylesheet_directory_uri() . '/style.css',
			$deps,
			wp_get_theme()->get( 'Version' )
		);
	},
	20
);

add_action( 'after_setup_theme', function () {
	add_editor_style( 'style.css' );
} );

/**
 * Re-render the subpages list used by the area pages.
 *
 * The get-subpages-list plugin builds its list with
 * `new WP_Query( 'post_type=page&post_parent=N' )` and sets no posts_per_page,
 * so it inherits the blog default of 10 and silently truncates. Food & Drink
 * has 27 children and 17 never appeared. It also passes no orderby, so children
 * came out newest-first rather than in a browsable order.
 *
 * The list is also rendered as a full nested tree, so a branch page such as Fly
 * Fishing shows the notes under Waters and Fly tying rather than only naming
 * them. The whole page set is fetched once and the tree built in memory, so the
 * recursion costs no extra queries.
 *
 * Filtering the rendered output leaves the plugin untouched — a plugin update
 * would wipe a direct edit — and keeps the block identical in the editor.
 */
function chucks_garden_subpage_tree( $parent_id, $by_parent, $depth = 0 ) {
	if ( empty( $by_parent[ $parent_id ] ) || $depth > 4 ) {
		return '';
	}

	$items = '';
	foreach ( $by_parent[ $parent_id ] as $page ) {
		$kids  = isset( $by_parent[ $page->ID ] ) ? count( $by_parent[ $page->ID ] ) : 0;
		$badge = $kids ? ' <span class="subpages-count">' . $kids . '</span>' : '';
		$lock  = '' === $page->post_password ? '' : '<svg class="subpages-lock" viewBox="0 0 16 16" role="img" aria-label="Password protected"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M4.5 7V5a3.5 3.5 0 0 1 7 0v2M3 7h10v7H3z"/></svg>';

		$items .= sprintf(
			'<li><a href="%s">%s%s%s</a>%s</li>',
			esc_url( get_permalink( $page ) ),
			esc_html( get_the_title( $page ) ),
			$lock,
			$badge,
			chucks_garden_subpage_tree( $page->ID, $by_parent, $depth + 1 )
		);
	}

	return '<ul>' . $items . '</ul>';
}
add_filter(
	'render_block',
	function ( $content, $block ) {
		if ( empty( $block['blockName'] ) || 'mdlr/dynamic-block-subpages' !== $block['blockName'] ) {
			return $content;
		}

		$parent = isset( $block['attrs']['pageID'] ) ? absint( $block['attrs']['pageID'] ) : 0;
		if ( ! $parent ) {
			return $content;
		}

		$all = get_pages(
			array(
				'post_status' => array( 'publish', 'private' ),
				'sort_column' => 'menu_order,post_title',
				'sort_order'  => 'ASC',
				'number'      => 0,
			)
		);

		$by_parent = array();
		foreach ( $all as $page ) {
			$by_parent[ (int) $page->post_parent ][] = $page;
		}

		$tree = chucks_garden_subpage_tree( $parent, $by_parent );

		if ( '' === $tree ) {
			return '<div id="blog-page-main"><p class="subpages-empty">No notes beneath this one yet.</p></div>';
		}

		return '<div id="blog-page-main">' . $tree . '</div>';
	},
	10,
	2
);

/**
 * Growth stage beside the "Tended" date, derived from the real modified time:
 * notes tended in the last month show new growth, notes untouched for two
 * years read as dormant. Everything in between stays quiet.
 */
add_filter(
	'render_block_tabor/post-modified-time',
	function ( $content, $block, $instance ) {
		if ( false === strpos( $block['attrs']['className'] ?? '', 'garden-meta__value' ) ) {
			return $content;
		}

		$post_id = $instance->context['postId'] ?? get_the_ID();
		$days    = ( time() - (int) get_post_modified_time( 'U', true, $post_id ) ) / DAY_IN_SECONDS;

		if ( $days <= 30 ) {
			$icon = '<svg viewBox="0 0 16 16" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M8 15V7"/><path fill="currentColor" d="M8 8.5C8 5 5.5 3.5 2.5 3.8 2.6 6.9 4.6 8.6 8 8.5Z"/><path fill="currentColor" d="M8 7c0-3.3 2.2-5.3 5.6-5.2C13.5 5 11.4 7 8 7Z"/></svg>';
			return $content . '<span class="garden-growth garden-growth--new">' . $icon . esc_html__( 'New growth', 'chucks-garden' ) . '</span>';
		}

		if ( $days > 730 ) {
			return $content . '<span class="garden-growth garden-growth--dormant">' . esc_html__( 'Dormant', 'chucks-garden' ) . '</span>';
		}

		return $content;
	},
	10,
	3
);

/**
 * Drop core's "Protected: " title prefix on the front end. The password form
 * already says so on the note itself, and the child list marks these with a
 * lock, so the prefix only cluttered every list and breadcrumb.
 */
add_filter(
	'protected_title_format',
	function ( $format ) {
		return is_admin() ? $format : '%s';
	}
);

/**
 * Flag pages whose body is essentially just their child list.
 *
 * On those "area" pages the sidebar rail repeating the same children is pure
 * duplication (Food & Drink rendered 47 links twice), so style.css collapses
 * that branch. On a substantive note that merely happens to have children — Fly
 * tying, for instance, where the list sits far below a long article — the rail
 * stays expanded because it is the only way to see them without scrolling.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		if ( ! is_page() ) {
			return $classes;
		}

		$content = get_post_field( 'post_content', get_queried_object_id() );
		if ( ! $content || false === strpos( $content, 'dynamic-block-subpages' ) ) {
			return $classes;
		}

		// Strip the child-list block and see whether anything substantial is left.
		$without = preg_replace( '/<!--\s*wp:mdlr\/dynamic-block-subpages.*?-->/s', '', $content );
		$without = trim( wp_strip_all_tags( strip_shortcodes( (string) $without ) ) );

		if ( strlen( $without ) < 200 ) {
			$classes[] = 'garden-area-page';
		}

		return $classes;
	}
);


add_action( 'admin_init', 'remove_editor_styles' );