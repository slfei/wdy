var gulp = require('gulp');
var stylus = require('gulp-stylus');
var sourcemaps = require('gulp-sourcemaps');
var webpack = require('webpack');
var gulpSequence = require('gulp-sequence');
var rimraf = require('rimraf');
var glob = require('glob');
var minimist = require('minimist');
var rev = require('gulp-rev');
var revCollector = require('gulp-rev-collector');

var webpackConf = require('./conf/webpack.config.js');
var staticDir = ['src/lib', 'src/img', 'src/fonts'];
var nPath = require('path');
var urlReplace = require('gulp-url-replace');
var buildConfig = require('./conf/build.config.js');

var knowOptions = {
    string: 'env',
    default: {
        env: process.env.NODE_ENV || 'development'
    }
};

var env = minimist(process.argv.slice(2), knowOptions).env;
var isProduction = env === 'production';
var dirReplacement = isProduction ? {
    '/build/': '//s.wdyedu.com/build/'
} : {};
var urlReplacement = isProduction ? {
    "//wdyedu-static-dev.bj.bcebos.com/": "//17dayup-passport-dev.bj.bcebos.com/"
} : {};

gulp.task('compile:stylus', function () {
    var styl = stylus({
        'include css': true,
        compress: isProduction
    });
    styl.on('error', function(e){
        console.log(e);
        styl.end();
    });

    return gulp.src('src/css/**/*.styl')
        .pipe(sourcemaps.init())
        .pipe(styl)
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('build/css'));
});


gulp.task('clean', function () {
    return Promise.all(
        ['build', 'dist'].map(function (dir) {
            return new Promise(function (resolve, reject) {
                rimraf(dir, function (err) {
                    if (err) {
                        reject();
                    } else {
                        resolve();
                    }
                });
            });
        }));
});

gulp.task('compile:js', function (callback) {
    var entry = {};
    glob.sync("src/js/page/**/*.js").map(function (file) {
        entry[file.replace('src', 'build')] = require('path').join(__dirname, file);
    });

    var config = Object.assign({}, webpackConf, {
        entry : entry,
        output: {
            path    : __dirname,
            filename: '[name]'
        }
        //watch : isProduction
    });
    var flag = true;
    webpack(config, function (err, stat) {
        if (err) {
            console.log(err);
            flag && callback();
            return flag = false;
        }
        console.log(stat.toString({
            chunks: false,
            colors: true
        }));
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

gulp.task('mv', function () {
    return Promise.all(
        staticDir.map(function (dir) {
            return new Promise(function (resolve, reject) {
                gulp.src(dir + '/**/*.*')
                    .pipe(gulp.dest('build/' + dir.substring(4)))
                    .on('end', resolve)
                    .on('error', reject);
            })
        })
    )
});

gulp.task('watch', function () {
    gulp.watch(['src/css/**/*.styl', 'src/css/**/*.css'], ['compile:stylus']);
    gulp.watch(staticDir, ['mv']);
    gulp.watch(['src/js/**/*.*'], ['compile:js']);
});

gulp.task('sync', function() {
    var cmd = require('child_process').spawn('nobone-sync', ['nobone-sync-config.js']);
    cmd.stdout.on('data', function(data) {
        console.log(`stdout: ${data}`);
    });
    cmd.stderr.on('data', function(data) {
        console.log(`stderr: ${data}`);
    });
});

// hash
gulp.task('hash', function () {
    var task = new Promise(function (resolve) {
        gulp.src(['build/**/*.*', '!build/lib/ionicons/**/*.*',  '!build/lib/share/**/*.*'])
            .pipe(rev())
            .pipe(gulp.dest('dist/build'))
            .pipe(rev.manifest())
            .pipe(gulp.dest('rev'))
            .on('end', resolve)
    });
    var fonts = new Promise(function(resolve) {
        gulp.src('build/lib/ionicons/**/*.*')
            .pipe(gulp.dest('dist/build/lib/ionicons/'))
            .on('end', resolve);
    });
    var share = new Promise(function(resolve) {
        gulp.src('build/lib/share/**/*.*')
            .pipe(gulp.dest('dist/build/lib/share/'))
            .on('end', resolve);
    });
    return Promise.all([task, fonts, share])
});

gulp.task('rev', function(){
    var rev = new Promise(function(resolve, reject){
        gulp.src(['rev/**/*.json', 'dist/build/**/*.css', 'dist/build/**/*.js'])
            .pipe(revCollector({
                replacedReved: true,
                dirReplacements: dirReplacement
            }))
            .pipe(gulp.dest('dist/build'))
            .on('end', resolve);
    });
    var revHtml = new Promise(function(resolve, reject){
        gulp.src(["rev/**/*.json", 'resources/**/*.blade.php'])
            .pipe(revCollector({
                replaceReved: true,
                dirReplacements: dirReplacement
            }))
            .pipe(urlReplace(urlReplacement))
            .pipe(gulp.dest('dist/resources'))
            .on('end', resolve)
    });

    return Promise.all([rev, revHtml])
});

gulp.task('header_footer', function() {
    /* for biz */
    var files = ['rev/**/*.json', './build/**/header_footer.js', './build/**/header_footer.css'];
    return gulp.src(files)
        .pipe(revCollector({
            replacedReved: true,
            dirReplacements: dirReplacement
        }))
        .pipe(gulp.dest('dist/build'))
});

gulp.task('upload:bos', function() {
    var BosClient = require('bce-sdk-js').BosClient;

    var client = new BosClient(buildConfig.bosConfig);
    var bucket = buildConfig[env].bosBucket;
    var jsFiles = ['./build/js/page/header_footer.js'];
    var cssFiles = ['./build/css/bos/header_footer.css'];

    return Promise.all(
        uploadWithDir(jsFiles, 'js').concat(uploadWithDir(cssFiles, 'css'))
    ).catch(e => console.dir(e));

    function getFileName(str) {
        return str.split('/').pop();
    }

    function uploadWithDir(files, dir) {
        dir = dir ? dir : '';
        if (dir && dir.substring(dir.length - 1) != '/') {
            dir = dir + '/';
        }
        return files.map(file => client.putObjectFromFile(bucket, dir + getFileName(file), file))
    }
});

gulp.task('IMerge', function(){
    var IMerge = require('imerge');
    var options = {
        from: 'build/css/',
        cssTo: 'build/css',
        spriteTo: 'build/sprite',
        sourceContext: __dirname,
        outputContext: 'build/sprite',
        pattern: 'build/css/**/*.css',
        defaults: {
            padding: 20
        }
    };
    var pathFilter = {
        /*// 图片地址过滤器
        imagePathFilter: function(file, conf) {
            // 只处理png
            if (!/\.png$/.test(file)) {
                return file;
            }
        },*/

        spriteTo: function(merge, file) {
            console.log(merge);
            return nPath.join(options.spriteTo, '/sprite_' + merge + '.png');
        },
        spritePathFilter: function(file) {
            return '/' + file.replace(/\\/g, '/');
        },
        cssTo: function(file) {
            return nPath.join(options.cssTo, nPath.relative(options.from, file));
        }
    };

    var iMerge = new IMerge.IMerge(options, pathFilter);
    return iMerge.start();

});

gulp.task('cp:lang', function() {
    return gulp.src('resources/lang/**/*.*')
        .pipe(gulp.dest('dist/resources/lang'));

});
gulp.task('dev', gulpSequence('clean', 'mv', ['compile:stylus', 'compile:js'], 'watch'));
gulp.task('iMerge', gulpSequence('clean', 'mv', ['compile:stylus', 'compile:js'], 'IMerge'));
gulp.task('build:test', gulpSequence('clean', ['mv','cp:lang'], ['compile:stylus', 'compile:js'], 'IMerge', 'hash', 'rev', 'header_footer'));
gulp.task('build', gulpSequence('clean', ['mv','cp:lang'], ['compile:stylus', 'compile:js'], 'IMerge', 'hash', 'rev', 'header_footer'));
