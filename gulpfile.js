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
    filter     = require('gulp-filter'),
    imagemin   = require('gulp-imagemin'),
    prefix     = require('gulp-autoprefixer');

function swallowError (error) {
    console.log(error.toString());
    this.emit('end');
}
// Compile Less and save to css directory
gulp.task('less-public', function () {

    return gulp.src([
            'app/assets/less/public/master.less'
        ])
        .pipe(less())
        .on('error', swallowError)
        .pipe(prefix())
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
        .pipe(less())
        .on('error', swallowError)
        .pipe(prefix())
        .pipe(minifyCSS())
        .pipe(rename('admin.css'))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload())
        .pipe(notify('Admin CSS minified'));

});

gulp.task('img', function () {
    return gulp.src('app/assets/img/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}]
        }))
        .pipe(gulp.dest('public/img'));
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

gulp.task('js-admin', function () {

    var files = bowerFiles({checkExistence: true});
    
    files.push(
        path.resolve() + '/app/assets/js/offcanvas.js',
        path.resolve() + '/app/assets/js/admin/jquery.mjs.nestedSortable.js',
        path.resolve() + '/app/assets/js/admin/jquery.nestedCookie.js',
        path.resolve() + '/app/assets/js/admin/jquery.slug.js',
        path.resolve() + '/app/assets/js/admin/jquery.listenhancer.js'
    );

    return gulp.src(files)
        .pipe(filter([
            '**/*.js',
            '!tinymce*'
        ]))
        .pipe(concat('components.js'))
        .pipe(uglify())
        .pipe(rename('components.min.js'))
        .pipe(gulp.dest('public/js/admin/'))
        .pipe(notify('js-admin done'));

});

gulp.task('js-public', function () {

    var files = bowerFiles({checkExistence: true});
    
    files.push(path.resolve() + '/app/assets/js/offcanvas.js');

    return gulp.src(files)
        .pipe(filter([
            '**/*.js',
            '!tinymce*',
            '!jquery-ui*',
            '!jquery.ui*',
            '!picker*',
            '!sifter*',
            '!microplugin*',
            '!alertify*',
            '!selectize*',
            '!lib/fastclick.js',
            '!dropzone*'
        ]))
        .pipe(concat('components.js'))
        .pipe(uglify())
        .pipe(rename('components.min.js'))
        .pipe(gulp.dest('public/js/public'))
        .pipe(notify('js-public done'));

});

// Keep an eye on Less and JS files for changes…
gulp.task('watch', function () {
    gulp.watch('app/assets/less/public/**/*.less', ['less-public']);
    gulp.watch('app/assets/less/admin/**/*.less', ['less-admin']);
    gulp.watch('app/assets/less/*.less', ['less-public', 'less-admin']);
    gulp.watch('app/assets/js/public/**/*.js', ['js-public']);
    gulp.watch('app/assets/js/admin/**/*.js', ['js-admin']);
});

// launch all
gulp.task('all', [
    'less-public',
    'less-admin',
    'js-public',
    'js-admin',
    'fonts',
    'pickadate-locales',
    'fancybox-img',
    'watch'
]);

// What tasks does running gulp trigger?
gulp.task('default', ['less-public', 'less-admin', 'watch']);
