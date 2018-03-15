
<?php
    $IS_ZH = !isset($locale) || $locale == 'zh_CN';
    $curPrice = !$IS_ZH && isset($data['en_cur_price']) ? '$ '.$data['en_cur_price'] : '￥'.$data['cur_price'];
    $price = !$IS_ZH && isset($data['en_price']) ? '$ '.$data['en_price'] : '￥'.$data['price'];
?>
@if( $data['cur_price'] < $data['price'])
    <span class="price">{{$curPrice}}</span>&nbsp;
    <span class="original-price">{{$price}}</span>
@else
    <span class="price">{{$curPrice}}</span>
@endif
