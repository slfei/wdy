
@foreach($tplData['list'] as $item)
    @component('mobile.components.search_item', ['course_data' => $item])
    @endcomponent
@endforeach
