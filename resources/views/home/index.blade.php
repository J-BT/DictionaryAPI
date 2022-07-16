@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<h1>ようこそ！ Dictionary API へ！ </h1>
{{-- 
@foreach ($cities as $city_name => $city_quote)
    <p>{{ $city_name}} = {{ $city_quote}}</p>
@endforeach --}}

<h2>Liste de endpoints</h2>

<h3>/api/jisho_histories</h3>
<form action="{{ route('jisho_histories') }}" method="GET">
    <div class="mb-3">
        <label for="jisho_histories" class="form-label">jisho_histories</label>
        <input type="hidden" class="form-control" id="jisho_histories" > 
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<h3>jisho/{category}/{search}</h3>
<form action="{{ route('jisho_search', ['category' => "jpen", 'search' => "成功"]) }}" method="GET">
    <div class="mb-3">
        <label for="jisho_search" class="form-label">category</label>
        <input type="text" class="form-control" id="category" > 

        <label for="jisho_search" class="form-label">search</label>
        <input type="text" class="form-control" id="search" >
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

{{-- <p>{{ $datenow }}</p> --}}

@endsection