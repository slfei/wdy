<div class="media">
   <a href="/news/{{$data['news_id']}}" target="_blank" class="wt-media">
        <div class="media-title" title="{{$data['news_title']}}">{{$data['news_title']}}</div>
        @if(count($data['image']))
            <div class="media-left">
                <img src="{{$data['image'][0]}}">
            </div>
        @endif
        <div class="media-body">
            <div class="description">{{ $data['news_text'] }}</div>
        </div>
   </a>
        <div class="bottom">
            <span>{{$data['news_people']}}</span>
            <span class="pull-right">{{ explode(' ', $data['created_at'])[0] }}</span>
        </div>
</div>
