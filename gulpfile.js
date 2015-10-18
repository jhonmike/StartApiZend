// Load plugins
var
gulp       = require('gulp'),
less       = require('gulp-less'),
concat     = require('gulp-concat'),
minifycss  = require('gulp-minify-css'),
notify     = require('gulp-notify'),
uglify     = require('gulp-uglify')

// JavaScript
gulp.task('javascript', function() {
    var stream = gulp
    .src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.js'
    ])
    .pipe(concat('script.min.js'))
    .pipe(uglify());

    return stream
    .pipe(gulp.dest('public/assets/js'));
});

// CSS
gulp.task('css', function() {
    var stream = gulp
    .src([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/font-awesome/css/font-awesome.css'
    ])
    .pipe(less()
    .on('error', notify.onError(function (error) {
        return 'Error compiling LESS: ' + error.message;
    })))
    .pipe(concat('style.min.css'))
    .pipe(minifycss());

    return stream
    .pipe(gulp.dest('public/assets/css'));
});

// Fonts
gulp.task('fonts', function() {
    var stream = gulp
    .src([
        'node_modules/bootstrap/dist/fonts/*',
        'node_modules/font-awesome/fonts/*'
    ]);

    return stream
    .pipe(gulp.dest('public/assets/fonts'));
});

// Default task
gulp.task('default', function() {
    gulp.start('javascript', 'css', 'fonts');
});