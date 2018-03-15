@foreach($list as $items)
    @component('mobile.components.tab_comment_item', ['item' => $items])
    @endcomponent
@endforeach
