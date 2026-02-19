/**
 * Grunt configuration for Elliott Richmond Register Custom Block Styles.
 * Converts readme.txt to readme.md for GitHub/source distribution.
 *
 * @package Elliott_Richmond_Register_Custom_Block_Styles
 * @since 1.0.0
 */

module.exports = function (grunt) {
	grunt.initConfig(
		{
			wp_readme_to_markdown: {
				your_target: {
					files: {
						"readme.md": "readme.txt",
					},
				},
			},
		}
	);
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.registerTask( 'default', [ 'wp_readme_to_markdown' ] );
};
