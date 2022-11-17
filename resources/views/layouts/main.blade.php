<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class=><nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="left">
            <a class="navbar-brand" href="/home">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
            </div>
        </div>
          <div class="right">
            <span class="navbar-text">
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 sm:block">
                        @auth
                            <div class="loged-in">
                                <h3><a href='/user'>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></h3>
                                <button onClick="handleLogout()" class='btn btn-danger'><i class="bi bi-box-arrow-right"></i></button>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline"><button class="btn btn-primary">Login in</button></a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"><button class='btn btn-primary'>Register</button></a>
                            @endif
                        @endauth
                    </div>
                @endif
            </span>
          </div>
          
        </div>
      </nav>
    </div>
    @yield('content')
    <script>
        const logoutForm = document.getElementById('logout-form')

        const handleLogout = () => {
            event.preventDefault();
            logoutForm.submit();
        }
    </script>
</body>
</html>