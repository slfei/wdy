var gulp = require('gulp');
var glob = require('glob');
var rev = require('gulp-rev');
var gulpSequence = require('gulp-sequence'); // gulp 同步执行命令
var stylus = require('gulp-stylus');
var del = require('del');
var vinylPaths = require('vinyl-paths');
var webpack = require('webpack');
var webpackConf = require('./conf/webpack.config.js');
var staticDir = ['src/lib', 'src/img', 'src/fonts'];
var minimist = require('minimist');
var revCollector = require('gulp-rev-collector');
var minifycss = require('gulp-clean-css');


var knowOptions = {
    string: 'env',
    default: {
        env: process.env.NODE_ENV || 'development'
    }
};

var env = minimist(process.argv.slice(2), knowOptions).env;
console.log('env:',env)

var isProduction = env === 'production';
var dirReplacement = isProduction ? {
    '/build/': '//pay.s.wdyedu.com/build/'
} : {};
console.log(dirReplacement);

/**
 * 清除
 */

gulp.task('clean',function(){
   var clean = new Promise(function(resolve,reject){
   	   del(['build/','dist/']).then(function(){
   	   	  resolve();
   	   });
   });

   return Promise.all([clean]);
});

/**
 * 编译stylus
 */

gulp.task('stylus',function(){
    var vp = vinylPaths();

	return gulp.src('src/css/**/*.styl')
    .pipe(stylus())
    .pipe(minifycss())
	.pipe(gulp.dest('build/css'))
	.pipe(vp)
	.on('end', function(){

		var paths = ['build/css/**/*.css'];
		vp.paths.forEach(function(item){
            paths.push('!' + item.substr(item.indexOf('build')))
		});

		del(paths)
	});
});

/**
 * 编译js
 */

gulp.task('js',function(){
    
    var js = new Promise(function(resolve,reject){
        var entry = {};
        var paths = ['build/js/**/*.js'];

        glob.sync("src/js/**/*.js").map(function (file) {

            entry[file.replace('src', 'build')] = require('path').join(__dirname, file);
            paths.push('!' + file.replace('src', 'build'));
        });

        var config = Object.assign({}, webpackConf, {
            entry : entry,
            output: {
                path    : __dirname,
                filename: '[name]'
            }
        });

        webpack(config,function(err,stat){
            if (err) {
                console.log(err);
            }
            console.log(stat.toString({
                chunks: false,
                colors: true
            }));
            del(paths);

           resolve()
        });
    });

    return Promise.all([js]);
    
});


/**
 * 生成hash
 */

gulp.task('hash', function(){
    var task = new Promise(function (resolve) {
        gulp.src(['build/**/*.*','!build/lib/ionicons/**/*.*'])
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
    return Promise.all([task, fonts])
});

/**
 *  替换
 */

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
        gulp.src(["rev/**/*.json", 'resources/**/*.blade.php','resources/**'])
            .pipe(revCollector({
                replaceReved: true,
                dirReplacements: dirReplacement
            }))
            .pipe(gulp.dest('dist/resources'))
            .on('end', resolve)
    });

    return Promise.all([rev, revHtml])
});

/**
 * 移动文件夹
 */

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

/**
 * 监听文件变动
 */

gulp.task('watch', function(){
    gulp.watch(['src/css/**/*.styl'],['stylus']);
    gulp.watch(['src/js/**/*.js'],['js']);
});


gulp.task('dev',gulpSequence('clean','mv',['stylus', 'js'],'hash','rev','watch'));
gulp.task('build:test',gulpSequence('clean','mv',['stylus', 'js'],'hash','rev'));
gulp.task('build',gulpSequence('clean','mv',['stylus', 'js'],'hash','rev'));



