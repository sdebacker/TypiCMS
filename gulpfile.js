var gulp       = require('gulp'),
    gutil      = require('gulp-util'),
    notify     = require('gulp-notify'),
    less       = require('gulp-less'),
    path       = require('path'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    watch      = require('gulp-watch'),
    bower      = require('gulp-bower-files'),
    livereload = require('gulp-livereload'),
    browserify = require('gulp-browserify'),
    rename     = require('gulp-rename'),
    plumber    = require('gulp-plumber');

// Compile Less and save to target CSS directory
gulp.task('public-less', function () {

    return gulp.src([
            'app/assets/less/public/public.less'
        ])
        .pipe(plumber())
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
        .pipe(livereload())
        .pipe(notify('Public CSS minified'));

});

gulp.task('admin-less', function () {

    return gulp.src([
            'app/assets/less/admin/admin.less'
        ])
        .pipe(plumber())
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
        .pipe(notify('Admin CSS minified'));

});

// Minify and save to target JS directory
gulp.task('public-js', function () {

    return gulp.src('public/js/public/main.js')
        .pipe(browserify({
            debug: true
        }))
        .pipe(uglify())
        .pipe(rename('public/js/public/bundle.js'))
        .pipe(gulp.dest('./'))
        .pipe(notify('Public JS minified'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch('app/assets/less/public/**/*.less', ['public-less']);
    gulp.watch('app/assets/less/admin/**/*.less', ['admin-less']);
    gulp.watch('app/assets/less/*.less', ['public-less', 'admin-less']);
    gulp.watch('public/js/public/**/*.js', ['public-js']);
});

gulp.task('bower', function(){
    bower().pipe(gulp.dest('public/vendor'));
});

// What tasks does running gulp trigger?
gulp.task('default', ['bower', 'public-less', 'admin-less', 'public-js', 'watch']);
