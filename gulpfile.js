'use strict';

var path = require('path');
var gulp = require('gulp');
var _if = require('gulp-if');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCss = require('gulp-clean-css');
var rename = require('gulp-rename');
var del = require('del');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var connectPhp = require('gulp-connect-php');
var fileinclude = require('gulp-file-include');

var options = require('./options');
var libs = require('./libs');

var paths = {
    sass: {
        src: options.srcDir + '/sass',
        dest: options.destDir + '/css',
        mask: '/*.+(sass|scss)'
    },
    js: {
        src: options.srcDir + '/js',
        dest: options.destDir + '/js',
        mask: '/*.js'
    },
    html: {
        src: options.srcDir + '/templates',
        dest: options.destDir + '/',
        mask: '/**/[^_]*.+(html|php)'
    },
    fonts: {
        src: options.srcDir + '/fonts',
        dest: options.destDir + '/fonts',
        mask: '/**/*.*'
    },
    watch: {
        sass: options.srcDir + '/sass/**/*.+(sass|scss)',
        js: options.srcDir + '/js/**/*.js',
        img: options.srcDir + '/img/**/*.+(png|jpg|jpeg|gif|svg)',
        html: options.srcDir + '/**/*.+(html|php)',
        fonts: options.srcDir + '/fonts/**/*'
    },
    vendor: {
        css: 'vendor.min.css',
        js: 'vendor.min.js'
    }
};

var handleError = function (err) {
    notify({
        title: 'Gulp Task Error',
        message: '!!!ERROR!!! Check the console.'
    }).write(err);
    console.log(err.toString());
    this.emit('end');
};

var handleWatchEvent = function (event, filePath, description) {
    if (event.type === 'deleted') {
        var filePathFromSrc = path.relative(path.resolve(filePath.src), event.path);
        var destFilePath = path.resolve(filePath.dest, filePathFromSrc);
        console.log(destFilePath);
        del.sync(destFilePath);
    }
    if (options.notifications) {
        notify({
            title: 'Gulp Task Complete',
            message: description + ' has been compiled'
        }).write('');
    }
};

gulp.task('sources:html', function () {
    if (options.useTemplates) {
        return gulp.src(paths.html.src + paths.html.mask)
            .pipe(plumber({errorHandle: handleError}))
            .pipe(fileinclude())
            .pipe(gulp.dest(paths.html.dest))
            .pipe(browserSync.stream({once: true}))
    }
});

gulp.task('sources:sass', function () {
    return gulp.src(paths.sass.src + paths.sass.mask)
        .pipe(plumber({errorHandle: handleError}))
        .pipe(_if(!options.production, sourcemaps.init()))
        .pipe(sass().on('error', handleError))
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
        .pipe(cleanCss())
        .pipe(rename({suffix: '.min'}))
        .pipe(_if(!options.production, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.sass.dest))
        .pipe(browserSync.stream({once: true}))
});

gulp.task('sources:js', function () {
    return gulp.src(paths.js.src + paths.js.mask)
        .pipe(plumber({errorHandle: handleError}))
        .pipe(_if(!options.production, sourcemaps.init()))
        .pipe(fileinclude())
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(_if(!options.production, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.js.dest))
        .pipe(browserSync.stream({once: true}))
});

gulp.task('sources:fonts', function () {
    return gulp.src(paths.fonts.src + paths.fonts.mask)
        .pipe(gulp.dest(paths.fonts.dest));
});

gulp.task('vendor:js', function () {
    return gulp.src(libs.scripts)
        .pipe(plumber({errorHandle: handleError}))
        .pipe(_if(!options.production, sourcemaps.init()))
        .pipe(concat(paths.vendor.js))
        .pipe(uglify())
        .pipe(_if(!options.production, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.js.dest));
});

gulp.task('vendor:styles', function () {
    return gulp.src(libs.styles)
        .pipe(plumber({errorHandle: handleError}))
        .pipe(sass().on('error', handleError))
        .pipe(_if(!options.production, sourcemaps.init()))
        .pipe(concat(paths.vendor.css))
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
        .pipe(cleanCss())
        .pipe(_if(!options.production, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.sass.dest))
});

gulp.task('clean', function () {
    if (options.useTemplates) {
        return del.sync([options.destDir + '/**/*', '!' + options.destDir + '/.gitkeep'], {dot: true});
    } else {
        return del.sync([
            paths.js.dest,
            paths.sass.dest,
            paths.fonts.dest
        ]);
    }
});

gulp.task('watch', ['build'], function () {
    gulp.watch(paths.watch.sass, ['sources:sass']).on('change', function (event) {
        handleWatchEvent(event, paths.sass, 'SASS')
    });
    gulp.watch(paths.watch.js, ['sources:js']).on('change', function (event) {
        handleWatchEvent(event, paths.js, 'JS')
    });
    gulp.watch(paths.watch.fonts, ['sources:fonts']).on('change', function (event) {
        handleWatchEvent(event, paths.fonts, 'FONTS')
    });
    if (options.useTemplates) {
        gulp.watch(paths.watch.html, ['sources:html']).on('change', function (event) {
            handleWatchEvent(event, paths.html, 'HTML')
        });
    }
});

gulp.task('php', ['watch'], function () {
    connectPhp.server({base: './', keepalive: true, hostname: options.phpProxyHost, phpProxyPort: options.phpProxyPort, open: false});
    browserSync.init({
        proxy: '127.0.0.1:8000',
        notify: options.notifications,
        open: options.openBrowser
    });
});

gulp.task('live', ['watch'], function () {
    browserSync.init({
        server: {
            baseDir: options.destDir
        },
        notify: options.notifications,
        open: options.openBrowser
    });
});

gulp.task('build', [
    'clean',
    'vendor:styles',
    'vendor:js',
    'sources:sass',
    'sources:js',
    'sources:html',
    'sources:fonts'
]);

gulp.task('production', function () {
    options.production = true;
    gulp.run(['sources:sass', 'sources:js'])
});

gulp.task('vendor', ['vendor:styles', 'vendor:js']);

gulp.task('default', ['build']);
