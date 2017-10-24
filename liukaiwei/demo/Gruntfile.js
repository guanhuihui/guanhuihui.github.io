module.exports = function (grunt) {
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    //清除目录
    clean: {
      js: 'dist/script',
      image: 'dist/images',
      css: 'dist/style',
      html: ['dist/*.html','dist/index/*.html']
    },
    copy: {
      src: {
        files: [
          {expand: true, cwd: 'src', src: ['*.html','index/*.html'], dest: 'dist'}
        ]
      },
      image: {
        files: [
          {expand: true, cwd: 'src', src: ['images/*.{png,jpg,jpeg,gif}'], dest: 'dist'}
        ]
      }
    },
    // 文件合并
    concat: {
      options: {
        separator: '/*--*/',
        stripBanners: true
      },
      js: {
        src: [
          "src/script/all.js","src/script/index.js"
        ],
        dest: "dist/script/main.js"
      },
      css:{
        src: [
          "src/style/*.css"
        ],
        dest: "dist/style/main.css"
      }
    },
    //压缩JS
    uglify: {
      prod: {
        options: {
          banner: '/*! <%= pkg.name %> */\n',
          mangle: {
            except: ['require', 'exports', 'module', 'window']
          },
          compress: {
            global_defs: {
              PROD: true
            },
            dead_code: true,
            pure_funcs: [
              "console.log",
              "console.info"
            ]
          }
        },
        files: [{
            expand: true,
            cwd: 'dist',
            src: ['script/*.js', '!script/all.js'],
            dest: 'dist'
        }]
      }
    },

    //压缩CSS
    cssmin: {
      prod: {
        options: {
          report: 'gzip'
        },
        files: [
          {
            expand: true,
            cwd: 'dist',
            src: ['style/*.css'],
            dest: 'dist'
          }
        ]
      }
    },

    //压缩图片
    imagemin: {
      prod: {
        options: {
          optimizationLevel: 7,
          pngquant: true
        },
        files: [
          {expand: true, cwd: 'dist', src: ['images/*.{png,jpg,jpeg,gif,webp,svg}'], dest: 'dist'}
        ]
      }
    },
    // 处理html中css、js 引入合并问题
    usemin: {
      html: ['dist/*.html','dist/index/*.html']
    },

    //压缩HTML
    htmlmin: {
      options: {
        removeComments: true,
        removeCommentsFromCDATA: true,
        collapseWhitespace: true,
        collapseBooleanAttributes: true,
        removeAttributeQuotes: true,
        removeRedundantAttributes: true,
        useShortDoctype: true,
        removeEmptyAttributes: true,
        removeOptionalTags: true
      },
      html: {
        files: [
          {expand: true, cwd: 'dist', src: ['*.html','index/*.html'], dest: 'dist'}
        ]
      }
    }

  });


  grunt.registerTask('prod', [
    'copy',                 //复制文件
    'concat',               //合并文件   'imagemin',             //图片压缩
    'cssmin',               //CSS压缩
    'uglify',               //JS压缩
    'usemin',               //HTML处理
    'htmlmin'               //HTML压缩'
  ]);

  grunt.registerTask('publish', ['clean', 'prod']);
};