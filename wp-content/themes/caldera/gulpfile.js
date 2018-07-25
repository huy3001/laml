/**
 * Created by Nguyen Cong Huy on 9/30/2015.
 */

// Requires the gulp and gulp-sass plugins
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoPrefixer = require('gulp-autoprefixer'),
    concatCss = require('gulp-concat-css'),
    browserSync = require('browser-sync');

// Create task for browser sync
gulp.task('browserSync', function() {
    browserSync({
        proxy: 'http://laml.dev.sutunam.com/'
    })
});

// Create task for compile sass to css
gulp.task('sass', function() {
    return gulp.src('assets/sass/custom.scss')
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(autoPrefixer())
        .pipe(concatCss('custom.css'))
        .pipe(gulp.dest('assets/css/'))
        .pipe(browserSync.stream({
            match: '**/*.css'
        }))
});

// Create task for watch changes
gulp.task('watch', ['browserSync', 'sass'], function() {
    // Watch changes of files
    gulp.watch('assets/sass/**/*.scss', ['sass']);
    gulp.watch('assets/js/**/*.js', browserSync.reload);
    gulp.watch('**/*.php', browserSync.reload);
});

// Default task for gulp
gulp.task('default', ['sass', 'watch']);
