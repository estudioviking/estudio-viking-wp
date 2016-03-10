/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	// Load All Grunt Plugins
	require( 'load-grunt-tasks' )( grunt );

	var evwpConfig = {
		// Gets the Package Vars
		pkg: grunt.file.readJSON( 'package.json' ),

		dirs: {
			css: '../assets/css',
			img: '../assets/img',
			js: '../assets/js',
			sass: '../assets/sass'
		},

		// JavaScript Linting with JSHint
		jshint: {
			options: {
				jshintrc: '<%= dirs.js %>/.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= dirs.js %>/main.js'
			]
		},

		// Uglify to Concat and Minify
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
			},
			dist: {
				files: {
					'<%= dirs.js %>/main.min.js': [
						'<%= dirs.js %>/libs/*.js',		// External libs/plugins
						'<%= dirs.js %>/main.js'		// Custom JavaScript
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
		}, // SASS

		// Watch for Changes and Trigger SASS, JSHint, Uglify and Livereload browser
		watch: {
			sass: {
				files: [
					'<%= dirs.sass %>/**'
				],
				tasks: ['sass']
			},
			js: {
				files: [
					'<%= jshint.all %>'
				],
				tasks: ['jshint', 'uglify']
			},
			livereload: {
				options: {
					livereload: true
				},
				files: [
					'<%= dirs.css %>/*.css',
					'<%= dirs.js %>/*.js',
					'../**/*.php'
				]
			},
			options: {
				spawn: false
			}
		}
	};

	// Initialize Grunt Config
	grunt.initConfig( evwpConfig );

	// Default Task
	grunt.registerTask( 'default', [
		'jshint',
		'sass',
		'uglify'
	]);

	// Short Aliases
	grunt.registerTask( 'w', ['watch'] );

};