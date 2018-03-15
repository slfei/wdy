var gulp = require('gulp')
var path = require('path')
var babel = require('gulp-babel')
var stylus = require('gulp-stylus')
var webpack = require('webpack')
var named = require('vinyl-named')
var foreach = require('gulp-foreach')
var merge = require('merge-stream');
var glob = require('glob');
var webpackConf = require('./conf/webpack.base')
var postcss = require('gulp-postcss');

var rimraf = require('rimraf')
var gulpSequence = require('gulp-sequence')

var rev = require('gulp-rev')
var revCollector = require('gulp-rev-collector')

try{
    var env_conf = require('./.env_conf')    
}catch(e){
    var env_conf = {
        static_host: '//s1.wdyedu.com/static/'
    }
}

console.log(env_conf);

gulp.task('compile-css', function () {
    var styl = stylus({
        'include css': true,
    })
    styl.on('error', function(e){
        console.log(e);
        styl.end();
    });
    return gulp.src("src/css/**/*.styl")
        .pipe(styl)
        // .pipe(postcss())
        .pipe(gulp.dest('static/css'))
})

gulp.task('compile-lib-css', function(){
    gulp.src("src/lib/weui/dist/style/weui.css")
        .pipe(postcss())
        .pipe(gulp.dest('src/lib/weui/dist/style/weui-posted.css'))
})

// https://stackoverflow.com/questions/38250872/how-to-output-files-to-the-parent-of-their-source-directory-using-webpack-in-gul
gulp.task('compile-js', function (callback) {
    //var pathPrefix = path.resolve(__dirname, 'src/js');
    //return gulp.src("src/js/page/**/*.js")
    //    .pipe(foreach(function(stream, file){
    //        var dirPrefix = path.dirname(file.path.slice(pathPrefix.length))
    //        return stream
    //            .pipe(named())
    //            .pipe(require('webpack-stream'))
    //            .pipe(gulp.dest("static/js" + dirPrefix))
    //    }))

    var entry = {};
    glob.sync("src/js/page/**/*.js").map(function(file) {
        entry[file.replace('src', 'static')] = path.join(__dirname, file);
    });
    var config = Object.assign({}, webpackConf, {
        entry: entry,
        output: {
            path: __dirname,
            filename: '[name]'
        }
    });
    console.dir(config)
    var flag = true;
    webpack(config, function(err, stat) {
        if (err) {
            console.log(err);
            flag && callback();
            return flag = false;
        }
        var jsonStat = stat.toJson();
        if (jsonStat.errors.length > 0) {
            var errorMessage = jsonStat.errors.reduce(function (resultMessage, nextError) {
                resultMessage += nextError.toString();
                return resultMessage;
            }, '');
            console.log(errorMessage)
        }
        flag && callback();
        return flag = false;
    });
});

gulp.task('compile-js:watch', function(callback){
    webpackConf.watch = true;
    var entry = {};
    glob.sync("src/js/page/**/*.js").map(function(file) {
        entry[file.replace('src', 'static')] = path.join(__dirname, file);
    });
    var config = Object.assign({}, webpackConf, {
        entry: entry,
        output: {
            path: __dirname,
            filename: '[name]'
        }
    });
    console.dir(config)
    var flag = true;
    webpack(config, function(err, stat) {
        if (err) {
            console.log(err);
            flag && callback();
            return flag = false;
        }
        var jsonStat = stat.toJson();
        if (jsonStat.errors.length > 0) {
            var errorMessage = jsonStat.errors.reduce(function (resultMessage, nextError) {
                resultMessage += nextError.toString();
                return resultMessage;
            }, '');
            console.log(errorMessage)
        }
        flag && callback();
        return flag = false;
    });
})

var staticSrcDir = ['src/lib', 'src/img', 'src/fonts']

gulp.task('mv', function(){
    return Promise.all(staticSrcDir.map(function(dir){
        return new Promise(function(resolve, reject){
            gulp.src( dir + "/**/*.*")
                .pipe(gulp.dest('static/' + dir.slice('4')))
                .on('end', resolve)
                .on('error', reject)
        })
    }))
});

gulp.task('watch', function(){
    gulp.watch("src/css/page/**/*.styl", ['compile-css']);
    gulp.watch("src/js/page/**/*.js", ['compile-js']);    
    gulp.watch(staticSrcDir.map(function(dir) {
        return dir + '/**/*.*'
    }), ['mv'])
});

gulp.task('clean', function (cb) {
    return rimraf('static/', function (err) {
        if (err) throw err;
        cb()
    })
});

gulp.task('clean:build', function(cb){
    return rimraf('dist/', function (err) {
        if (err) throw err;
        cb()
    })
});

// hash
gulp.task('hash', function () {
    var task = new Promise(function (resolve) {
        gulp.src(['static/**/*.*', '!static/lib/ionicons/fonts/**/*.*'])
            .pipe(rev())
            .pipe(gulp.dest('dist/static'))
            .pipe(rev.manifest())
            .pipe(gulp.dest('rev'))
            .on('end', resolve)
    });
    var fonts = new Promise(function(resolve) {
        gulp.src('static/lib/ionicons/fonts/**/*.*')
            .pipe(gulp.dest('dist/static/lib/ionicons/fonts'))
            .on('end', resolve);
    });
    return Promise.all([task, fonts])
});

gulp.task('rev', function(){
    var rev = new Promise(function(resolve, reject){
        gulp.src(['rev/**/*.json', 'dist/static/**/*.css', 'dist/static/**/*.js'])
            .pipe(revCollector({
                replacedReved: true
            }))
            .pipe(gulp.dest('dist/static'))
            .on('end', resolve);
    });
    var revHtml = new Promise(function(resolve, reject){
        gulp.src(["rev/**/*.json", 'mobile/**/*.blade.php'])
            .pipe(revCollector({
                replaceReved: true,
                dirReplacements: {
                    '/static/': env_conf['static_host']
                }
            }))
            .pipe(gulp.dest('dist/mobile'))
            .on('end', resolve)
    });

    return Promise.all([rev, revHtml])
})


gulp.task('compile', gulpSequence('clean', ['compile-js', 'compile-css']))

gulp.task('dev', gulpSequence('clean', ['compile-css', 'mv'], ['compile-js', 'watch']))
gulp.task('build', gulpSequence('clean:build' ,'compile', 'mv', 'hash', 'rev'))


// 
