@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

{{-- 
@foreach ($cities as $city_name => $city_quote)
    <p>{{ $city_name}} = {{ $city_quote}}</p>
@endforeach --}}

<div class="container-fluid">
    <h1>ようこそ！ Dictionary API へ！ </h1>
 

{{-- <p>{{ $datenow }}</p> --}}
</div>

@endsection