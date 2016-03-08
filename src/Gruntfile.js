module.exports = function( grunt ) {

	// Load All Grunt Plugins
	require( 'load-grunt-tasks' )( grunt );

	var estudiovikingwpConfig = {
		// Gets the Package Vars
		pkg: grunt.file.readJSON( 'package.json' ),

		dirs: {
			css: '../assets/css',
			img: '../assets/img',
			js: '../assets/js',
			sass: '../assets/sass'
		},

		// Uglify to concat and minify
		uglify: {
			bootstrap: {
				files: {
					'<%= dirs.js %>/libs/bootstrap.min.js': [
						'<%= dirs.js %>/bootstrap/transition.js',
						'<%= dirs.js %>/bootstrap/alert.js',
						'<%= dirs.js %>/bootstrap/button.js',
						'<%= dirs.js %>/bootstrap/carousel.js',
						'<%= dirs.js %>/bootstrap/collapse.js',
						'<%= dirs.js %>/bootstrap/dropdown.js',
						'<%= dirs.js %>/bootstrap/modal.js',
						'<%= dirs.js %>/bootstrap/tooltip.js',
						'<%= dirs.js %>/bootstrap/popover.js',
						'<%= dirs.js %>/bootstrap/scrollspy.js',
						'<%= dirs.js %>/bootstrap/tab.js',
						'<%= dirs.js %>/bootstrap/affix.js'
					]
				}
			}
		}, // Uglify

		// Compile SCSS/SASS files to CSS
		sass: {
			dist: {
				options: {
					style: 'compressed',
					sourcemap: 'none'
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.sass %>',
					src: ['*.scss'],
					dest: '<%= dirs.css %>',
					ext: '.css'
				}]
			}
		} // SASS
	};

	// Initialize Grunt Config
	grunt.initConfig( estudiovikingwpConfig );

	// Default Task
	grunt.registerTask( 'default', [ 'uglify', 'sass' ]); 

};