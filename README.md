# Chuck's Garden

A WordPress block theme for a digital garden: notes planted early, tended often, and never quite finished. It runs [notes.cagrimmett.com](https://notes.cagrimmett.com).

It's a child theme of [Blockbase](https://wordpress.org/themes/blockbase/), set in ET Book on a warm paper palette with a rust accent and an automatic dark mode.

## What it does

- **Notes with a margin rail.** Pages put the reading column next to a sticky sidebar showing when the note was planted and last tended, its categories and tags, and where it sits in the page tree.
- **Growth stages.** Notes tended in the last 30 days get a small "New growth" sprout. Notes untouched for two years read as "Dormant". Both come from the real modified date.
- **Area pages.** Pages whose body is just a list of child pages render that list as a nested, ruled tree with child counts. The sidebar stops repeating the same children.
- **Protected notes.** The "Protected: " title prefix is dropped and a lock icon marks password-protected notes in lists instead.
- **Dense archives.** The blog, bookmarks and search archives read as scannable streams rather than spaced-out cards.

## Requirements

- WordPress 6.7+ and PHP 7.2+
- The [Blockbase](https://wordpress.org/themes/blockbase/) parent theme

The templates use blocks from these plugins. Without them those blocks simply don't render:

| Plugin | Used for |
| --- | --- |
| [Gutenberg](https://wordpress.org/plugins/gutenberg/) | Breadcrumbs block |
| [Get Subpages List](https://wordpress.org/plugins/get-subpages-list/) | Child list on area pages |
| Page Family Tree (Telex) | "Nearby in the garden" tree |
| [Post Modified Time Block](https://wordpress.org/plugins/post-modified-time-block/) | "Tended" date and growth stage |
| [IndieBlocks](https://wordpress.org/plugins/indieblocks/) | Bookmarks and link previews |
| [ActivityPub](https://wordpress.org/plugins/activitypub/) | Fediverse reactions on posts |

## Install

1. Install Blockbase (it doesn't need to be active).
2. Clone this repo into `wp-content/themes/chucks-garden`.
3. Activate **Chuck's Garden** under Appearance → Themes.

## Structure

- `theme.json`: palette, type scale, spacing and layout sizes
- `style.css`: everything Blockbase or plugin CSS gets wrong, plus dark mode
- `functions.php`: style loading, the child-page tree, area-page detection, growth stages and the protected-title filter
- `templates/` and `parts/`: block templates and the header, footer and post-meta parts

## License

GPL-2.0-or-later. ET Book is by Dmitry Krasny, Bonnie Scranton and Edward Tufte, released under the MIT license.
