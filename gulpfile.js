import gulp from 'gulp'; // Gulp
import fileinclude from 'gulp-file-include';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
const scss = gulpSass(dartSass);
import sourceMaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';
import sassGlob from 'gulp-sass-glob';
import browserSync from 'browser-sync';


const folderApp = "public/assets";
const folderDist = "public/assets";
const proxyUrl = "crm-backend.ru";

const dir = {
    // Дирректории приложения
    appScss: `${folderApp}/scss`,
    appCss: `${folderApp}/css`,
    appComponents: `${folderApp}/components`,

    // Итоговые дирректории
    distCss: `${folderDist}/css`,
    distJs: `${folderDist}/js`,
}

export function sass() {
    return gulp.src([`${dir.appScss}/main.scss`])
        .pipe(sourceMaps.init())
        .pipe(sassGlob())
        .pipe(scss())
        .pipe(concat('main.css'))
        .pipe(sourceMaps.write())
        .pipe(gulp.dest(dir.distCss))
        .pipe(browserSync.stream())
}

/*
    Слежка за файлами
*/
export function watching() {
    gulp.watch([`${dir.appScss}/**/*.scss`, `${dir.appComponents}/*.scss`], sass);
    gulp.watch([`${dir.appJs}/**/*.js`, `${dir.appComponents}/*.js`]);
}

/*
    Для локальной разработки.

    * Инструкция по использованию (локально):
    * Связка OpenServer или Docker
    * Когда запускается локальный сервер и локально доступен сайт (например по ссылке crm-backend.ru или localhost:9999), ссылку нужно указать в константу proxyUrl
    * После этого нужно запустить команду gulp находясь в той же дирректории, что и файл gulpfile.js

    * Инструкция по использованию (на рабочем сервере):
    * Если crm уже лежит на сервере и работает, то командой gulp пользоваться не нужно
    * Нужно просто ввести gulp sass для перекомпиляции стилей. И все. Либо gulp watching
*/
export function browsersync() {
    browserSync.init({
        proxy: proxyUrl
    });
}

export default gulp.parallel(browsersync, sass, watching);