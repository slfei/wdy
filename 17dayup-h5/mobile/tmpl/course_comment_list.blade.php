@foreach($data as $comment)
<li class="border-bottom">
    <div class="wt-media clearfix">
        <div class="pull-left media-left">
            <img class="img-circle" src="{{$comment['avatar_url']}}">
            <div>{{$comment['nick_name']}}</div>
        </div>
        <div class="pull-left media-body">
            <div class="modal-title">
                <span class="ion-ios-star @if($comment['star']>=1) active @else ion-ios-star-outline gray @endif"></span>
                <span class="ion-ios-star @if($comment['star']>=2) active @else ion-ios-star-outline gray @endif"></span>
                <span class="ion-ios-star @if($comment['star']>=3) active @else ion-ios-star-outline gray @endif"></span>
                <span class="ion-ios-star @if($comment['star']>=4) active @else ion-ios-star-outline gray @endif"></span>
                <span class="ion-ios-star @if($comment['star']>=5) active @else ion-ios-star-outline gray @endif"></span>
                <p>{{$comment['text_content']}}</p>
            </div>
            <div class="time">{{$comment['date']}}</div>
            @if($comment['answer'])
            <ul class="list-unstyle revert">
                <li>
                    <span class="user">{{$comment['answer']['ins_show_name']}}</span>
                    回复:
                    <span>{{$comment['answer']['text']}}</span>

                    <div class="revert-time">{{$comment['answer']['created_at']}}</div>
                </li>
            </ul>
            @endif
        </div>
    </div>
</li>
@endforeach

@if(count($data)==0)
	<div class="no-result pure">
        <i class="icon icon-empty"></i>
        <div class="empty-desc">暂无评价</div>
    <div>
@endif
