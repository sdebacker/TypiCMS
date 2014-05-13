var gulp       = require('gulp'),
    gutil      = require('gulp-util'),
    notify     = require('gulp-notify'),
    less       = require('gulp-less'),
    path       = require('path'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    concat     = require('gulp-concat'),
    watch      = require('gulp-watch'),
    bowerFiles = require("gulp-bower-files"),
    livereload = require("gulp-livereload"),
    plumber    = require("gulp-plumber");

var publicJsFiles = [
  'public/components/vendor/jquery-legacy/jquery.js',
  'public/components/vendor/bootstrap/js/dropdown.js',
  'public/components/vendor/fancybox/source/jquery.fancybox.js',
  'public/js/live-search.js',
  'public/js/gmaps.js',
  'public/js/public.js'
];

// Where do you store your Less files?
var lessDir = 'app/assets/less';

// Compile Less, concat and save to target CSS directory
gulp.task('public-less', function () {

  return gulp.src([
      lessDir + '/public.less'
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
      lessDir + '/admin.less'
    ])
    .pipe(plumber())
    .pipe(less())
    .pipe(minifyCSS())
    .pipe(gulp.dest('public/css'))
    .pipe(notify('Admin CSS minified'));

});

// Minify, concat and save to target JS directory
gulp.task('public-js', function () {

  return gulp.src(publicJsFiles)
    .pipe(plumber())
    .pipe(uglify())
    .pipe(concat('public.min.js'))
    .pipe(gulp.dest('public/js'))
    .pipe(notify('Public JS minified'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch(lessDir + '/*.less', ['public-less', 'admin-less']);
    gulp.watch(publicJsFiles, ['public-js']);
});

gulp.task("bowerFiles", function(){
    bowerFiles().pipe(gulp.dest("public/vendor"));
});

// What tasks does running gulp trigger?
gulp.task('default', ['bowerFiles', 'public-less', 'admin-less', 'public-js', 'watch']);
