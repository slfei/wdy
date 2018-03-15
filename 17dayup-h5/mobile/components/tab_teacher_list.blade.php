@foreach($list as $items)
    @component('mobile.components.tab_teacher_item', ['item' => $items])
    @endcomponent
@endforeach
