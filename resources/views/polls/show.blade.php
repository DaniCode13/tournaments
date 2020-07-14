@extends('layouts.app')

@section('content')
<div class="container">
    <show-poll :data="{{$poll}}" :duplication="{{$duplication}}">
    </show-poll>
</div>

@endsection
