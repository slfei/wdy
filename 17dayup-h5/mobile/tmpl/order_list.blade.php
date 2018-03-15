@foreach ($data as $order_li)
		<li class="white_bg clearfix">
			<div class="order_no clearfix">
				<span class="pull-left">
					{{$order_li['add_time']}}&nbsp;
					订单号: {{$order_li['order_id']}}
				</span>
				<span class="pull-right">
					{{$order_li['status']}}
				</span>
			</div>
			<div class="order_detail gray_bg clearfix">
				<div class="order_img pull-left">
					<img src="{{$order_li['course_img']}}">
				</div>
				<div class="order_desc pull-left">
					<p>{{$order_li['course_name']}}</p>
					<p class="total_price pull-right">合计：¥ {{$order_li['real_price']}}</p>
				</div>
			</div>
			<div class="operate_order clearfix">
				<div class="pull-right">
					@if($order_li['balance_status']==1)
					<!-- 1-代付款 未支付 -->
					<a class="btn-base w-btn-primary js-order-cancel" 
						data-order-id="{{$order_li['order_id']}}">取消订单</a>
					<a href="JavaScript:void(0)" class="btn-base w-btn-pay js_pay" data-id="{{$order_li['order_id']}}">去支付</a>
					@elseif($order_li['balance_status']==3)
						@if($order_li['is_learn'])
							<a href="/course/{{$order_li['course_id']}}?tab=1&autoPlay=true" class="btn-base w-btn-begin">开始学习</a>
						@endif
						@if($order_li['is_refund']==1)
							<a href="/order/refundapply?order_id={{$order_li['order_id']}}" class="btn-base w-btn-primary">申请退款</a>
						@elseif($order_li['is_learn'])
							@if(!$order_li['is_comment'])
								<a href="/center/publishcomment?course_id={{$order_li['course_id']}}" class="btn-base w-btn-begin">我要评价</a>
							@else
								<a href="/center/publishcomment?course_id={{$order_li['course_id']}}" class="btn-base w-btn-begin">查看评价</a>
							@endif
						@endif
					@elseif($order_li['balance_status']==2)
					<!-- 2-交易关闭 取消订单，可以进行删除操作 -->
					<a class="btn-base w-btn-primary js-order-del" 
						data-order-id="{{$order_li['order_id']}}">删除订单</a>
					<a href="javascript:void(0)" data-id="{{$order_li['course_id']}}" class="btn-base w-btn-begin aginBuy">再次购买</a>
					@elseif($order_li['balance_status']==4)
					<!-- 4-退款确认中 退款申请中 -->
					<a  class="btn-base w-btn-primary js-order-refund" data-order-id="{{$order_li['order_id']}}"  id="order_{{$order_li['id']}}">取消退款</a>
					<a href="/order/refundresult?order_id={{$order_li['order_id']}}" class="btn-base w-btn-begin">查看退款</a>
					@elseif($order_li['balance_status']==5)
					<!-- 5-退款处理中  -->
					<a href="/order/refundresult?order_id={{$order_li['order_id']}}" class="btn-base w-btn-begin">查看退款</a>
					@elseif($order_li['balance_status']==6)
					<!-- 6-退款完成 -->
					<a href="/order/refundresult?order_id={{$order_li['order_id']}}" class="btn-base w-btn-begin">查看退款</a>
					@endif
				</div>
			</div>
		</li>
@endforeach

@if(count($data)==0)
		<div class="no-result pure">
            <i class="icon icon-empty"></i>
            <div class="empty-desc">暂无相关订单</div>
        <div>
@endif
