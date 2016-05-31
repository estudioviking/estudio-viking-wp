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
			sass: '../assets/sass',
			temp: 'temp'
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
		},

		// Download Dependencies
		curl: {
			bootstrap_sass: {
				src: 'https://github.com/twbs/bootstrap-sass/archive/master.zip',
				dest: '<%= dirs.temp %>/bootstrap-sass.zip'
			},
			woocommerce_sass: {
				src: 'https://github.com/woothemes/woocommerce/archive/master.zip',
				dest: '<%= dirs.temp %>/woocommerce-sass.zip'
			}
		},

		// Unzip Files
		unzip: {
			bootstrap_scss: {
				src: '<%= dirs.temp %>/bootstrap-sass.zip',
				dest: '<%= dirs.temp %>/'
			},
			woocommerce_scss: {
				src: '<%= dirs.temp %>/woocommerce-sass.zip',
				dest: '<%= dirs.temp %>/'
			}
		},

		// Rename and Move Directories and Files
		rename: {
			bootstrap_scss: {
				src: '<%= dirs.temp %>/bootstrap-sass-master/assets/stylesheets',
				dest: '<%= dirs.sass %>/bootstrap'
			},
			bootstrap_js: {
				src: '<%= dirs.temp %>/bootstrap-sass-master/assets/javascripts/bootstrap',
				dest: '<%= dirs.js %>/bootstrap'
			},
			bootstrap_fonts: {
				src: '<%= dirs.temp %>/bootstrap-sass-master/assets/fonts/bootstrap',
				dest: '<%= dirs.fonts %>/bootstrap'
			},
			woocommerce_scss: {
				src: '<%= dirs.temp %>/woocommerce-master/assets/css',
				dest: '<%= dirs.sass %>/woocommerce'
			},
			woocommerce_scss_woocommerce: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce.scss'
			},
			woocommerce_scss_woocommerce_layout: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce-layout.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce-layout.scss'
			},
			woocommerce_scss_woocommerce_smallscreen: {
				src: '<%= dirs.sass %>/woocommerce/woocommerce-smallscreen.scss',
				dest: '<%= dirs.sass %>/woocommerce/_woocommerce-smallscreen.scss'
			},
			woocommerce_fonts: {
				src: '<%= dirs.temp %>/woocommerce-master/assets/fonts',
				dest: '<%= dirs.fonts %>/woocommerce'
			},
			woocommerce_images: {
				src: '<%= dirs.temp %>/woocommerce-master/assets/images',
				dest: '<%= dirs.img %>/woocommerce'
			}
		},

		// Clean Directories and Files
		clean: {
			options: {
				force: true
			},
			bootstrap_prepare: [
				'<%= dirs.temp %>',
				'<%= dirs.sass %>/bootstrap/',
				'<%= dirs.js %>/bootstrap/',
				'<%= dirs.js %>/libs/bootstrap.min.js',
				'<%= dirs.fonts %>/bootstrap/'
			],
			bootstrap: [
				'<%= dirs.temp %>'
			],
			woocommerce_prepare: [
				'<%= dirs.temp %>',
				'<%= dirs.sass %>/woocommerce/',
				'<%= dirs.fonts %>/woocommerce/',
				'<%= dirs.img %>/woocommerce/'
			],
			woocommerce: [
				'<%= dirs.sass %>/woocommerce/{activation,admin,chosen,dashboard,menu,prettyPhoto,reports-print,select2}**',
				'<%= dirs.sass %>/woocommerce/*.css',
				'<%= dirs.temp %>'
			]
		},

		replace: {
			woocommerce: {
				src: ['<%= dirs.sass %>/woocommerce/*.scss'],
		 		overwrite: true,
				replacements: [{
					from: /@import ".+";\n/g,
					to: ''
				},{
					from: '../fonts/',
					to: '../fonts/woocommerce/'
				},{
					from: '../img/',
					to: '../img/woocommerce/'
				}]
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
	] );

	// Bootstrap Task
	grunt.registerTask( 'bootstrap', [
		'clean:bootstrap_prepare',
		'curl:bootstrap_sass',
		'unzip:bootstrap_scss',
		'rename:bootstrap_scss',
		'rename:bootstrap_js',
		'rename:bootstrap_fonts',
		'clean:bootstrap',
		'uglify:bootstrap',
		'sass'
	] );

	// Woocommerce Task
	grunt.registerTask( 'woo', [
		'clean:woocommerce_prepare',
		'curl:woocommerce_sass',
		'unzip:woocommerce_scss',
		'rename:woocommerce_scss',
		'rename:woocommerce_scss_woocommerce',
		'rename:woocommerce_scss_woocommerce_layout',
		'rename:woocommerce_scss_woocommerce_smallscreen',
		'rename:woocommerce_fonts',
		'rename:woocommerce_images',
		'clean:woocommerce',
		'replace:woocommerce',
		'sass'
	] );

	// Short Aliases
	grunt.registerTask( 'w', ['watch'] );

};