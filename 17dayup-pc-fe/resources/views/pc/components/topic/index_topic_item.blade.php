
<div class="hot-question">
    <div class="from-topic-list">
        <a class="from-topic" href="//www.51jianjiao.com/circle/topic/detail?topic_info={{ $data['topic_id'] }}" target="_blank" text="域名上线时更改，目前用的是测试机">
            # {{ $data['from_topic'] }}
        </a>
    </div>
    <a class="wt-media" href="//www.51jianjiao.com/circle/question/detail/{{$data['question_id']}}" target="_blank">
        <div class="media">
            <div class="media-title">
                {{ $data['question_name'] }}
            </div>
            <div class="media-body">
                <p class="rich-text description">
                    {{ $data['answer']['answer_content'] }}

                </p>
            </div>
            <div class="bottom clearfix">
                <div class="pull-left">
                    <img class="avatar" src="{{$data['answer']['user_info']['avatar_file'] }}"/>
                    <span class="name">{{ $data['answer']['user_info']['user_name'] }}</span>
                </div>
                <div class="pull-right ">
                    <span class="num">{{ $data['answer_users'] }}</span>人参与讨论
                </div>
            </div>
        </div>
    </a>
</div>
