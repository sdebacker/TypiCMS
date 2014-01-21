var gulp = require('gulp');
var gutil = require('gulp-util');
var less = require('gulp-less');
var path = require('path');
var csso = require('gulp-csso');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');

gulp.task('default', function () {

  gulp.src([
      'app/assets/less/public.less'
    ])
    .pipe(watch())
    .pipe(plumber())
    .pipe(less())
    .pipe(csso())
    .pipe(concat('public.css'))
    .pipe(gulp.dest('public/css'));

  gulp.src([
      'app/assets/less/admin.less'
    ])
    .pipe(watch())
    .pipe(plumber())
    .pipe(less())
    .pipe(csso())
    .pipe(concat('admin.css'))
    .pipe(gulp.dest('public/css'));

  gulp.src([
      'public/components/vendor/jquery-legacy/jquery.js',
      'public/components/vendor/bootstrap/js/dropdown.js',
      'public/components/vendor/fancybox/source/jquery.fancybox.js',
      'public/js/live-search.js',
      'public/js/gmaps.js',
      'public/js/public.js'
    ])
    .pipe(watch())
    .pipe(plumber())
    .pipe(uglify())
    .pipe(concat('public.libs.min.js'))
    .pipe(gulp.dest('public/js'))

});
