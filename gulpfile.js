/**
 *  Initialize Gulp
 */
var gulp = require('gulp');

/**
 *  Load Gulp Dependencies
 */
var sass = require('gulp-sass');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var util = require('gulp-util');
var browserSync = require('browser-sync').create();
var autoprefixer = require('gulp-autoprefixer');

gulp.task('scss', function () {
    gulp.src('assets/scss/import.scss')
        .pipe(sass({style: 'compressed', errLogToConsole: true}))
        .pipe(rename('main.min.css'))
        .pipe(minifycss())
        //.pipe(autoprefixer())
        .pipe(gulp.dest('assets/css'))
        .pipe(browserSync.stream());
    util.log(util.colors.red('Compiled!'));
});

gulp.task('default', ['scss', 'watch', 'browser-sync']);


gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "www.marketpier.dev", // this proxys my dev site to localhost:3000
        open: false,
        port: 1113
    });
});

gulp.task('watch', function () {

    /**
     *  Watch PHP files for changes
     */
    var php = '**/*.php';

    gulp.watch(php).on('change', function (file) {

        gulp.src(php).pipe(browserSync.stream());

        util.log(util.colors.blue('[ ' + file.path + ' ]'));
    });

    var js = 'assets/js/**/*.js';

    gulp.watch(js).on('change', function (file) {

        gulp.src(js).pipe(browserSync.stream());

        util.log(util.colors.blue('[ ' + file.path + ' ]'));
    });

    /**
     *  Watch SCSS files for changes - trigger 'scss' task
     */
    gulp.watch('assets/scss/**/*.scss', ['scss']);
});
