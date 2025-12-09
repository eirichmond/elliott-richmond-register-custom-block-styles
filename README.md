# Register Custom Block Styles

A reusable class to register custom block styles with associated stylesheets from the active theme.

[![WordPress](https://img.shields.io/badge/WordPress-6.9%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-%5E8.0-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPLv2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

## Description

Register Custom Block Styles simplifies the process of adding block style variations by automating stylesheet registration and block style registration. Stylesheets are loaded from the active theme directory, making this ideal for theme-specific block styling.

### Features

- Register multiple block styles with a single class instantiation
- Automatic CSS file loading based on style name
- Works with the Site Editor (Full Site Editing)
- Graceful degradation when theme is switched
- Debug logging for missing CSS files

## Installation

1. Upload the `register-custom-block-styles` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Instantiate the class in your theme's `functions.php` file using the example below

## Usage

Add the following to your theme's `functions.php` file:

```php
/**
 * Register custom block styles.
 */
function theme_register_block_styles() {
    // Check if the class exists (plugin may not be active).
    if ( ! class_exists( 'Register_Custom_Block_Styles' ) ) {
        return;
    }

    $block_styles = array(
        array(
            'block' => 'core/button',
            'name'  => 'custom-button',
            'label' => __( 'Custom Button', 'theme-text-domain' ),
        ),
        array(
            'block' => 'core/group',
            'name'  => 'card-style',
            'label' => __( 'Card Style', 'theme-text-domain' ),
        ),
    );

    new Register_Custom_Block_Styles( $block_styles );
}
add_action( 'after_setup_theme', 'theme_register_block_styles' );
```

### CSS File Structure

CSS files should be placed in your theme directory. By default, the plugin looks for files in `/assets/css/styles/`.

For the example above, create:

- `your-theme/assets/css/styles/custom-button.css`
- `your-theme/assets/css/styles/card-style.css`

### Custom CSS Path

You can specify a custom path relative to your theme directory:

```php
new Register_Custom_Block_Styles( $block_styles, '/css/block-styles/' );
```

## Required Array Structure

Each block style array must contain:

| Key     | Description                                                    |
|---------|----------------------------------------------------------------|
| `block` | The block type (e.g., `core/button`, `core/group`)             |
| `name`  | Unique identifier for the style (used for CSS class and filename) |
| `label` | Human-readable label shown in the block editor                 |

## Frequently Asked Questions

### What happens if the theme is switched?

The plugin checks if CSS files exist before enqueuing them. If files are missing, a message is logged to the debug log but no errors are thrown on the frontend. The conditional `class_exists()` check in your theme ensures graceful degradation if the plugin is deactivated.

### Can I use this with child themes?

The plugin uses `get_template_directory()` which points to the parent theme. For child theme support, you would need to modify the class or create CSS files in the parent theme.

### Why are my styles not showing in the Site Editor?

The plugin includes special handling for the Site Editor iframe. Ensure your CSS files exist and check the debug log for any "CSS file not found" messages.

## Changelog

### 1.0.0

- Initial release
- Block style registration class
- Automatic CSS file loading from theme directory
- Site Editor support

## License

This plugin is licensed under the GPLv2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.

