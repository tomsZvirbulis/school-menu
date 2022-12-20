@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div id='welcome'>
        <div id='welcome-cont'>
            <h1>Welcome!</h1>
            <p>This website helps creating food menu for schools based on calories and children eating restrictions.</p>
        </div>
    </div>
    <div id='info-cards'>
        <div id='caterer-info'>

        </div>
        <div id='school-info'>
            
        </div>
    </div>
@endsection