var gulp       = require('gulp'),
    gutil      = require('gulp-util'),
    notify     = require('gulp-notify'),
    less       = require('gulp-less'),
    concat     = require('gulp-concat'),
    path       = require('path'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    watch      = require('gulp-watch'),
    bowerFiles = require('gulp-bower-files'),
    livereload = require('gulp-livereload'),
    browserify = require('gulp-browserify'),
    rename     = require('gulp-rename'),
    plumber    = require('gulp-plumber'),
    filter     = require('gulp-filter');

// Compile Less and save to css directory
gulp.task('public-less', function () {

    return gulp.src([
            'app/assets/less/public/master.less'
        ])
        .pipe(plumber())
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(rename('public.css'))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload())
        .pipe(notify('Public CSS minified'));

});

gulp.task('admin-less', function () {

    return gulp.src([
            'app/assets/less/admin/master.less'
        ])
        .pipe(plumber())
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(rename('admin.css'))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload())
        .pipe(notify('Admin CSS minified'));

});

// Publish fonts
gulp.task('fonts', function () {

    return gulp.src([
            'app/assets/components/font-awesome/fonts/*',
            'app/assets/components/flexslider/fonts/*'
        ])
        .pipe(gulp.dest('public/fonts'));

});

// Publish datepicker locales
gulp.task('datepicker-locales', function () {

    return gulp.src([
            'app/assets/components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.fr.js',
            'app/assets/components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.nl.js',
            'app/assets/components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.de.js',
        ])
        .pipe(gulp.dest('public/js/datepicker-locales'));

});

// Publish Fancybox images
gulp.task('fancybox-img', function () {

    return gulp.src([
            'app/assets/components/fancybox/source/*.gif',
            'app/assets/components/fancybox/source/*.png'
        ])
        .pipe(gulp.dest('public/components/fancybox/source'));

});

// Minify and save to target JS directory
gulp.task('public-js', function () {

    return gulp.src('app/assets/js/public/main.js')
        .pipe(browserify({
            debug: true
        }))
        .pipe(uglify())
        .pipe(rename('public/js/public/components.min.js'))
        .pipe(gulp.dest('./'))
        .pipe(notify('Public JS minified'));

});

gulp.task('components-js', function () {

    var jsFilter = filter('**/*.js');

    return bowerFiles({checkExistence: true})
        .pipe(jsFilter)
        .pipe(concat('bundle.js'))
        .pipe(uglify())
        .pipe(rename('components.min.js'))
        .pipe(gulp.dest('public/js/admin/'))
        .pipe(notify('Bower js files minified'));

});

gulp.task('components-custom-js', function () {

    return gulp.src([
            'app/assets/js/admin/jquery.mjs.nestedSortable.js',
            'app/assets/js/admin/jquery.nestedCookie.js',
            'app/assets/js/admin/jquery.slug.js',
            'app/assets/js/admin/jquery.listenhancer.js'
        ])
        .pipe(concat('components-custom.js'))
        .pipe(uglify())
        .pipe(rename('components-custom.min.js'))
        .pipe(gulp.dest('public/js/admin/'))
        .pipe(notify('Custom js plugins minified'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch('app/assets/less/public/**/*.less', ['public-less']);
    gulp.watch('app/assets/less/admin/**/*.less', ['admin-less']);
    gulp.watch('app/assets/less/*.less', ['public-less', 'admin-less']);
    gulp.watch('app/assets/js/public/**/*.js', ['public-js']);
    gulp.watch('app/assets/js/admin/**/*.js', ['components-js', 'components-custom-js']);
});

// What tasks does running gulp trigger?
gulp.task('default', [
    'public-less',
    'admin-less',
    'public-js',
    'components-js',
    'components-custom-js',
    'fonts',
    'datepicker-locales',
    'fancybox-img',
    'watch'
]);
