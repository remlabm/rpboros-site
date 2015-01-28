'use strict';

var gulp = require('gulp')
    ,  refresh = require('gulp-livereload')
    , connect = require('gulp-connect')
    ;

gulp.task('connect', function() {
    connect.server({
        root: 'src',
        livereload: true
    });
});

gulp.task('html', function () {
    gulp.src('./src/*.html')
        .pipe(connect.reload());
    refresh.changed('');

});

gulp.task('watch', function () {
    refresh.listen();
    gulp.watch(['./src/*.html'], ['html']);
    gulp.watch(['./src/*/*.css', './src/*.js']).on('change', refresh.changed);
});

gulp.task('default', ['connect', 'watch']);