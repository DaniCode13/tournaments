@extends('layouts.app')

@section('content')
<auth-container :type="'{{$type}}'"></auth-container>

@endsection