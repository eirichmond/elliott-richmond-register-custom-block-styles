=== Elliott Richmond Register Custom Block Styles ===
Contributors: yourname
Tags: blocks, block styles, gutenberg, editor, styles
Requires at least: 6.9
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A reusable class to register custom block styles with associated stylesheets from the active theme.

== Description ==

Elliott Richmond Register Custom Block Styles simplifies the process of adding block style variations by automating stylesheet registration and block style registration. Stylesheets are loaded from the active theme directory, making this ideal for theme-specific block styling.

= Features =

* Register multiple block styles with a single class instantiation
* Automatic CSS file loading based on style name
* Works with the Site Editor (Full Site Editing)
* Graceful degradation when theme is switched
* Debug logging for missing CSS files

= Usage =

Add the following to your theme's `functions.php` file:

`
/**
 * Register custom block styles.
 */
function theme_register_block_styles() {
    // Check if the class exists (plugin may not be active).
    if ( ! class_exists( 'Elliott_Richmond_Register_Custom_Block_Styles' ) ) {
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

    new Elliott_Richmond_Register_Custom_Block_Styles( $block_styles );
}
add_action( 'after_setup_theme', 'theme_register_block_styles' );
`

= CSS File Structure =

CSS files should be placed in your theme directory. By default, the plugin looks for files in `/assets/css/styles/`.

For the example above, create:

* `your-theme/assets/css/styles/custom-button.css`
* `your-theme/assets/css/styles/card-style.css`

= Custom CSS Path =

You can specify a custom path relative to your theme directory:

`
new Elliott_Richmond_Register_Custom_Block_Styles( $block_styles, '/css/block-styles/' );
`

== Installation ==

1. Upload the `elliott-richmond-register-custom-block-styles` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Instantiate the class in your theme's `functions.php` file using the example above

== Frequently Asked Questions ==

= What happens if the theme is switched? =

The plugin checks if CSS files exist before enqueuing them. If files are missing, a message is logged to the debug log but no errors are thrown on the frontend. The conditional `class_exists()` check in your theme ensures graceful degradation if the plugin is deactivated.

= Can I use this with child themes? =

The plugin uses `get_template_directory()` which points to the parent theme. For child theme support, you would need to modify the class or create CSS files in the parent theme.

= Why are my styles not showing in the Site Editor? =

The plugin includes special handling for the Site Editor iframe. Ensure your CSS files exist and check the debug log for any "CSS file not found" messages.

= What is the required array structure? =

Each block style array must contain:

* `block` - The block type (e.g., `core/button`, `core/group`)
* `name` - Unique identifier for the style (used for CSS class and filename)
* `label` - Human-readable label shown in the block editor

== Changelog ==

= 1.0.0 =
* Initial release
* Block style registration class
* Automatic CSS file loading from theme directory
* Site Editor support

== Upgrade Notice ==

= 1.0.0 =
Initial release.
