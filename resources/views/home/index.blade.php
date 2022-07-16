@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<h1>ようこそ！ Dictionary API へ！ </h1>

@foreach ($cities as $city_name => $city_quote)
    <p>{{ $city_name}} = {{ $city_quote}}</p>
@endforeach


<p>{{ $datenow }}</p>

@endsection