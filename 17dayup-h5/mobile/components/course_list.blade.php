
@foreach($tplData['list'] as $item)
    @component('mobile.components.course_item', ['course_data' => $item])
    @endcomponent
@endforeach
