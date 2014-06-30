var gulp       = require('gulp'),
    gutil      = require('gulp-util'),
    notify     = require('gulp-notify'),
    less       = require('gulp-less'),
    concat     = require('gulp-concat'),
    path       = require('path'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    watch      = require('gulp-watch'),
    bower      = require('gulp-bower-files'),
    livereload = require('gulp-livereload'),
    browserify = require('gulp-browserify'),
    rename     = require('gulp-rename'),
    plumber    = require('gulp-plumber');

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
        .pipe(notify('Admin CSS minified'));

});

// Publish fonts
gulp.task('fonts', function () {

    return gulp.src([
            'app/assets/components/font-awesome/fonts/*'
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

gulp.task('admin-js', function () {

    return gulp.src([
            'app/assets/components/jquery/jquery.js',
            // jQuery-ui
            'app/assets/components/jquery-ui/ui/jquery-ui.js',
            'app/assets/components/jquery-ui/ui/jquery.ui.core.js',
            'app/assets/components/jquery-ui/ui/jquery.ui.mouse.js',
            'app/assets/components/jquery-ui/ui/jquery.ui.widget.js',
            'app/assets/components/jquery-ui/ui/jquery.ui.sortable.js',
            // Alertify
            'app/assets/components/alertify.js/lib/alertify.js',
            // Fancybox
            'app/assets/components/fancybox/source/jquery.fancybox.js',
            // Bootstrap
            'app/assets/components/bootstrap/js/dropdown.js',
            'app/assets/components/bootstrap/js/collapse.js',
            'app/assets/components/bootstrap/js/alert.js',
            'app/assets/components/bootstrap/js/tab.js',
            'app/assets/components/bootstrap/js/transition.js',
            // Selectize
            'app/assets/components/sifter/sifter.js',
            'app/assets/components/microplugin/src/microplugin.js',
            'app/assets/components/selectize/dist/js/selectize.js',
            // Dropzone
            'app/assets/components/dropzone/downloads/dropzone.js',
            // Date & Time Picker
            'app/assets/components/moment/moment.js',
            'app/assets/components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js',
            // Other
            'public/components/jquery.mjs.nestedSortable.js',
            'public/components/jquery.nestedCookie.js',
            'public/components/jquery.listenhancer.js',
            'public/components/jquery.slug.js'
        ])
        .pipe(concat('bundle.js'))
        .pipe(uglify())
        .pipe(rename('public/js/admin/components.min.js'))
        .pipe(gulp.dest('./'))
        .pipe(notify('Admin JS minified'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch('app/assets/less/public/**/*.less', ['public-less']);
    gulp.watch('app/assets/less/admin/**/*.less', ['admin-less']);
    gulp.watch('app/assets/less/*.less', ['public-less', 'admin-less']);
    gulp.watch('public/js/public/**/*.js', ['public-js']);
    gulp.watch('public/js/admin/**/*.js', ['admin-js']);
});

// gulp.task('bower', function(){
//     bower().pipe(gulp.dest('public/vendor'));
// });

// What tasks does running gulp trigger?
// gulp.task('default', ['public-less', 'admin-less', 'public-js', 'admin-js', 'fonts', 'datepicker-locales', 'fancybox-img', 'watch']);
gulp.task('default', ['public-less', 'public-js', 'admin-js', 'fonts', 'datepicker-locales', 'fancybox-img', 'watch']);
