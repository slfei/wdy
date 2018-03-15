<?php
   $title = "入驻平台_机构入驻_伟东云学堂";

   $keywords = "入驻平台,机构入驻,个人讲师入驻,课程入驻育头条";

   $description = "伟东云学堂为机构和个人提供了不同的入驻方式，方便不同的用户能够快速找到自己合适的入驻方式。";

    if (isset($locale) && $locale != 'zh_CN') {
        unset($title);
        unset($description);
        unset($keywords);
    }

?>

@extends('pc.common')

@section('main')
   <div class="alertpc">
        @lang('join.info.info1')
   </div>
   <div class="content">
      <div class="page_one">
         <div class="page_one_area">
            <div class="page_one_text1">
               @lang('join.text.text1')
            </div>
            <div class="page_one_text2">
               @lang('join.text.text2')
            </div>
            <div class="page_one_text3">
               @lang('join.text.text3')
            </div>
            <div class="page_one_button">
               <div class="page_one_button1" id="joinInstitute">
                  @if(isset($tplData['user_info']) &&  $tplData['user_info']['is_enter'])
                       <a href="//{{$biz_host}}/institute/index" target="_blank">@lang('join.btn.btn1')</a>
                  @else
                       <a href="//{{$biz_host}}/institute/join" target="_blank">@lang('join.btn.btn1')</a>
                   @endif
               </div>

               <div class="page_one_button2" id="joinPersonal">
                  @if(isset($tplData['user_info']) &&  $tplData['user_info']['is_enter'])
                       <a href="//{{$biz_host}}/institute/index" target="_blank">@lang('join.btn.btn2')</a>
                  @else
                       <a href="//{{$biz_host}}/institute/join#/application/personal" target="_blank">@lang('join.btn.btn2')</a>
                   @endif
               </div>
            </div>
         </div>
      </div>
      <!-- <div class="page_two"> -->
      <!-- </div> -->
      <div class="page_ten">
          <div class="page_ten_area">
              <div class="page_ten_info">
                   <div class="page_ten_title">
                       @lang('join.text.text21')
                   </div>
                   <div class="page_ten_text">@lang('join.text.text22')</div>
                   <div class="page_ten_icon">
                      <div class="icon1">
                        <img src="/build/img/activity/bg10_1.png" alt="">
                        <span>@lang('join.text.text23')</span>
                      </div>
                      <div class="icon2">
                        <img src="/build/img/activity/bg10_2.png" alt="">
                        <span>@lang('join.text.text24')</span>
                      </div>
                      <div class="icon3">
                        <img src="/build/img/activity/bg10_3.png" alt="">
                        <span>@lang('join.text.text25')</span>
                      </div>
                      <div class="icon4">
                        <img src="/build/img/activity/bg10_4.png" alt="">
                        <span>@lang('join.text.text26')</span>
                      </div>
                   </div>
              </div>
          </div>
      </div>
      <div class="page_three">
        <div class="page_three_area">
           <div class="page_three_area_title">
              @lang('join.text.text4')
           </div>
           <div class="page_three_area_info">
              @lang('join.text.text5')
           </div>
           <div class="page_three_area_btn">
              <div class="page_three_area_btn1">
                 <a href="#">@lang('join.btn.btn3')</a>
              </div>
           </div>
        </div>
      </div>
      <div class="page_four">
          <div class="page_four_area">
             <div class="page_four_text1">
               @lang('join.text.text6')
             </div>
             <div class="page_four_text2">
               @lang('join.text.text7')
             </div>
             <div class="page_four_btn">
               <div class="page_four_btn1">
                 <a href="#">@lang('join.btn.btn3')</a>
               </div>
             </div>
          </div>
      </div>
      <div class="page_five">
         <div class="page_five_area">
           <div class="page_five_area_title">
              @lang('join.text.text8')
           </div>
           <div class="page_five_area_info">
              @lang('join.text.text9')
           </div>
           <div class="page_five_area_btn">
              <div class="page_five_area_btn1">
                 <a href="#">@lang('join.btn.btn3')</a>
              </div>
           </div>
         </div>
      </div>
      <div class="page_six">
         <div class="page_six_mask">
             <div class="page_six_area">
               <div class="page_six_text1">
                 @lang('join.text.text10')
               </div>
               <div class="page_six_text2">
                 @lang('join.text.text11')
               </div>
               <div class="page_six_btn">
                 <div class="page_six_btn1">
                   <a href="#">@lang('join.btn.btn3')</a>
                 </div>
               </div>
             </div>
         </div>
      </div>
      <div class="page_seven">
         <div class="page_seven_area">
           <div class="page_seven_area_title">
              @lang('join.text.text12')
           </div>
           <div class="page_seven_area_info">
              @lang('join.text.text13')
           </div>
           <div class="page_seven_area_btn">
              <div class="page_seven_area_btn1">
                 <a href="#">@lang('join.btn.btn3')</a>
              </div>
           </div>
         </div>
      </div>
      <div class="page_eight">
         <div class="page_eight_mask">
            <div class="page_eight_area">
               <div class="page_eight_title">
                  @lang('join.text.text14')
               </div>
               <div class="page_eight_info">
                  <div class="page_eight_infoL">
                     <img src="http://17dayup-activity.bj.bcebos.com/join/pel-fs8.png">
                     <div class="page_eight_infoL_title">
                        @lang('join.text.text15')
                     </div>
                     <div class="page_eight_infoL_text">
                        @lang('join.text.text16')
                     </div>
                  </div>
                  <div class="page_eight_infoR">
                     <img src="http://17dayup-activity.bj.bcebos.com/join/per-fs8.png">
                     <div class="page_eight_infoR_title">
                        @lang('join.text.text17')
                     </div>
                     <div class="page_eight_infoR_text">
                        @lang('join.text.text18')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="page_nine">
         <div class="page_nine_area">
            <div class="page_nine_title">
              @lang('join.text.text19')
            </div>
            <div class="page_nine_title1">
              @lang('join.text.text20')
            </div>
            <div class="page_nine_form">
              <form id="pcForm">
                 <div class="page_nine_row">
                    <input class="input_l" type="text" name="institute_name" placeholder="@lang('join.info.info2')">
                    <input class="input_r" type="text" name="user_name" placeholder="@lang('join.info.info3')">
                 </div>
                 <div class="page_nine_row">
                    <input class="input_l" type="text" name="phone" placeholder="@lang('join.info.info4')" maxlength="11">
                    <input class="input_r" type="text" name="email" placeholder="@lang('join.info.info5')">
                 </div>
                 <div class="page_nine_row">
                     <div class="page_nine_button js-pcAjax">
                        @lang('join.btn.btn4')
                     </div>
                 </div>
              </form>
            </div>
         </div>
      </div>
   </div>
   @if(isset($tplData['user_info']))
    <script>
        window.USERINFO = {!! json_encode($tplData['user_info']) !!};
    </script>
    @endif
@stop


@section('style')
      <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
      <link rel="stylesheet" type="text/css" href="/build/css/page/activity/activity.css">
@endsection

@section('script')
<script type="text/javascript" src="/build/lib/toast/jquery.toast.min.js"></script>
<script type="text/javascript">
   function initButtons() {
       var tips = $i18n('activity.join.tips1');
       $('#joinInstitute').on('click', function(e) {
           if (!USERINFO.is_login) {
               wdy.passport.showView('login');
               return e.preventDefault();
           }
           if(USERINFO.is_enter && USERINFO.role != 1) {
               utils.toast(tips);
               e.preventDefault();
           } else if (USERINFO.is_enter && USERINFO.enter_type != 'institute') {
               utils.toast($i18n('activity.join.tips2'));
               e.preventDefault();
           }
       });
       $('#joinPersonal').on('click', function(e) {
           if (!USERINFO.is_login) {
               wdy.passport.showView('login');
               return e.preventDefault();
           }
           if(USERINFO.is_enter && USERINFO.role != 1) {
               utils.toast(tips);
               e.preventDefault();
           } else if (USERINFO.is_enter && USERINFO.enter_type != 'personal') {
               utils.toast($i18n('activity.join.tips3'));
               e.preventDefault();
           }
       });
   }

   initButtons();

   $('.js-pcAjax').on('click',function(){
      var data = $('#pcForm').serialize();
      var phone =$.trim($('[name=phone]').eq(0).val());
      var idpc =null;
      if(phone.length){
         fnAjax(data,'pc');
      }else{
         $('.alertpc').text($i18n('activity.join.tips4')).show();
          clearTimeout(idpc)
          idpc=setTimeout(function(args) {
            $('.alertpc').hide().text($i18n('activity.join.tips5'))
          },3000)
      }

   });

   $('.js-h5Ajax').on('click',function(){
      var data = $('#h5Form').serialize();
      var phone =$.trim($('[name=phone]').eq(1).val());
      var idh5 =null;
      if(phone.length){
         fnAjax(data,'h5');
      }else{
         $('.alert').text($i18n('activity.join.tips4')).show();
         clearTimeout(idh5)
         idh5=setTimeout(function(args) {
            $('.alert').hide().text($i18n('activity.join.tips5'))
         },3000)
      }
   });

   function fnAjax(data,type){
      $.ajax({
        url: "//"+BIZ_HOST+'/api/attract/enterapply',
        type: 'POST',
        dataType: 'JSON',
        data: data,
        success:function(res){
          if(res.status=='200'){
            if(type == 'pc'){
               $('.alertpc').text($i18n('activity.join.tips6')).show();
               setTimeout(function(args) {
                  $('.alertpc').hide().text($i18n('activity.join.tips5'))
               },3000)
            }else{
               $('.alert').text($i18n('activity.join.tips6')).show();
               setTimeout(function(args) {
                  $('.alert').hide().text($i18n('activity.join.tips5'))
               },3000)
            }
            $('input').val('');
          }else{
            if(type=='pc'){
               $('.alertpc').text(res.msg).show();
               setTimeout(function(args) {
                  $('.alertpc').hide().text($i18n('activity.join.tips5'))
               },3000)
            }else{
               $('.alert').text(res.msg).show();
               setTimeout(function(args) {
                  $('.alert').hide().text($i18n('activity.join.tips5'))
               },3000)
            }
          }
        },
        error:function(){
            if(type=='pc'){
               $('.alertpc').text($i18n('activity.join.tips7')).show();
               setTimeout(function(args) {
                  $('.alertpc').hide().text($i18n('activity.join.tips5'))
               },3000)
            }else{
               $('.alert').text($i18n('activity.join.tips7')).show();
               setTimeout(function(args) {
                  $('.alert').hide().text($i18n('activity.join.tips5'))
               },3000)
            }
        }
      })
   }
</script>
@stop
