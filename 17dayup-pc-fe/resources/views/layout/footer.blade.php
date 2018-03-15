
<footer class="g-footer">
    <div class="footer">
        <div class="main-container clearfix">
            <div class="col-links">
                <div class="col">
                    <div class="hd">@lang('common.footer.col1.title')</div>
                    <div class="link">
                        <a href="//{{$www_host}}/course/discovery" target="_blank">@lang('common.footer.col1.item1')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/study" target="_blank">@lang('common.footer.col1.item2')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/speed" target="_blank">@lang('common.footer.col1.item3')</a>
                    </div>
                </div>
                <div class="col">
                    <div class="hd">@lang('common.footer.col2.title')</div>
                    <div class="link">
                        <a href="//{{$www_host}}/activity/join" target="_blank">@lang('common.footer.col2.item1')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/activity/join" target="_blank">@lang('common.footer.col2.item2')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/agreement" text="这是哪个页面？" target="_blank">@lang('common.footer.col2.item3')</a>
                    </div>
                </div>
                <div class="col">
                    <div class="hd">@lang('common.footer.col3.title')</div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/enter" target="_blank">@lang('common.footer.col3.item1')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/refund" target="_blank">@lang('common.footer.col3.item2')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/feedback" target="_blank">@lang('common.footer.col3.item3')</a>
                    </div>
                </div>
                <div class="col">
                    <div class="hd">@lang('common.footer.col4.title')</div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/about" target="_blank">@lang('common.footer.col4.item1')</a>
                    </div>
                    <div class="link">
                        <a href="//{{$www_host}}/help/contact" target="_blank">@lang('common.footer.col4.item2')</a>
                    </div>
                    <!-- <div class="link">
                        <a href="//{{$www_host}}/" target="_blank">友情链接</a>
                    </div> -->
                    <div class="link">
                        <a href="//{{$www_host}}/help/sitemap" target="_blank">@lang('common.footer.col4.item3')</a>
                    </div>
                    <div class="link">
                        <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=83965" target="_blank">@lang('common.footer.col4.item4')</a>
                    </div>
                </div>
            </div>
            <div class="col-logo">
                <a class="logo"></a><br/>
                <div class="share-icons">
                </div>
                <div class="copyright">
                    ©2018 All Rights Reserved <br/>@lang('common.footer.license.owner')
                    <br>
                    @lang('common.footer.license.icp')
                    
                    @if(isset($locale) && $locale != 'en')
                    <br>
                    <a class="batb" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=11010802025060" target="_blank">@lang('common.footer.license.register')</a>
                    @else
                        <br><span style="display: inline-block;width: 185px;"></span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</footer>
