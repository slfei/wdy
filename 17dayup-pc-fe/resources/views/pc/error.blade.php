@extends('pc.common')

@section('style')
    <style>
        .error-msg {
            min-height: 300px;
            margin-top: 160px;
            font-size: 28px;
            text-align: center;
        }
    </style>
    @stop
@section('main')
    <div class="error-msg">
        <div class="msg">{{ $tplData['msg'] }}</div>
    </div>
@stop
