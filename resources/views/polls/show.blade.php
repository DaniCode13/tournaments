@extends('layouts.app')

@section('content')

<div class="container">
    <show-poll :options="'{{$poll->options}}'" :title="'{{$poll->title}}'">
        </form-poll>
</div>

@endsection