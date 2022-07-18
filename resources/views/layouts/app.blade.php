<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <title>Dictionary API - @yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #141325;">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('home') }}">Dictionary API</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">API Documentation</a>
              </li> --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    API Documentation
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('endpoints') }}">Getting Started</a></li>
                  <li><a class="dropdown-item" href="{{ route('endpoints') }}">Endpoints</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://www.wordreference.com/">Wordreference</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://jisho.org/">Jisho</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">About</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <div>
        @yield('content')
    </div>
</body>
</html>