/* jshint node:true */
module.exports = function(grunt) {
	var path = require('path');

	// Load tasks.
	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	// Project configuration.
	grunt.initConfig({
		sass: {
			dev: {
				options: {
					noCache: false,
					sourcemap: true
				},
				expand: true,
				cwd: 'sass/',
				dest: 'css/',
				ext: '.css',
				src: [ 'style.scss' ]
			}
		},

		autoprefixer: {
			options: {},
			dev: {
				src: [ 'css/style.css' ]
			}
		},

		concat: {
			dev: {
				src: [ 'js/src/*.js' ],
				dest: 'js/main.js'
			}
		},

		watch: {
			css: {
				files: ['sass/**'],
				tasks: ['sass:dev','autoprefixer:dev']
			},
			js: {
				files: ['js/src/**'],
				tasks: ['concat:dev']
			}
		}
	});

	// Register tasks.

	// Build task.
	grunt.registerTask('dev', ['sass:dev', 'autoprefixer:dev', 'concat:dev']);

	// Default task.
	grunt.registerTask('default', ['dev']);

};
