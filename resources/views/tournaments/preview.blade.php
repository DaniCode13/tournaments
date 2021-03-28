
@extends('layouts.app')

@section('content')
<div class="container">
    <tournament-preview :data="{{$tournament}}"></tournament-preview>
</div>
@endsection
