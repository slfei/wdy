@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-about">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title padding-left">关于我们</div>
            <div class="text-justify padding-left img_top">
               <img src="/build/img/help/about.png">
            </div>
            <div class="padding-left about_title">关于伟东云学堂</div>
            <p class="text-justify padding-left">伟东云学堂（wdyedu.com），是伟东云教育集团推出的全球领先的互联网教育云平台，总部位于有“中国硅谷”之称的北京中关村科技园核心区域，于2017年11月底正式上线。伟东云学堂以“让人们平等便捷的获取全球优质教育资源”为使命，与众多教育培训机构建立合作，汇聚全球优质的教学资源，课程涵盖国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域。伟东云学堂致力于通过技术创新，为家庭、个人及机构、企业用户提供专业而全方位的教育产品与服务，借助互联网的优势让不同地域范围内教育的“供”和“需”之间建立连接，实现资源的最优分配，为用户提供便捷、实惠、专业的教育服务，不断为用户创造价值，推动行业发展。</p>
            <div class="about_min_title padding-left">业务模式</div>
            <p class="text-justify padding-left">伟东云学堂为基于线上线下互动结合的B2B2C（Business to Business to Customer）模式，即链接教育内容供需双方，为教学过程各环节提供技术、功能和服务，并实现教育内容变现的互联网第三方教育平台。家庭个人及企业机构可直接在线上进行教育课程及服务自助交易，用户可以通过在线学习和线下课程等方式体验到伟东云学堂的一站式教育服务。</p>
            <div class="about_min_title padding-left">核心用户</div>
            <p class="text-justify padding-left">由于体制内教育资源总量不足、分配不均，人往往通过额外的教育培训来投资自己和家人，希望未来能获得更好的学习、工作和生活。伟东云学堂覆盖学龄前、K12、大学、工作、退休等各阶段用户群，贯穿人一生的学习。目前，伟东云学堂的核心用户有：K12学生/家长、在校大学生、职场白领、国学爱好者</p>
            <div class="padding-left about_title">产品与服务</div>
            <p class="text-justify padding-left">目前，围绕学员与机构，伟东云学堂旗下设有四大业务体系，包括</p>
            <p class="text-justify padding-left">To B：行业咨询、教学工具、营销工具、在线交易</p>
            <p class="text-justify padding-left">To C：学习咨询、学习工具、优质课程、在线交易</p>
            <div class="padding-left about_title">上课方式</div>
            <p class="text-justify padding-left">在伟东云学堂，您会体验到两种不一样的学习感受，处处能学，时时可学，无论哪一种，都是在求知的道路上一次身与心的旅行。</p>
            <div class="class_area padding-left">
                 <div class="about_min_title">线下上课（offline）</div>
                 <div class="about_min_title">在线上课（online）</div>
            </div>
            <div class="class_area padding-left">
                 <div>通过云学堂预约老师在线下场所进行授课</div>
                 <div>通过云学堂直接在线制视频授课</div>
            </div>
            <div class="class_area padding-left">
                 <div class="about_min_title">现场教学</div>
                 <div class="about_min_title">即时互动</div>
            </div>
            <div class="class_area padding-left">
                 <div>与老师面对面互动，学习氛围浓厚，注意力更易集中，效果更有保障</div>
                 <div>通过在线教学工具在线上课，能够共享PPT等课程文档，与老师即时沟通，随时解决课程问题</div>
            </div>
            <div class="class_area padding-left">
                 <div class="about_min_title">地点自选</div>
                 <div class="about_min_title">不限地域</div>
            </div>
            <div class="class_area padding-left">
                 <div>双方可协商上课地点，选择老师上门，学生上门，或第三方提供的场地</div>
                 <div>不用担心名师不在本地，可选择你喜欢的名师远程上课；即使名师本地，也可以帮你节省上课途中的往返时间</div>
            </div>
            <div class="class_area padding-left">
                 <div class="about_min_title">设施齐备</div>
                 <div class="about_min_title">价格优惠</div>
            </div>
            <div class="class_area padding-left">
                 <div>线下上课更适合钢琴、舞蹈等需要专业设施和场地的学习需求</div>
                 <div>在线授课的价格通常会比线下授课价格便宜，选择在线上课，帮你节省更多学习开支</div>
            </div>
            <div class="padding-left about_title">企业文化</div>
            <p class="text-justify padding-left">伟东云学堂团队喜欢跟简单的人共事，坚持高效的直奔主题的做事风格。这里有集团公司的深厚积累，也有创业公司的无限可能。这里有覆盖教育生态圈的产品链条，在这里，你不是适应未来，而是一起创造未来。</p>
            <div class="about_min_title padding-left">使    命：</div>
            <p class="text-justify padding-left">让人们平等便捷的获取全球优质教育资源</p>
            <p class="text-justify padding-left">人人皆学，处处能学，时时可学</p>
            <div class="about_min_title padding-left">愿    景：</div>
            <p class="text-justify padding-left">成为全球领先的互联网教育云平台</p>
            <div class="about_min_title padding-left">价 值 观：</div>
            <p class="text-justify padding-left">用户第一  创造价值  拥抱变化  积极担当</p>
            <div class="about_min_title padding-left">Slogan  ：</div>
            <p class="text-justify padding-left">你想学的都在这儿</p>
            <div class="padding-left about_title">我们的优势</div>
            <p class="text-justify padding-left">专注于链接及服务于教育资源供需双方的互联网第三方教育云平台，伟东云学堂在品牌、市场、资源、团队等方面有自己独到的优势，这些优势对伟东云学堂的发展起到了护城河的作用。</p>
            <div class="about_min_title padding-left">品牌优势：</div>
            <p class="text-justify padding-left">伟东云学堂由伟东云教育集团打造，是伟东云教育全球终身教育生态系统的线上入口。伟东云教育集团是全球互联网教育平台运营商，成立五年多以来，始终专注教育产业，现已在全球16个国家设立分公司，在各地建设教育信息化项目数百个，辐射数以千万计的在校学生、家长和教师等周边群体。</p>
            <div class="about_min_title padding-left">资源优势：</div>
            <p class="text-justify padding-left">作为行业领先的教育信息化服务提供商，伟东云教育集团在国内基础教育领域、职业教育领域以及海外教育领域有深厚的行业积累，在教育园区、教育行政机构、大专院校、培训机构等方面有着无可比拟的资源优势。</p>
            <div class="padding-left about_min_title ">市场优势：</div>
            <p class="text-justify padding-left">伟东云教育集团产品应用于中国1400多家学校，国内用户超过1300万人，在全球拥有12家分支机构，为330家世界五百强企业提供服务。伟东云教育作为联合国教科文组织的战略合作伙伴，为其195个成员国及地区提供国际数字化教育资源共享平台，并连续承办两届四次国际教育信息化大会。</p>
            <div class="padding-left about_min_title ">团队优势：</div>
            <p class="text-justify padding-left">伟东云学堂核心团队由来自百度、阿里、腾讯等著名互联网公司及知名教育机构的顶尖人才组成，在教育规划、研发、推广、运营等方面拥有系统的理念和成熟的经验。</p>
            <div class="padding-left about_title ">战略合作伙伴</div>
            <p class="text-justify padding-left">联合国教科文组织</p>
            <p class="text-justify padding-left">国际互联网教育联盟</p>
            <p class="text-justify padding-left">国际大学创新联盟</p>
            <p class="text-justify padding-left">清华大学政府和社会资本合作研究中心</p>
            <p class="text-justify padding-left">法国德莫斯培训教育集团</p>
            <p class="text-justify padding-left">法国布雷斯特高等商学院</p>
            <div class="padding-left about_title ">我们的客户</div>
            <p class="text-justify padding-left">深圳地铁</p>
            <p class="text-justify padding-left">青岛地铁</p>
            <p class="text-justify padding-left">唐风汉语</p>
            <p class="text-justify padding-left">常春藤赖世雄英语</p>
            <p class="text-justify padding-left">青岛出版社</p>
            <p class="text-justify padding-left">新东方</p>
            <p class="text-justify padding-left">新航道</p>
            <p class="text-justify padding-left">英孚教育</p>
            <p class="text-justify padding-left">尖椒教育点评</p>
            <div class="padding-left about_title ">媒体报道</div>
            <p class="text-justify padding-left">凤凰网</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://qd.ifeng.com/a/20180202/6355314_0.shtml">伟东云教育连续三年荣获教育部最佳合作伙伴</a></p>
            <p class="text-justify padding-left">鲸媒体</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://www.jingmeiti.com/archives/24751">伟东云学堂“春芒计划”发布，将在1年内培养100位年收入超过200万的教育内容生产者</a></p>
            <p class="text-justify padding-left">新浪网</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://qd.sina.com.cn/news/sdyw/2018-01-21/detail-ifyquptv8411913.shtml">2018国学春晚新闻发布会在即墨顺利召开</a></p>
            <p class="text-justify padding-left">搜狐网</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://www.sohu.com/a/222726209_721744">伟东云学堂独家赞助2018国学春晚 大年初一派发亿元红包</a></p>
            <p class="text-justify padding-left">凤凰网</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://news.ifeng.com/a/20180108/54936966_0.shtml">伟东云教育集团宣布主办2018第二届国学春晚 助力优秀中华传统文化发扬光大</a></p>
            <p class="text-justify padding-left">科教网</p>
            <p class="text-justify padding-left"><a target="_blank" href="http://www.kjw.cc/2017/12/26/120227.html">伟东云教育荣获“2017中国ICT企业家大会”两项大奖</a></p>
        </div>
    </div>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/about.css">
@endsection
