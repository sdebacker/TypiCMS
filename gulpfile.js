var gulp = require('gulp');
var gutil = require('gulp-util');
var less = require('gulp-less');
var path = require('path');
var csso = require('gulp-csso');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var watch = require('gulp-watch');

var publicJsFiles = [
  'public/components/vendor/jquery-legacy/jquery.js',
  'public/components/vendor/bootstrap/js/dropdown.js',
  'public/components/vendor/fancybox/source/jquery.fancybox.js',
  'public/js/live-search.js',
  'public/js/gmaps.js',
  'public/js/public.js'
];

gulp.task('default', function () {

  gulp.run('public-css');
  gulp.run('public-js');

  gulp.watch('app/assets/less/*.less', function(){
    gulp.run('public-css');
  })

  gulp.watch(publicJsFiles, function(){
    gulp.run('public-js');
  })

});

gulp.task('public-css', function () {

  gulp.src([
      'app/assets/less/public.less'
    ])
    .pipe(less())
    .pipe(csso())
    .pipe(concat('public.css'))
    .pipe(gulp.dest('public/css'));

});

gulp.task('public-js', function () {

  gulp.src(publicJsFiles)
    .pipe(uglify())
    .pipe(concat('public.min.js'))
    .pipe(gulp.dest('public/js'))

});
