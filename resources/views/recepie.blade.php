@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div id='recepie-container'>
        @if (isset($data))
            {{-- {{dd($data)}} --}}
            <h1>{{$data['recepies']['name']}}</h1>
            <div id='detail-bar'>
                <Div>
                    <p>{{floor($data['recepies']['prep_time']/60)}}h {{$data['recepies']['prep_time']%60}}min</p>
                    <p><b>Prep Time</b></p>
                </Div>
                <Div>
                    <p>{{floor($data['recepies']['cook_time']/60)}}h {{$data['recepies']['cook_time']%60}}min</p>
                    <p><b>Cook Time</b></p>
                </Div>
                <Div>
                    <p>{{$data['recepies']['calories']}}</p>
                    <p><b>Calories</b></p>
                </Div>
                <Div>
                    <p>{{$data['recepies']['servings']}}</p>
                    <p><b>Servings</b></p>
                </Div>
            </div>
            <div id='instruction'>
                <p>{{$data['instruction']}}<p>
            </div>
            <div>
                <h3>Ingredients</h3>
                <hr>
                <ul>
                    @foreach ($data['ingredients'] as $ingredient)
                        <li>{{$ingredient[2]}}{{$ingredient[3]}} {{$ingredient[0]}}</li>

                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection