
const entry = {
    sass: './_src/sass/**/*.scss'
}

const output = {
    css: 'public/assets/css'
}

const sassVar = {
    PROJECT_NAME: 'yuan',
}

const port = 8100;
// 引入依賴
const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const connectPHP = require('gulp-connect-php');
const sass = require('gulp-sass')(require('sass'));
const sassVars = require('gulp-sass-vars');
const autoprefixer = require('gulp-autoprefixer');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');


// 編譯 SASS
function compileSASS() {
    return gulp.src([entry.sass])
        .pipe(sassVars(sassVar, { verbose: true }))
        .pipe(plumber(function (err) {
            console.log('SASS Compile Error:', err.message);
            this.emit('end');
        }))
        .pipe(sourcemaps.init()) // 初始化 sourcemaps
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ["node_modules"],
        }))
        .pipe(autoprefixer({
            overrideBrowserslist: [
                "last 2 version",
                "> 1%",
                "IE 9",
                "safari 7",
                "safari 8"
            ],
            cascade: false,
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(output.css))
        .pipe(browserSync.stream());
}

// 監控 SASS 文件
function watchSass() {
    return gulp.watch(entry.sass, compileSASS);
}

// 開啟預設的 HTTP 伺服器並監控檔案
function serveDefault() {
    browserSync.init({
        server: './public/',
        port: port,
    });

    gulp.watch([entry.sass], gulp.series(compileSASS));
    gulp.watch(['dist/*.html']).on('change', browserSync.reload);
}

// 開啟 PHP 伺服器並監控檔案
function servePHP() {
    connectPHP.server({
        // 設定伺服器的根目錄
        base: `./public/`,
        // 選擇一個不常用的埠以避免衝突
        port: port,
        // 保持伺服器開啟
        keepalive: true,
        // bin: 'D:\\PHP-8.2\\php.exe',
        bin: 'D:\\xampp\\php\\php.exe',
    }, function () {
        browserSync.init({
            // 代理到剛剛啟動的 PHP 伺服器
            proxy: 'localhost:' + port,
            // 設定 browserSync 的監聽埠，避免與 PHP 伺服器埠衝突
            port: 8201,
        });
    });

    gulp.watch([entry.sass], compileSASS);
    gulp.watch(['./app/Views/**/*', './app/Controllers/**/*', './public/assets/js/**/*']).on('change', browserSync.reload);

    // gulp.watch(['dist/*.php']).on('change', browserSync.reload);
}



exports.default = gulp.series(compileSASS, serveDefault);
exports.php = gulp.series(compileSASS, servePHP);
exports.sass = gulp.series(compileSASS, watchSass);