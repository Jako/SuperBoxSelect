module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        modx: grunt.file.readJSON('_build/config.json'),
        banner: '/*!\n' +
            ' * <%= modx.name %> - <%= modx.description %>\n' +
            ' * Version: <%= modx.version %>\n' +
            ' * Build date: <%= grunt.template.today("yyyy-mm-dd") %>\n' +
            ' */\n',
        usebanner: {
            css: {
                options: {
                    position: 'bottom',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/superboxselect/css/mgr/superboxselect.min.css'
                    ]
                }
            },
            js: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/superboxselect/js/mgr/superboxselect.min.js',
                        'assets/components/superboxselect/js/types/resources/superboxselect.panel.inputoptions.min.js',
                        'assets/components/superboxselect/js/types/users/superboxselect.panel.inputoptions.min.js'
                    ]
                }
            }
        },
        uglify: {
            mgr: {
                src: [
                    'node_modules/sortablejs/Sortable.js',
                    'source/js/mgr/superboxselect.js',
                    'source/js/mgr/superboxselect.panel.inputoptions.js',
                    'source/js/mgr/superboxselect.combo.templatevar.js',
                    'source/js/mgr/superboxselect.renderer.js'
                ],
                dest: 'assets/components/superboxselect/js/mgr/superboxselect.min.js'
            },
            resources: {
                src: [
                    'source/js/types/resources/superboxselect.panel.inputoptions.js'
                ],
                dest: 'assets/components/superboxselect/js/types/resources/superboxselect.panel.inputoptions.min.js'
            },
            users: {
                src: [
                    'source/js/types/users/superboxselect.panel.inputoptions.js'
                ],
                dest: 'assets/components/superboxselect/js/types/users/superboxselect.panel.inputoptions.min.js'
            }
        },
        sass: {
            options: {
                implementation: require('node-sass'),
                outputStyle: 'expanded',
                sourcemap: false
            },
            mgr: {
                files: {
                    'source/css/mgr/superboxselect.css': 'source/sass/mgr/superboxselect.scss'
                }
            }
        },
        postcss: {
            options: {
                processors: [
                    require('pixrem')(),
                    require('autoprefixer')()
                ]
            },
            mgr: {
                src: [
                    'source/css/mgr/superboxselect.css'
                ]
            }
        },
        cssmin: {
            mgr: {
                src: [
                    'source/css/mgr/superboxselect.css'
                ],
                dest: 'assets/components/superboxselect/css/mgr/superboxselect.min.css'
            }
        },
        imagemin: {
            png: {
                options: {
                    optimizationLevel: 7
                },
                files: [
                    {
                        expand: true,
                        cwd: 'source/img/',
                        src: ['**/*.png'],
                        dest: 'assets/components/superboxselect/img/',
                        ext: '.png'
                    }
                ]
            }
        },
        watch: {
            js: {
                files: [
                    'source/**/*.js'
                ],
                tasks: ['uglify', 'usebanner:js']
            },
            css: {
                files: [
                    'source/**/*.scss'
                ],
                tasks: ['sass', 'postcss', 'cssmin', 'usebanner:css']
            },
            config: {
                files: [
                    '_build/config.json'
                ],
                tasks: ['default']
            }
        },
        bump: {
            copyright: {
                files: [{
                    src: 'core/components/superboxselect/model/superboxselect/superboxselect.class.php',
                    dest: 'core/components/superboxselect/model/superboxselect/superboxselect.class.php'
                }],
                options: {
                    replacements: [{
                        pattern: /Copyright 2016(-\d{4})? by/g,
                        replacement: 'Copyright ' + (new Date().getFullYear() > 2016 ? '2016-' : '') + new Date().getFullYear() + ' by'
                    }]
                }
            },
            version: {
                files: [{
                    src: 'core/components/superboxselect/model/superboxselect/superboxselect.class.php',
                    dest: 'core/components/superboxselect/model/superboxselect/superboxselect.class.php'
                }],
                options: {
                    replacements: [{
                        pattern: /version = '\d+.\d+.\d+[-a-z0-9]*'/ig,
                        replacement: 'version = \'' + '<%= modx.version %>' + '\''
                    }]
                }
            },
            inputoptions: {
                files: [{
                    src: 'source/js/mgr/superboxselect.panel.inputoptions.js',
                    dest: 'source/js/mgr/superboxselect.panel.inputoptions.js'
                }],
                options: {
                    replacements: [{
                        pattern: /&copy; 2016(-\d{4})?/g,
                        replacement: '&copy; ' + (new Date().getFullYear() > 2016 ? '2016-' : '') + new Date().getFullYear()
                    }]
                }
            }
        }
    });

    //load the packages
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.renameTask('string-replace', 'bump');

    //register the task
    grunt.registerTask('default', ['bump', 'uglify', 'sass', 'postcss', 'cssmin', 'usebanner']);
};
