@foreach($list['list'] as $item)
    @component('mobile.components.tab_course_item', ['items' => $item])
    @endcomponent
@endforeach
