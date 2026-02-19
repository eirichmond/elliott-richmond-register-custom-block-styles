module.exports = function (grunt) {
	grunt.initConfig({
		wp_readme_to_markdown: {
			your_target: {
				files: {
					"readme.md": "readme.txt",
				},
			},
		},
	});
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
    grunt.registerTask( 'default', [ 'wp_readme_to_markdown' ] );
};
