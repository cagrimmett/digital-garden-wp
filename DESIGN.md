---
name: Chuck's Garden
description: A WordPress block theme for a digital garden of notes planted early, tended often and never quite finished.
colors:
  paper: "#faf8f4"
  ink: "#23201b"
  rust: "#c0451d"
  deep-rust: "#8f3214"
  wash: "#efe9dd"
  muted-ink: "#6e675b"
  sage: "#5d7052"
  rule: "#e3ddd1"
  paper-dark: "#171512"
  ink-dark: "#e9e3d6"
  rust-dark: "#f08a63"
  deep-rust-dark: "#ffb094"
  wash-dark: "#221f19"
  muted-ink-dark: "#9c9384"
  sage-dark: "#8fa383"
  rule-dark: "#322e26"
typography:
  display:
    fontFamily: "\"ET Book\", Iowan Old Style, Palatino, Georgia, serif"
    fontSize: "2.6rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.011em"
  headline:
    fontFamily: "\"ET Book\", Iowan Old Style, Palatino, Georgia, serif"
    fontSize: "1.9rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.011em"
  title:
    fontFamily: "\"ET Book\", Iowan Old Style, Palatino, Georgia, serif"
    fontSize: "1.4rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.011em"
  body:
    fontFamily: "\"ET Book\", Iowan Old Style, Palatino, Georgia, serif"
    fontSize: "1.1875rem"
    fontWeight: 400
    lineHeight: 1.62
  ui:
    fontFamily: "-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif"
    fontSize: "0.8125rem"
    fontWeight: 400
    lineHeight: 1.45
  label:
    fontFamily: "-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif"
    fontSize: "0.6875rem"
    fontWeight: 600
    lineHeight: 1.3
    letterSpacing: "0.075em"
  mono:
    fontFamily: "ui-monospace, SFMono-Regular, Menlo, Consolas, monospace"
    fontSize: "0.875rem"
    lineHeight: 1.55
rounded:
  hairline: "2px"
  sm: "3px"
  md: "4px"
  lg: "5px"
  pill: "999px"
spacing:
  "10": "0.5rem"
  "20": "1rem"
  "30": "1.75rem"
  "40": "2.75rem"
  "50": "4rem"
  "60": "6rem"
components:
  button-primary:
    backgroundColor: "{colors.rust}"
    textColor: "{colors.paper}"
    rounded: "{rounded.lg}"
    padding: "0.45rem 1rem"
  input-field:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.lg}"
    padding: "0.45rem 0.7rem"
  chip-tag:
    textColor: "{colors.muted-ink}"
    rounded: "{rounded.pill}"
    padding: "0.22rem 0.6rem"
  count-badge:
    backgroundColor: "{colors.wash}"
    textColor: "{colors.muted-ink}"
    rounded: "{rounded.pill}"
    padding: "0.05rem 0.4rem"
  code-block:
    backgroundColor: "{colors.wash}"
    textColor: "{colors.ink}"
    typography: "{typography.mono}"
    rounded: "{rounded.lg}"
    padding: "0.9rem 1.1rem"
  sidebar-label:
    textColor: "{colors.muted-ink}"
    typography: "{typography.label}"
---

# Design System: Chuck's Garden

## Overview

**Creative North Star: "The Annotated Notebook"**

The garden reads like a well-kept field notebook: book typography on warm paper, with a quiet margin of notes beside each page. Prose is set in ET Book at a comfortable measure. Everything around the prose (dates, terms, trees of nearby notes, pingbacks, search) is set small in the system UI face, so the note is always louder than its apparatus.

Density is high but calm. Lists are ruled rows, not cards. Archives are dated streams. The interface uses hairline rules and a single warm accent instead of boxes, shadows or color blocks. The garden metaphor shows up in the words ("Planted", "Tended", "Nearby in the garden", "Nothing planted here") and in one small growth signal, not in illustration or decoration.

It's a child theme of Blockbase, so most of the system lives in `theme.json` presets and `style.css` overrides that win over parent and plugin CSS.

**Key Characteristics:**
- Book serif for reading, system sans for everything that isn't reading
- One rust accent on warm paper, with an automatic dark mode
- Hairline rules and ruled lists instead of cards and shadows
- A sticky margin rail beside every note
- Garden language in labels and states, never as ornament

## Colors

A warm, low-chroma paper-and-ink palette with one rust accent and one sage moment.

### Primary
- **Rust** (`rust`): links, focus rings, the current-note marker, the caret and the primary button. Prose links are underlined with a 45% rust underline so they don't rely on hue alone.
- **Deep Rust** (`deep-rust`): link hover and pressed states only.

### Tertiary
- **Sage** (`sage`): reserved for the "New growth" sprout beside the Tended date. It's the only green in the system.

### Neutral
- **Paper** (`paper`): page background, input backgrounds, and text on rust buttons.
- **Ink** (`ink`): body text, headings and list links at rest.
- **Muted Ink** (`muted-ink`): sidebar labels, dates, counts, placeholders, blockquotes and the "Dormant" state.
- **Wash** (`wash`): code backgrounds, count badges and the current item in the page tree.
- **Rule** (`rule`): every border and divider: list rows, the sidebar edge, the header's bottom edge and field strokes.

### Dark mode
Under `prefers-color-scheme: dark`, the same eight roles swap to the `-dark` values. The palette preset variables are redefined, so components never branch on theme. Raster images are dimmed slightly (`brightness(0.92) contrast(1.02)`).

### Named Rules
**The One Accent Rule.** Rust is the only interactive color. If something is clickable and isn't plain ink, it's rust.

**The Sage Is Earned Rule.** Sage appears only for genuinely recent growth. Don't use it as a second accent or a success color.

**The Mix, Don't Add Rule.** Tints come from `color-mix()` with an existing token (a 16% rust focus glow, a 20% rust search highlight), never from new hex values.

## Typography

**Display Font:** ET Book (with Iowan Old Style, Palatino, Georgia)
**Body Font:** ET Book
**Label/UI Font:** System UI stack (`-apple-system`, Segoe UI, Roboto)
**Mono Font:** `ui-monospace`, SF Mono, Menlo

**Character:** Tufte's book face carries the writing. A neutral system sans handles the margin and the machinery, so the two layers never compete.

### Hierarchy
- **Display** (700, 2.6rem, 1.2): note titles only, held to 34rem. All headings get -0.011em tracking and balanced wrapping.
- **Headline** (700, 1.9rem, 1.2): H2 inside notes.
- **Title** (700, 1.4rem, 1.2): H3 inside notes.
- **Body** (400, 1.1875rem, 1.62): prose, held to a 40rem measure.
- **UI** (400, 0.8125rem, 1.45): sidebar values, dates, terms, search, captions and tree links.
- **Label** (600, 0.6875rem, 0.075em tracking, uppercase): sidebar headings like "Planted", "Tended", "Linked from" and "Nearby in the garden".
- **Mono** (0.875rem, 1.55): code blocks; inline code is 0.88em on a wash background.

### Named Rules
**The Two Voices Rule.** Serif is for what Chuck wrote; sans is for what the site says about it. Never set metadata in ET Book or prose in the UI face.

**The Line Figures Rule.** Roman and bold ship with lining figures so dates and counts sit level. The italic keeps old-style figures.

## Layout

- **Containers:** content measure 40rem; wide size 72rem. Notes, archives and the 404 all fill the wide container with `width: 100%`, because the flex-column site wrapper would otherwise shrink-wrap them.
- **Note layout:** a two-column grid, with the reading column and a 15rem margin rail (13rem below 60rem). The rail is sticky under the header (top 5.25rem, capped at the viewport height and scrolling on its own) and separated by a 1px rule on its left edge.
- **Rail order:** meta (Planted, Tended, Filed under, Tagged), then "Nearby in the garden", then "Linked from". Empty groups render nothing rather than an empty label.
- **Spacing:** the theme.json scale steps from 0.5rem to 6rem. Block gap is 1.4rem; the side gutter is step 30 (1.75rem). Flow-layout groups that need real gaps are switched to grid with child margins zeroed.
- **Breakpoints:** 60rem narrows the rail. At 48rem the rail drops below the note as an auto-fit grid of 9rem cells with a top rule, the header stops being sticky, and the area list goes to two columns. At 30rem the brand text and rail type step down.
- **Home:** areas as ruled rows in an auto-fill grid (11rem minimum columns), then two dense columns of dated links for recently planted and recently tended.

## Elevation & Depth

The system is flat. There are no drop shadows. Depth comes from hairline rules, the wash tint and one translucent surface: the sticky header, which is 88% paper with `saturate(1.4) blur(10px)` behind it. The only `box-shadow` is the focus glow on fields (`0 0 0 3px` of 16% rust), which works as a ring rather than as elevation.

**The Flat Paper Rule.** If a surface needs separating, use a 1px rule or wash before reaching for a shadow.

## Shapes

Corners are barely there. They use a 2–5px radius for code, fields, buttons, tree highlights and images, so nothing reads as a card. Pills (999px) are reserved for small counted or tag-like things: tags, child counts and gateway links. Borders are always 1px in the rule color, and a 2px rule marks blockquotes.

## Components

### Buttons
- **Character:** rare and plain. The garden is mostly links.
- **Primary:** rust fill, paper text, 600 weight, 1px rust border, 5px radius (`button-primary`). It's used on the password form.
- **Hover / Focus:** the background moves toward deep rust over 0.15s; focus is a 2px rust outline offset 2px.

### Inputs / Fields
- **Style:** paper background, 1px rule stroke, 5px radius (`input-field`). The header search keeps its icon button inside the field.
- **Focus:** the border goes rust and gains a 3px 16% rust glow, transitioning over 0.15s.

### Chips
- **Tags:** 1px rule outline pills in muted ink and the UI face (`chip-tag`). On hover, the border and text go rust.
- **Count badge:** small wash pills with a rule border, beside branch names on area pages (`count-badge`).

### Lists (signature)
- **Ruled rows:** area pages, the home areas and archives use full-width rows divided by 1px rules, with ink links. On hover a link turns rust and nudges 0.35rem right.
- **Area trees:** nested child lists with counts, and a small lock icon on password-protected notes in place of a "Protected:" prefix.

### Margin rail (signature)
- **Meta:** uppercase labels over UI-face values. "Tended" can carry a growth stage: a sage sprout with "New growth" for notes tended within 30 days (with a one-time 0.7s scale-in), or muted italic "Dormant" for notes untouched for two years.
- **Nearby in the garden:** the page family tree, with ancestors in bold ink and the current note on a wash highlight with a rust dot.
- **Linked from:** pingbacks and trackbacks as rust links to the linking post, each with its month and year in muted ink underneath.

### Navigation
- **Header:** sticky translucent bar with the logo and site title on the left, then an always-visible search field (15rem) and text links. Search never collapses into the menu, because it's the main way through the garden. On phones it takes its own full-width row.
- **Breadcrumbs:** UI face at x-small above every note title.

### Code
- **Blocks:** wash background, 1px rule border, 5px radius (`code-block`). Blocks fill the column and scroll horizontally instead of clipping.

## Do's and Don'ts

### Do:
- **Do** set anything that isn't prose in the UI face at 0.8125rem or smaller.
- **Do** use rust for every interactive element and nothing else.
- **Do** separate things with 1px rules in the rule color.
- **Do** render nothing at all when a sidebar group has no data.
- **Do** honor `prefers-reduced-motion`. Transitions are 0.15s ease and drop to near zero when motion is reduced.
- **Do** define new colors as palette presets with a dark-mode value, so the swap stays in one place.

### Don't:
- **Don't** add drop shadows, cards or filled panels.
- **Don't** introduce a second accent hue. Sage is for growth only.
- **Don't** use radii above 5px except on pills.
- **Don't** decorate with garden imagery. Let the labels carry the metaphor.
- **Don't** hide search behind a menu at any width.
