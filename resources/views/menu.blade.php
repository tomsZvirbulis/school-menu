@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div>
        <div>
            <button class='btn btn-primary'>Api</button>
            <button class='btn btn-primary'>Local</button>
            <button class='btn btn-primary'>Mixed</button>
        </div>
        <div id='week-cont'>
            <Div>
                <h2>Monday</h2>
            </Div>
            <Div>
                <h2>Tuesday</h2>
            </Div>
            <Div>
                <h2>Wednesday</h2>
            </Div>
            <Div>
                <h2>Thursday</h2>
            </Div>
            <Div>
                <h2>Friday</h2>
            </Div>
        </div>
    </div>
    <Script>
        const api = () => {

        }

        const local = () => {

        }

        const mixed = () => {

        }
    </script>
@endsection