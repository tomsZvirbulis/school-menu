<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class=><nav class="cus-nav navbar navbar-expand-lg navbar-light bg-light">
        <div class="left">
            <a class="navbar-brand" href="/home">Home</a>
            <div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="color-link nav-item active">
                    <a class="nav-link" href="/recepies">Recepies</a>
                    </li>
                    <li class="color-link nav-item">
                    <a class="nav-link" href="/menu">Menu</a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
          <div class="right">
            <span class="navbar-text">
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 sm:block">
                        @auth
                            <div class="loged-in">
                                <h3><a href='user'>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></h3>
                                <button onClick="handleLogout()" class='btn btn-danger'><i class="bi bi-box-arrow-right"></i></button>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        @else
                            <div class='cus-nav'>
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline"><button class="btn btn-primary cus-btn">Login</button></a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"><button class='btn btn-primary cus-btn'>Register</button></a>
                                @endif
                            </div>
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
    <div id='footer'>

    </div>
</body>
</html>