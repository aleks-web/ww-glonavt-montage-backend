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

// Слежка за файлами
export function watching() {
    gulp.watch([`${dir.appScss}/**/*.scss`, `${dir.appComponents}/*.scss`], sass);
    gulp.watch([`${dir.appJs}/**/*.js`, `${dir.appComponents}/*.js`], js);
}

// За какой папкой следить
export function browsersync() {
    browserSync.init({
        server: {
            baseDir: folderDist,
        }
    });
}

export default gulp.parallel(browsersync, sass, watching);