@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

{{-- 
@foreach ($cities as $city_name => $city_quote)
    <p>{{ $city_name}} = {{ $city_quote}}</p>
@endforeach --}}

<div class="container-fluid">
    <h1>ようこそ！ Dictionary API へ！ </h1>
    <h2>Liste de endpoints</h2>

    <div class="endpointSearch">
        <h3>/api/jisho_histories</h3>
        <form action="{{ route('jisho_histories') }}" method="GET">
            <div class="mb-3">
                <label for="jisho_histories" class="form-label">jisho_histories</label>
                <input type="hidden" class="form-control" id="jisho_histories" > 
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <div class="endpointSearch">
        <h3>jisho/{category}/{search}</h3>
        <form action="{{ route('jisho_search_home') }}" method="GET">
            <div class="mb-3">
                <label for="jisho_search" class="form-label">category</label>
                <input type="text" class="form-control" id="category" name="category"> 
            </div>
    
            <div class="mb-3">
                <label for="jisho_search" class="form-label">search</label>
                <input type="text" class="form-control" id="search" name="search">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <div class="endpointSearch">
        <h3>wordreference/{category}/{search}</h3>
        <form action="{{ route('wordreference_search_home') }}" method="GET">
            <div class="mb-3">
                <label for="wordreference" class="form-label">category</label>
                <input type="text" class="form-control" id="category" name="category"> 
            </div>
            <div class="mb-3">
                <label for="wordreference" class="form-label">search</label>
                <input type="text" class="form-control" id="search" name="search">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

{{-- <p>{{ $datenow }}</p> --}}
</div>

@endsection