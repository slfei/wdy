@foreach($data as $item)
<li>
    <div class="coupon">
        <div class="coupon_top">
                <div class="coupon_price"><span class="coupon_icon">¥</span> {{$item['coupon_amount']}}</div> 
                <div class="coupon_info">
                    <div class="coupon_name">{{$item['coupon_name']}}</div>
                    <div class="coupon_dedline">限{{$item['end_time']}}前可用</div>
                </div>
        </div>
        <div class="coupon_bottom coupon_range">
                适用范围:{{$item['flag_name']}}
        </div>
    </div>
</li>
@endforeach
