<?php $nav_index = isset($nav_index) ? $nav_index : 0;  ?>

<div class="bar bar-tab footer">
    <div class="row">
        <a href="/" class="col @if($nav_index == 0) active @endif">
            <i class="icon icon-home"></i>
            <div>
                首页
            </div>    
        </a>

        <a href="/course/classify" class="col @if($nav_index == 1) active @endif">
            <i class="icon icon-square"></i>
            <div>
                分类
            </div>      
        </a>
        <a href="/center/course" class="col @if($nav_index == 2) active @endif">
            <i class="icon icon-book"></i>
            <div>
                课表
            </div>         
        </a>
        <a href="/center" class="col @if($nav_index == 3) active @endif">
            <i class="icon icon-user"></i>
            <div>
                我的
            </div>    
        </a>
    </div>
</div>
