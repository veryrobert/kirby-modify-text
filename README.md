
# Kirby Modify Text

A flexible Kirby CMS plugin to enhance text blocks with custom attributes, classes, inline styles, or even HTML tag replacements, offering more control over content styling.

## Installation

### Composer
Install the plugin via Composer:
```bash
composer require estd/kirby-modify-text
```

### Manual Installation
Download this repository and place it in your `site/plugins` directory. Make sure the folder is named `kirby-modify-text`.

## Usage

Use `kirby-modify-text` to modify text block HTML with dynamic attributes, styles, classes, or tag changes. Here’s an example of how to use it:

```php
<?php

// Define custom styles
$styles = [
    'color: red',
    'font-weight: bold'
];

// Apply modifications to the text block
echo $block->text()->modifyTag([
    'styles' => $styles,            // Inline styles as an array
    'class' => 'custom-class',      // Add one or more CSS classes
    'tag' => 'span',                // Change the HTML tag (optional)
    'attributes' => [
        'data-custom' => 'example'  // Add any custom attributes
    ]
])->kt();

?>
```

### Options

- **`styles`**: An array of inline CSS styles to add to the tag.
- **`class`**: A string with CSS classes to add. If the tag already has classes, the new ones will be appended.
- **`tag`**: Specify an HTML tag (e.g., `div`, `span`). If omitted, the original tag remains unchanged.
- **`attributes`**: An associative array of additional attributes, such as `data-*` attributes, that will be added to the tag.

## License

MIT License. See the [LICENSE](LICENSE) file for details.
