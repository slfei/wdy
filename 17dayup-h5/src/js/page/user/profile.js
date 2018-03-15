import weui from 'weui.js'
import common from '../../common'


$(function(){
    /*日历插件*/
    // laydate.render({
    //   elem: '#test1' //指定元素
    // });
    var sex = 0,industry_id;
    $('.industry_true').click(function(){
        $('.industry_select').toggle();
    })
    $('.sex_select i').click(function(e){        
        $(this).removeClass('gray').addClass('active').siblings().removeClass('active').addClass('gray');
        saveInfo()

    })
    $('.industry_select .select_item').on('click',function(e){
        industry_id = e.target.id.slice(6);
        $(this).css({'background':'rgba(0, 150, 136, 0.89)','color':'#fff'}).siblings().css({'background':'#fff','color':'#666'})
        $('.indus_text').text($(this).text())

    })
    $('.avator_upload').on('click', function () {
        console.log("cdnjcbdh")
        $('#upload-avatar-input').click()
    });
    $('#upload-avatar-input').on('change', function (e) {
        common.ui.loading.show('正在上传...')
        console.log(this.files[0])
            if (!this.files || !this.files[0]) {
                return ;
            }
            var file =this.files[0];
            var reader = new FileReader();
            reader.onload = function(evt){
            }
            reader.readAsDataURL(file);
            var form_image = new FormData();
            form_image.append('image', file);
            $.ajax({
            type:'POST',
            url: '/api/universal/uploadimage', 
            data: form_image,
            processData: false,
            contentType: false,
            success: function(res){
                common.ui.loading.hide()
                if(res.status==200){                    
                    $('.avator_upload img').attr('src',res.data.url)
                    saveInfo()
                }
                else{
                    common.toast('上传失败，请重试')
                }
            }
        })
    });
    // why delete 2017 11 27 改为实时修改去掉保存按钮 

    // $('.save_info').click(function(){
    //     console.log($('.avator_upload img').attr('src'))
    //     console.log($('.sex_select i').is('.active'))
    //     if($('.sex_select i').is('.active')){
    //         console.log($('.active').attr('id'));
    //         sex = $('.active').attr('id').slice(4)
    //     }
    //     var userinfo = {
    //         avatar_url: $('.avator_upload img').attr('src'),
    //         nick_name : $('.nick_name').val(),
    //         short_desc: $('.signature').val(),
    //         birthday  : $('.js-pick-date .label_desc').html(),
    //         sex       : sex,
    //         industry  : $(".js-pick-item .label_desc").data('value')
    //     };
    //     console.log(userinfo);
    //     $.post('/api/center/saveinfo',userinfo,function(data,status){
    //         if (data.status==200) {
    //             // alert('保存成功')
    //             common.toast('保存成功').then(function(){
    //                 common.goBack();
    //             });
    //         }
    //     })
    // });
    // why add 2017 11 27 改为实时修改去掉保存按钮
    var $val_old; 
    $('.saveText').on('focus',function(){
        var $this=$(this);
        $val_old=$this.val();
    })

    $('.saveText').on('blur',function(){
        var $this=$(this),
            $val=$this.val();
        if($val!==$val_old){
            saveInfo();
        }
        
    })


    function saveInfo(){//保存个人中心数据
        if($('.sex_select i').is('.active')){
            sex = $('.active').attr('id').slice(4)
        }
        var userinfo = {
            avatar_url: $('.avator_upload img').attr('src'),
            nick_name : $('.nick_name').val(),
            short_desc: $('.signature').val(),
            birthday  : $('.js-pick-date .label_desc').html(),
            sex       : sex,
            industry  : $(".js-pick-item .label_desc").data('value')
        };
        $.post('/api/center/saveinfo',userinfo,function(data,status){
            if (data.status==200) {
                // alert('保存成功')
                common.toast('保存成功')
                // common.toast('保存成功').then(function(){
                //     common.goBack();
                // });
            }
        })

    }
    //why end 2017 11 27 




    $(".js-pick-date").on("click", function(){
        var dateElem = $(".js-pick-date .label_desc")
        var date = dateElem.html().split('-');


        weui.datePicker({
            start: '1969-01-01',
            end: '2017-12-29',
            /**
             * https://zh.wikipedia.org/wiki/Cron
             * cron 表达式后三位
             * 示例：
             *  * * *                每天
             *  5 * *                每个月的5日
             *  1-10 * *             每个月的前10日
             *  1,5,10 * *           每个月的1号、5号、10号
             *  *\/2 * *             每个月的 1、3、5、7...日，注意写的时候斜杠“/”前面没有反斜杠“\”，这是因为是注释所以需要转义
             *  * 2 0                2月的每个周日
             *  * * 0,6              每个周末
             *  * * 3                每周三
             */
            // cron: '* */2 0',
            defaultValue: date,
            onChange: function (result) {
                console.log(result);

            },
            onConfirm: function (result) {
                var d = [];
                for(var i = 0, l = result.length; i < l; i++){
                    d.push(result[i].value)
                }
                dateElem.html(d.join('-'));
                saveInfo();
            },
            id: 'test1'
        });
    })
    

    $(".js-pick-item").on("click", function(){
        console.log("xxxx");
        var items = $('.js-pick-item').find(".item");
        var options = []; 
        items.each(function(i, item){
            var _item = $(item);
            options.push({
                label: _item.data('name'),
                value: _item.data('value')
            })
        })

        var selectItem = $('.js-pick-item .label_desc');
        var selectItemVal = selectItem.data('value')

        weui.picker(options, {
            defaultValue: [selectItemVal],
            className: 'custom-classname',
            onChange: function (result) {
                //console.log(item, index);
                console.log(result);
            },
            onConfirm: function (result) {
                console.log(result);
                selectItem.data('value', result[0]['value']);
                selectItem.html(result[0]['label']);
                saveInfo();
            },
            id: 'picker'
        });

        
    })

})
