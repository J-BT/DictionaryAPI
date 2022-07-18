@extends('layouts.app')

@section('title', 'Home Page')

@section('content')


<div class="container-fluid">
    <h1>Dictionary API </h1>
 
    <div class="d-flex flex-row justify-content-around align-items-center">
        <div class="card mb-3" style="width: 18rem;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('images/david-iskander-iWTamkU5kiI-unsplash.jpg') }}" class="img-fluid rounded-start" alt="..." width="" height="">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Getting Started</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" style="width: 18rem;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('images/agence-olloweb-d9ILr-dbEdg-unsplash.jpg') }}" class="img-fluid rounded-start" alt="..." width="" height="">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Endpoints</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection


