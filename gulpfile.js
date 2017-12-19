'use strict';

var gulp = require('gulp'),
  minify = require('gulp-minify'),
  rename = require('gulp-rename'),
  imagemin = require('gulp-imagemin'),
  del = require('del'),
  cache = require('gulp-cache'),
  cleanCSS = require('gulp-clean-css'),
  imageResize = require('gulp-image-resize'),
  autoprefixer = require('gulp-autoprefixer');

gulp.task('css', function () {
  return gulp
    .src('resources/css/**/*.css')
    .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
    .pipe(cleanCSS({level: 2}))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('web/css'));
});
gulp.task('css-images', function () {
  return gulp.src(['resources/css/images/**/*.*'])
    .pipe(gulp.dest('web/css/images'));
});
gulp.task('css-jqm-images', function () {
  return gulp.src(['resources/css/jqmobile/images/**/*.*'])
    .pipe(gulp.dest('web/css/jqmobile/images'));
});
gulp.task('owl-images', function () {
  return gulp.src(['resources/owlcarousel/*.gif', 'resources/owlcarousel/*.png'])
    .pipe(gulp.dest('web/css/owlcarousel'));
});

gulp.task('shop_images_minify', function () {
  return gulp.src(['web/images/products/v_*.*'])
    .pipe(imagemin([
      imagemin.gifsicle({interlaced: true}),
      imagemin.jpegtran({progressive: true}),
      imagemin.optipng({optimizationLevel: 5})
    ]))
    .pipe(gulp.dest('web/images/products_'));
});
gulp.task('shop_images_resize_b', ['shop_images_minify'], function () {
  return gulp.src(['web/images/products_/v_*.*'])
    .pipe(imageResize({
      width : 345,
      height : 210,
      crop : true,
      upscale : false
    })).pipe(rename(function(opt) {
      opt.basename = opt.basename.replace(/^v_/, 'b_');
      return opt;
    })).pipe(gulp.dest('web/images/products_'));
});
gulp.task('shop_images_resize_p', ['shop_images_minify'], function () {
  return gulp.src(['web/images/products_/v_*.*'])
    .pipe(imageResize({
      width : 100,
      height : 70,
      crop : true,
      upscale : false
    })).pipe(rename(function(opt) {
      opt.basename = opt.basename.replace(/^v_/, '');
      return opt;
    })).pipe(gulp.dest('web/images/products_'));
});

gulp.task('shop_images', ['shop_images_minify','shop_images_resize_b','shop_images_resize_p']);

gulp.task('images', ['css-images', 'css-jqm-images', 'owl-images']);
gulp.task('scripts', function () {
  return gulp.src('resources/js/**/*.js')
    .pipe(minify({
        ext: {
          min: '.min.js'
        },
        noSource: true
      })
    )
    .pipe(gulp.dest('web/js'));

});

gulp.task('fonts', function () {
  return gulp.src([
    'resources/fonts/**/*.*'
  ]).pipe(gulp.dest('web/fonts'));
});

gulp.task('clean', function () {
  return del.sync([
    'web/js', 'web/css', 'web/fonts'
  ]);
});

gulp.task('clear', function (callback) {
  return cache.clearAll();
});


gulp.task('watch', ['clean', 'fonts', 'css', 'scripts', 'images'], function () {
  gulp.watch('resources/sass/**/*.sass', ['sass']);
  gulp.watch('resources/sass/**/*.scss', ['sass']);
  gulp.watch('resources/css/**/*.css', ['css']);
  gulp.watch('resources/js/**/*.js', ['scripts']);
});
gulp.task('default', ['watch']);
