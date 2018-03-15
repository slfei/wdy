<?php
    $defaults = [
        'page_size' => 20,
        'pager_count' => 7,
        'current' => 1,
        'key' => 'page_num'
    ];
    foreach($defaults as $key => $value) {
        if (!isset($data[$key])) {
            $data[$key] = $value;
        }
    }
    if (isset($data['query'])) {
        $query = $data['query'];
    } else {
        $query = $_GET;
    }

    $pageQuery = function ($page) use($data, $query) {
        $key = $data['key'];
        $query[$key] = $page;
        return (isset($data['path']) ? $data['path'] : '').'?'.http_build_query($query);
    };
    $curr = $data['current'];
    $pageCount = ceil($data['total'] / $data['page_size']);

    if ($pageCount <= $data['pager_count']) {
        $start = 1;
        $end = $pageCount;
    } else {
        $prevNum = ceil(($data['pager_count'] - 1) / 2);
        $nextNum = floor(($data['pager_count'] - 1) /2);
        if ($curr - $prevNum < 1) {
            $start = 1;
            $end = $nextNum + $prevNum + 1;
        } else if ($curr + $nextNum > $pageCount){
            $start = $curr - $prevNum;
            $end = $pageCount;
        } else {
            $start = $curr - $prevNum;
            $end = $curr + $nextNum;
        }
    }
?>
<div class="w-pagination clearfix text-center">
    {{--<a class="page-init-sty head" href="{{ $pageQuery(1) }}">@lang('public.page_first')</a>--}}
    @if($curr > 1)
    <a class="page-init-sty w-next-page"
        href="{{ $pageQuery($curr - 1) }}" >
       <i class="ion-ios-arrow-left"></i>
    </a>
    @endif

    @for($i = $start; $i <= $end; $i++)
        <a class="each-page @if($curr == $i) w-active-page @else page-init-sty @endif" href="{{ $pageQuery($i) }}">{{ $i }}</a>
    @endfor

    @if($curr < $pageCount)
    <a class="page-init-sty w-next-page"
         href="{{ $pageQuery($curr+ 1) }}"  >
        <i class="ion-ios-arrow-right"></i>
    </a>
    @endif
    {{--<a class="page-init-sty tail" href="{{ $pageQuery($pageCount) }}">@lang('public.page_last')</a>--}}
</div>
