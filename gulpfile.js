var gulp       = require('gulp'),
    gutil      = require('gulp-util'),
    notify     = require('gulp-notify'),
    less       = require('gulp-less'),
    concat     = require('gulp-concat'),
    path       = require('path'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    watch      = require('gulp-watch'),
    bowerFiles = require('main-bower-files'),
    livereload = require('gulp-livereload'),
    rename     = require('gulp-rename'),
    plumber    = require('gulp-plumber'),
    filter     = require('gulp-filter');

// Compile Less and save to css directory
gulp.task('less-public', function () {

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

gulp.task('less-admin', function () {

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

// Publish pickadate locales
gulp.task('pickadate-locales', function () {

    return gulp.src([
            'app/assets/components/pickadate/lib/translations/fr_FR.js',
            'app/assets/components/pickadate/lib/translations/nl_NL.js',
        ])
        .pipe(gulp.dest('public/js/pickadate-locales'));

});

// Publish Fancybox images
gulp.task('fancybox-img', function () {

    return gulp.src([
            'app/assets/components/fancybox/source/*.gif',
            'app/assets/components/fancybox/source/*.png'
        ])
        .pipe(gulp.dest('public/components/fancybox/source'));

});

gulp.task('js-components', function () {

    return gulp.src(bowerFiles({checkExistence: true}))
        .pipe(filter('**/*.js'))
        .pipe(concat('components.js'))
        .pipe(uglify())
        .pipe(rename('components.min.js'))
        .pipe(gulp.dest('public/js/'))
        .pipe(notify('Bower js files minified'));

});

gulp.task('js-admin', function () {

    return gulp.src([
            'app/assets/js/admin/jquery.mjs.nestedSortable.js',
            'app/assets/js/admin/jquery.nestedCookie.js',
            'app/assets/js/admin/jquery.slug.js',
            'app/assets/js/admin/jquery.listenhancer.js'
        ])
        .pipe(concat('components-admin.js'))
        .pipe(uglify())
        .pipe(rename('components-admin.min.js'))
        .pipe(gulp.dest('public/js/admin/'))
        .pipe(notify('Custom js plugins minified'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch('app/assets/less/public/**/*.less', ['less-public']);
    gulp.watch('app/assets/less/admin/**/*.less', ['less-admin']);
    gulp.watch('app/assets/less/*.less', ['less-public', 'less-admin']);
    gulp.watch('app/assets/js/public/**/*.js', ['public-js']);
    gulp.watch('app/assets/js/admin/**/*.js', ['js-admin']);
});

// What tasks does running gulp trigger?
gulp.task('default', [
    'less-public',
    'less-admin',
    'js-components',
    'js-admin',
    'fonts',
    'pickadate-locales',
    'fancybox-img',
    'watch'
]);
