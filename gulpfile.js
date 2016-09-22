var gulp = require("gulp"),
    uglify = require("gulp-uglify"),
    rename = require("gulp-rename");

gulp.task("minify_js", function () {
    return gulp.src('./public/js/**/*.js')
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./public/dist/angular/'));
});

gulp.task("watch_and_minify", function () {
    return gulp.watch(['./public/js/**/*.js'], ['minify_js']);
});