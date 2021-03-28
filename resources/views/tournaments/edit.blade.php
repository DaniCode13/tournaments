@extends('layouts.app')

@section('content')
<div class="container">
    <tournament :data="{{$tournament}}"></tournament>
</div>
@endsection
