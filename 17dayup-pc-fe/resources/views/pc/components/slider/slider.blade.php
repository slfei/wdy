<?php
    $colors = array();
    foreach($data as $item) {
        if (isset($item['color'])) {
            array_push($colors, $item['color']);
        }
    }
?>

<div class="j-slider banner-slider" data-colors='{!! json_encode($colors) !!}'>
    <ul class="slider-wrap">
        @foreach($data as $item)
            <li class="slide-item" @if(isset($item['color'])) style="background: {{$item['color']}}"@endif>
                <a href="{{ isset($item['url']) ? $item['url'] : '' }}" target="_blank">
                    <img src="{{$item['image']}}" alt="{{$item['text']}}"/>
                </a>
            </li>
        @endforeach
    </ul>
</div>
