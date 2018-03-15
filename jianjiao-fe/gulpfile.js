var gulp = require('gulp');
var watch = require('gulp-watch');
var gulpSequence = require('gulp-sequence');
var runSequence = require('run-sequence');
var stylus = require('gulp-stylus');
var postcss = require('gulp-postcss');
var named = require('vinyl-named');
var webpackConfig = require('./webpack.config.js');
var rev = require('gulp-rev');
var revCollector = require('gulp-rev-collector');
var rimraf = require('rimraf');
var resolvePath = require('gulp-resolve-path');
var fs = require('fs');
var through = require('through2');
var Path = require('path');

gulp.task('clean:dist', function (callback) {
    rimraf('dist/', function (err) {
        if (err) throw err;
        callback();
    })
});

gulp.task('clean:build', function (callback) {
    rimraf('build/', function(err) {
        if (err) throw err;
        callback();
    })
});

gulp.task('webpack', function (callback) {

    var dir = 'src/entry';
    var config = Object.assign({}, webpackConfig);
    var flag = true;
    fs.readdir(dir, function(err, files) {
        if (err) {
            console.log(err)
            flag && callback();
            return flag = false;
        }
        var entry = {};
        files.filter(file => file.split('.').pop() === 'js' && file.length > 3)
            .forEach(file => {
                var name = file.replace(/\.js$/, '');
                entry[name] =  Path.join(__dirname, dir, file)
            });

        config.entry = entry;
        config.watch = process.env.NODE_ENV !== 'production';
        config.output.path = Path.join(__dirname, 'build');
        require('webpack')(config, function(err, stat) {
            if (err) {
                console.log(err);
                flag && callback();
                return flag = false;
            }
            console.log(stat.toString({
                chunks: false,
                colors: true
            }))
            flag && callback();
            return flag = false;
        });
    });

});

gulp.task('mv', function () {
    //这些目录下的文件直接拷贝
    var moveFolder = ['lib', 'img', 'fonts'];
    var promiseArray = moveFolder.map(function(folder) {
        return new Promise(function(resolve, reject) {
            gulp.src(['src/' + folder + '/**/*.*'])
                .pipe(gulp.dest('build/' + folder))
                .on('end', resolve)
                .on('error', reject);
        })
    });

    return Promise.all(promiseArray);
});


gulp.task('webpack:watch', function () {

    //watch('src/**/*.*', function () {
    //    gulp.start(['webpack', 'mv', 'stylus']);
    //});
    gulp.watch('src/**/*.styl', ['stylus']);
    gulp.watch(['src/lib', 'src/img', 'src/fonts'], ['mv']);
});

gulp.task('webserver', function () {
    require('./dev-server.js')();
});

gulp.task('stylus', function () {
   // return gulp.src(['src/css/all.styl', 'src/css/topic315_index.styl'])
    return gulp.src('src/css/**/*.styl')
       .pipe(stylus({
            'include css': true
       }))
       .pipe(postcss())
       .pipe(gulp.dest('build/css'));
});

gulp.task('cssImg', function()  {
    //把 css background: url(../img/a.png) ---> background: url(build/img/a.png)
    //便于图片md5化后替换成 /static/img/a-[hash].png
    return gulp.src(['build/**/*.css'])
        .pipe(resolvePath({
            ext: {
                template: [],
                script: [],
                style: ['css']
            }
        }))
        .pipe(through.obj(function(chunk, enc, next){
            var str = chunk.contents.toString('utf-8');
            str = str.replace(/url\(\/build\/css\/data\:/g, 'data:');
            chunk.contents = new Buffer(str);
            this.push(chunk);
            next();
        }))
        .pipe(gulp.dest('build/'));
});

gulp.task('hash', function () {
    var p1 = new Promise(function(resolve){
        gulp.src(['build/**/*.*', '!build/**/*.map'])
            .pipe(rev())
            .pipe(gulp.dest('dist/static'))
            .pipe(rev.manifest())
            .pipe(gulp.dest('rev'))
            .on('end', resolve)
    });
   /* var p2 = new Promise(function(resolve) {
        gulp.src(['build/fonts/!*.*'])
            .pipe(gulp.dest('dist/static/fonts'))
            .on('end', resolve);
    });*/
    return Promise.all([p1]);
});

gulp.task('rev', function () {

    var p1 = new Promise(function(resolve, reject){
        gulp.src(['rev/**/*.json', 'dist/**/*.css', 'dist/**/*.js'])
            .pipe(revCollector({
                replacedReved: true,
                dirReplacements: {
                    '/build/': '/static/' //'http://os78sxb3g.bkt.clouddn.com/'
                }
            }))
            .pipe(gulp.dest('dist/'))
            .on('end', resolve);
    });
    var p2 = new Promise(function(resolve, reject){
        gulp.src(['rev/**/*.json', 'resources/**/*.blade.php'])
            .pipe(revCollector({
                replacedReved: true,
                dirReplacements: {
                    '/build/': '/static/'  //'http://os78sxb3g.bkt.clouddn.com/'
                }
            }))
            .pipe(gulp.dest('dist/resources'))
            .on('end', resolve);
    });

    return Promise.all([p1, p2]);
});


/*gulp.task('staticUrlToKs3', function() {
    var ks3url = 'http://os78sxb3g.bkt.clouddn.com';

});*/

gulp.task('build:watch', function () {
    // gulp.watch('src/**/*.styl', ['stylus']);
    // gulp.watch(['src/lib', 'src/img', 'src/fonts'], ['mv']);
    watch('src/**/*.*', function () {
        console.log(arguments);
        runSequence(['clean:build', 'clean:dist'], ['webpack', 'mv', 'stylus'],'cssImg', 'hash', 'rev');
    });
});



gulp.task('dev', gulpSequence('clean:build', ['webpack', 'mv', 'stylus'], ['webpack:watch', 'webserver']));
gulp.task('dev-server', gulpSequence('build', ['build:watch']));
gulp.task('build', gulpSequence(['clean:build', 'clean:dist'], ['webpack', 'mv', 'stylus'],'cssImg', 'hash', 'rev'));

