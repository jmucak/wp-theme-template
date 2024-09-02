# SCSS

This architecture is based on [inuticss](https://github.com/inuitcss/inuitcss) framework.

## CSS directory structure

- `/settings` - global variables (colors, font sizes, etc.)
- `/tools` - mixins and functions
- `/generic` - low-specificity (e.g. resets)
- `/elements` - HTML elements with no classes (a, p, ul, ol, blockquote, address, etc.)
- `/objects` - objects, abstractions, and design patterns
- `/components` - discrete, complete chunks of UI
- `/utilities` - high-specificity, very explicit selectors, overrides and helper classes