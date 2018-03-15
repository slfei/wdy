@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-live">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title padding-left">我要直播</div>
            <div class="content">
                <div class="div-padding-normal">
                    <b>下载直播客户端</b> <br><br>
                    进入菜单【教学管理】---【周直播列表】，点击《伟东云学堂直播》或直接点击<a href="http://wdyapp.bj.bcebos.com/WdyLive_SetUp_1_0_0_5.exe">《伟东云学堂直播》</a>进行下载，下载完成后即可安装。（登录客户端需要手机号、密码，如果您还没有设置密码，可在个人中心--设置--修改密码进行设置） <br><br>
                    为了保证直播效果，请保证直播及观看直播的硬件设备满足以下条件：
                </div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>硬件</th>
                        <th>配置</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PC客户端</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>硬件</td>
                            <td>双核CPU，主频2.0G以上</td>
                        </tr>
                        <tr>
                            <td>内存</td>
                            <td>2G</td>
                        </tr>
                        <tr>
                            <td>硬盘</td>
                            <td>8G以上</td>
                        </tr>
                        <tr>
                            <td>显卡</td>
                            <td>显卡ATI，显存1G及以上</td>
                        </tr>
                        <tr>
                            <td>网络环境</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>宽带</td>
                            <td>公网访问，建议网络带宽2M以上</td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>机器类型</th>
                        <th>软件名称</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PC学员端</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>操作系统</td>
                            <td>XP/Win7/Win10/IOS</td>
                        </tr>
                        <tr>
                            <td>浏览器</td>
                            <td>
                                浏览器 <br>
                                IE浏览器版本10及以上 <br>
                                Firefox浏览器版本52及以上 <br>
                                Google Chrome浏览器版本57及以上 <br>
                                safari7及以上 <br>
                                360浏览器8及以上 <br>
                            </td>
                        </tr>
                        <tr>
                            <td>flash插件</td>
                            <td>最新版本 </td>
                        </tr>
                        <tr>
                            <td>分辨率</td>
                            <td>为了使本系统软件达到最佳的显示效果， 设置显示分辨率为1024×768以上， 颜色设置大于256色,小字体。</td>
                        </tr>
                        <tr>
                            <td>宽带</td>
                            <td>公网访问，建议网络带宽2M以上</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <b>开始直播</b> <br><br>
                    <b>直播前准备</b> <br><br>
                    1.为了保证直播效果，请在直播开始前30分钟登录客户端做准备工作（我们将在商户端后台推送直播提醒公告提醒老师做课前准备），找到您的课程直播间，点击【进入课堂】。 <br><br>
                    2.点击上课按钮可调试摄像头和分享屏幕，点击右上角设置图标可调试直播设备包括摄像头、麦克风和扬声器。直播开始前可以通过摄像头与学员沟通，调动学员的学习热情。 <br><br>
                    3.若想录制课程，勾选本地窗口录制，直播结束后该视频自动保存到预设路径（默认路径为C:\Users\Public\Video，若想修改保存路径，点击直播页面右上角的设置图标，点击更改按钮自定义保存路径) <br><br>
                    <img src="/build/img/help/attend-class.gif" alt=""><br><br>
                    <b>直播中</b> <br><br>
                    1.若您中途有紧急情况需要暂停直播，可以点击休息按钮暂停直播，学员端显示：休息一下，马上回来；休息结束后，点击继续后可继续直播。 <br><br>
                    2.直播过程中可以切换摄像头和分享屏幕调整直播显示的内容（由于直播延迟问题，不建议频繁切换，请在切换前与学员做好沟通） <br><br>
                    <img src="/build/img/help/rest.gif" alt=""><br><br>
                    4.若想将学生禁言，可以在聊天室将允许聊天取消勾选，则除了老师全员禁言。若想禁言某个学员，打开用户列表，单击需要被禁言用户后的发言图标即可。<br><br>
                    <img src="/build/img/help/talk-no.gif" alt=""><br><br>
                    <b>直播结束</b> <br><br>
                    当直播结束时，您可以与学员告别后点击下课按钮，老师最多可以延堂30分钟，若超过直播结束时间30分钟时老师仍未点击下课按钮，系统将强制老师下课。结束后，您可以在【教学管理】--【视频管理】上传回放视频。 <br><br>
                    <b>上传回放视频</b> <br><br>
                    1.直播课程结束后，在设定好的路径找到直播回放视频（默认路径为C:\Users\Public\Video）。 <br><br>
                    2.从个人中心进入教学管理页面，进入菜单【教学管理】--【视频管理】，选择直播回放，在列表中找到需要上传的直播回放，点击上传视频并上传直播回放视频。 <br><br>
                    3.视频转码成功并审核通过后，学员可以反复观看直播回放。 <br><br>
                    <img src="/build/img/help/live-upload.gif" alt="">
                </div>
            </div>

        </div>
    </div>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/live.css">
@endsection
