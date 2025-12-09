<?php
/**
 * Register Custom Block Styles class file.
 *
 * @package Register_Custom_Block_Styles
 * @since   1.0.0
 */

/**
 * Class Register_Custom_Block_Styles
 *
 * Handles registration of custom block styles and their associated stylesheets.
 * Stylesheets are loaded from the active theme directory.
 *
 * @since 1.0.0
 */
class Register_Custom_Block_Styles {

	/**
	 * Array of block styles to register
	 *
	 * @var array
	 */
	private $block_styles;

	/**
	 * Base path for style files relative to theme directory
	 *
	 * @var string
	 */
	private $styles_path;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @param array  $block_styles Array of block style configurations.
	 *                             Each item should have 'block', 'name', and 'label' keys.
	 * @param string $styles_path  Base path for CSS files relative to theme directory.
	 *                             Default: '/assets/css/styles/'.
	 */
	public function __construct( $block_styles, $styles_path = '/assets/css/styles/' ) {
		$this->block_styles = $block_styles;
		$this->styles_path  = trailingslashit( $styles_path );

		// Hook into WordPress.
		add_action( 'init', array( $this, 'register_block_styles' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_site_editor_styles' ), 20 );
	}

	/**
	 * Enqueue all block style stylesheets
	 *
	 * Automatically registers and enqueues CSS files based on the block style name.
	 * CSS filename should match the 'name' value with .css extension.
	 * Stylesheets are loaded from the active theme directory.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		foreach ( $this->block_styles as $style ) {
			if ( ! isset( $style['name'] ) ) {
				continue;
			}

			$handle   = $style['name'];
			$css_file = $this->styles_path . $handle . '.css';
			$css_path = get_template_directory() . $css_file;

			// Only register if the file exists.
			if ( ! file_exists( $css_path ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				error_log( sprintf( 'Register Custom Block Styles: CSS file not found: %s', $css_path ) );
				continue;
			}

			wp_register_style(
				$handle,
				get_template_directory_uri() . $css_file,
				array(),
				filemtime( $css_path )
			);

			wp_enqueue_style( $handle );
		}
	}

	/**
	 * Enqueue styles specifically for the site editor
	 *
	 * The site editor uses an iframe and styles need to be loaded into it.
	 * WordPress normally only loads block styles when the block is present,
	 * but for the site editor we force-load all styles so they're available
	 * when users add blocks and apply styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_site_editor_styles() {
		// Only run in admin context.
		if ( ! is_admin() ) {
			return;
		}

		// Check if we're in the site editor.
		$screen = get_current_screen();
		if ( ! $screen || 'site-editor' !== $screen->id ) {
			return;
		}

		// Force enqueue all block styles in site editor.
		// This ensures styles are available when users add blocks.
		foreach ( $this->block_styles as $style ) {
			if ( ! isset( $style['name'] ) ) {
				continue;
			}

			$handle = $style['name'];

			// Force enqueue even if block isn't present.
			if ( wp_style_is( $handle, 'registered' ) && ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_enqueue_style( $handle );
			}
		}
	}

	/**
	 * Register all block styles
	 *
	 * Registers block style variations with WordPress.
	 * Uses the 'name' value as the style handle.
	 *
	 * @since 1.0.0
	 */
	public function register_block_styles() {
		foreach ( $this->block_styles as $style ) {
			// Validate required keys.
			if ( ! isset( $style['block'], $style['name'], $style['label'] ) ) {
				continue;
			}

			register_block_style(
				$style['block'],
				array(
					'name'         => $style['name'],
					'label'        => $style['label'],
					'style_handle' => $style['name'],
				)
			);
		}
	}
}
