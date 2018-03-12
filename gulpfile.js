'use strict';

var gulp = require('gulp'),
  minify = require('gulp-minify'),
  rename = require('gulp-rename'),
  imagemin = require('gulp-imagemin'),
  del = require('del'),
  cache = require('gulp-cache'),
  cleanCSS = require('gulp-clean-css'),
  imageResize = require('gulp-image-resize'),
  autoprefixer = require('gulp-autoprefixer'),
  debug = require('gulp-debug'),
  purify = require('gulp-purify-css'),
  concat = require('gulp-concat');

gulp.task('css', function () {
  return gulp
    .src([
      'resources/css/**/*.css',
      '!resources/css/required/**/*.css'
    ])
    .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
    .pipe(cleanCSS({level: 2}))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('web/css'));
});

gulp.task('css_required', function () {
  return gulp
    .src([
      'resources/css/required/woocommerce-smallscreen.css',
      'resources/css/required/font-face.css',
      'resources/css/required/offsets.css',
      'resources/css/required/bootstrap.css',
      'resources/css/required/font-awesome.css',
      'resources/css/required/simple-line-icons.css',
      'resources/css/required/webfont.css',
      'resources/css/required/jquery.smartmenus.bootstrap.css',
      'resources/css/required/style-theme.css',
      'resources/css/required/style-woocommerce.css',
      'resources/css/required/style-shortcodes.css',
      'resources/css/required/prettyPhoto.css',
      'resources/css/required/jquery-ui.css',
      'resources/css/required/owlcarousel/owl.carousel.css',
      'resources/css/required/owlcarousel/owl.theme.default.css',
      'resources/css/required/tooltipster.bundle.css',
      'resources/css/required/style.css',
      'resources/css/required/multiselect.css'
    ], {base: 'resources/css/required/'})
    .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
    // .pipe(rename({suffix: '.min'}))
    .pipe(concat("required.min.css"))
    // .pipe(uncss({
    //   html: ['views/**/*.*']
    // }))
    .pipe(purify(['./views/**/*.php', './resources/js/**/*.js']))
    .pipe(cleanCSS({level: 2}))
    .pipe(gulp.dest('web/css'));
});

gulp.task('css-images', function () {
  return gulp.src(['resources/css/images/**/*'], {base: 'resources/css/'})
    .pipe(debug({title: 'css images:'}))
    .pipe(gulp.dest('web/css/'));
});

gulp.task('css-jqm-images', function () {
  return gulp.src(['resources/css/jqmobile/images/**/*'], {base: 'resources/css/jqmobile/'})
    .pipe(debug({title: 'jqmobile images:'}))
    .pipe(gulp.dest('web/css/jqmobile/'));
});

gulp.task('owl-images', function () {
  return gulp.src(['resources/css/required/owlcarousel/**/*.{gif,jpg,png,svg}'], {base: 'resources/css/required'})
    .pipe(debug({title: 'owlcarousel images:'}))
    .pipe(gulp.dest('web/css/'));
});

gulp.task('other-images', function () {
  return gulp.src(['resources/images/**/*'], {base: 'resources/images/'})
    .pipe(debug({title: 'other images:'}))
    .pipe(gulp.dest('web/images/'));
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
      width: 345,
      height: 210,
      crop: true,
      upscale: false
    })).pipe(rename(function (opt) {
      opt.basename = opt.basename.replace(/^v_/, 'b_');
      return opt;
    })).pipe(gulp.dest('web/images/products_'));
});

gulp.task('shop_images_resize_p', ['shop_images_minify'], function () {
  return gulp.src(['web/images/products_/v_*.*'])
    .pipe(imageResize({
      width: 100,
      height: 70,
      crop: true,
      upscale: false
    })).pipe(rename(function (opt) {
      opt.basename = opt.basename.replace(/^v_/, '');
      return opt;
    })).pipe(gulp.dest('web/images/products_'));
});

gulp.task('refactor_controllers', function () {
  return gulp.src(['controllers/controller_*.php'])
    .pipe(rename(function (opt) {
      opt.basename = opt.basename.replace(/^controller_/, '');
      opt.basename = 'Controller' + opt.basename.charAt(0).toUpperCase() + opt.basename.slice(1);
      return opt;
    })).pipe(gulp.dest('controllers'));
});

gulp.task('shop_images', ['shop_images_minify', 'shop_images_resize_b', 'shop_images_resize_p']);

gulp.task('images', ['other-images', 'css-images', 'css-jqm-images', 'owl-images']);

gulp.task('scripts', function () {
  return gulp.src([
    'resources/js/**/*.js',
    '!resources/js/jquery3/jquery-3.1.1.js',
    '!resources/js/jquery3/jquery-migrate-3.0.0.js',
    '!resources/js/bootstrap.js',
    '!resources/js/jquery-ui.js',
    '!resources/js/jquery.smartmenus.js',
    '!resources/js/jquery.smartmenus.bootstrap.js',
    '!resources/js/jquery.prettyPhoto.js',
    '!resources/js/inputmask/jquery.inputmask.bundle.js',
    '!resources/js/owlcarousel/owl.carousel.js',
    '!resources/js/tooltipster.bundle.js',
    '!resources/js/jqmobile/jquery.mobile.custom.js',
    '!resources/js/multiselect.js',
    '!resources/js/search/search.js',
    '!resources/js/script.js'
  ])
    .pipe(minify({
      ext: {
        min: '.min.js'
      },
      noSource: true
    }))
    // .pipe(rename({
    //   suffix: ".min"
    // }))
    .pipe(gulp.dest('web/js'));
});

gulp.task('scripts_required', function () {
  return gulp.src([
    'resources/js/jquery3/jquery-3.1.1.js',
    'resources/js/jquery3/jquery-migrate-3.0.0.js',
    'resources/js/bootstrap.js',
    'resources/js/jquery-ui.js',
    'resources/js/jquery.smartmenus.js',
    'resources/js/jquery.smartmenus.bootstrap.js',
    'resources/js/jquery.prettyPhoto.js',
    'resources/js/inputmask/jquery.inputmask.bundle.js',
    'resources/js/owlcarousel/owl.carousel.js',
    'resources/js/tooltipster.bundle.js',
    'resources/js/jqmobile/jquery.mobile.custom.js',
    'resources/js/multiselect.js',
    'resources/js/search/search.js',
    'resources/js/script.js'
  ])
    .pipe(minify({
      noSource: true
    }))
    .pipe(concat("required.min.js"))
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


gulp.task('watch', ['clean', 'fonts', 'css', 'css_required', 'scripts', 'scripts_required', 'images'], function () {
  gulp.watch('resources/sass/**/*.sass', ['sass']);
  gulp.watch('resources/sass/**/*.scss', ['sass']);
  gulp.watch('resources/css/**/*.css', ['css', 'css_required']);
  gulp.watch('resources/js/**/*.js', ['scripts', 'scripts_required']);
});

gulp.task('build', ['clean', 'fonts', 'css', 'css_required', 'scripts', 'scripts_required', 'images']);

gulp.task('default', ['watch']);
