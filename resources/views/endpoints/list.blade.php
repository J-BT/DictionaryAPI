@extends('layouts.app')

@section('title', 'Les Endpoints')

@section('content')

<div class="container-fluid">
    <h2>Liste des endpoints</h2>
    <div class="endpointSearch">
        <form class="" id="jisho_historiesAjax" action="" method="GET">
            <h3 class="endpointTitle">/api/jisho/{<span class="endpointVariable">category</span>}/{<span class="endpointVariable">search}</span></h3>
            <div class="input-group">
                <span class="badge bg-primary">GET</span>
                <span class="input-group-text" id="basic-addon1">/api/jisho_histories</span>
                <input type="hidden" class="form-control" placeholder="all" aria-label="all" aria-describedby="basic-addon1" disabled>
                
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </form>
        <div class="resultEndpointCall"  style='' id="resultJishoHistories"></div>
    </div>

    <div class="endpointSearch">
        <form class="" id="jisho_search_homeAjax" action="" method="GET">
            <h3 class="endpointTitle">/api/jisho/{<span class="endpointVariable">category</span>}/{<span class="endpointVariable">search}</span></h3>
            <div class="input-group">
                <span class="badge bg-primary">GET</span>
                <span class="input-group-text" id="basic-addon1">/api/jisho/</span>
                <input type="text" class="form-control" name="category" id="category" placeholder="category" >
                <span class="input-group-text" id="basic-addon1">/</span>
                <input type="text" class="form-control" name="search" id="search" placeholder="search" >

                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </form>
        <div class="resultEndpointCall"  style='' id="resultJisho"></div>
    </div>


    <div class="endpointSearch">
        <form class="" action="{{ route('wordreference_search_home') }}" method="GET">
            <h3 class="endpointTitle">/api/wordreference/{<span class="endpointVariable">category</span>}/{<span class="endpointVariable">search}</span></h3>
            <div class="input-group">
                <span class="badge bg-primary">GET</span>
                <span class="input-group-text" id="basic-addon1">/api/wordreference/</span>
                <input type="text" class="form-control" name="category" placeholder="category" >
                <span class="input-group-text" id="basic-addon1">/</span>
                <input type="text" class="form-control" name="search" placeholder="search" >

                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </form>
        <div class="resultEndpointCall"></div>
    </div>

{{-- <p>{{ $datenow }}</p> --}}
</div>

@endsection