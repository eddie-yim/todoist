'use strict';

var gulp = require('gulp');

var sass = require('gulp-sass');

gulp.task('default', ['sass', 'sass:watch'], function (defaultTasks) {
    console.log('gulp start');
});

gulp.task('sass', function(){
    return gulp.src('styles/resource/**/*.sass')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('styles/public'));
});

gulp.task('sass:watch', function(){
    gulp.watch('styles/resource/**/*.sass', ['sass']);
});