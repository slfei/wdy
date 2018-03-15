# wt-crm-fe

> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For detailed explanation on how things work, checkout the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).



## api联调

配置host:  127.0.0.1 dev.ac.enimo.cn

登录  test.ac.enimo.cn

##
全局安装 element-ui 主题修改程序

1. `npm i --registry=https://registry.npm.taobao.org element-theme@0.7.2 -g`
2. 在项目根目录下面修改 element-variables.css 文件
3. 执行 `npm run gen_theme` 使主题生效


## dialog
在dialog 中添加自定义类名 w-dialog,如果在dialog固定宽度的情况下添加  w-dialog w-dialog-regular  625px
    例如：1.<el-dialog custom-class="w-dialog"></el-dialog>
         2.<el-dialog custom-class="w-dialog w-dialog-regular"></el-dialog>
         3.this.$confirm('确定删除这条信息吗？','提示',{customClass:"w-dialog"})

## transfer
在 el-transfer 中添加样式名 w-transfer 例如  <el-transfer class="w-transfer" > </el-transfer>

## button 蓝色
在 el-button 中添加样式名 w-button 例如  <el-button class="w-button" > </el-button>

## date-picker 下拉选框
在el-date-picker 中添加自定义类名 w-date-picker-popper 例如  <el-date-picker popper-class="w-date-picker-popper"> </el-date-picker>

## table th背景颜色和加粗
在 el-table 中添加样式名 w-table 例如<el-table class="w-table">
*****
###颜色替换  -- 添加相应的类名 'w-'（如：w-demo-form，w-input，w-select，w-time-picker，w-textarea，w-radio-group，w-switch，w-checkbox-group）
######form 表单--控制label行高 require图标样式
```
<el-form class="w-demo-form"></el-form>
```
######input --边框颜色 placeholder字体颜色
```
<el-input class="w-input"></el-input>
```
######select --边框颜色 placeholder字体颜色 下拉arrow样式
```
<el-select class="w-select"></el-select>
```
######time-picker --边框颜色 placeholder字体颜色 input__icon颜色
```
<el-time-picker class="w-time-picker"></el-time-picker>
```
######input[type='textarea'] --文本域边框颜色
```
<el-input class="w-textarea"></el-input>
```
######radio-group --单选框边框颜色
```
<el-radio-group class="w-radio-group"></el-radio-group>
```
######switch --switch背景色
```
<el-switch class="w-switch"></el-switch>
```
######checkbox-group --复选框边框颜色
```
<el-checkbox-group class="w-checkbox-group"></el-checkbox-group>
```


## pagination 分页
在el-pagination 中添加自定义类名 w-pagination 例如

######pagination 分页  --在el-pagination 中添加自定义类名 w-pagination 例如 
```
<el-pagination class="w-pagination"> </el-pagination>
```