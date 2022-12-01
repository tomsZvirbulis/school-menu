@extends('layouts.main')

@section('content')
    <div>
        @foreach ($data as $recepie)
            <h1>{{$recepie->name}}</h1>
        @endforeach
    </div>
@endsection