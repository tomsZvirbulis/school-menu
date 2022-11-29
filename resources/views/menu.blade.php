@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div id='contain'>
        <div>
            <button class='btn btn-primary'>Api</button>
            <button onClick='handleLocal()' class='btn btn-primary'>Local</button>
            <button class='btn btn-primary'>Mixed</button>
        </div>
        <div id='week-cont'>
            <Div>
                <h2>Monday</h2>
                <div></div>
            </Div>
            <Div>
                <h2>Tuesday</h2>
                <div></div>
            </Div>
            <Div>
                <h2>Wednesday</h2>
                <div></div>
            </Div>
            <Div>
                <h2>Thursday</h2>
                <div></div>
            </Div>
            <Div>
                <h2>Friday</h2>
                <div></div>
            </Div>
        </div>
    </div>
    <Script>
        const api = () => {

        }

        const handleLocal = () => {

            $.ajax({
                url: '{{url("getlocalmenu")}}',
                type: 'post',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function( response ) {
                    console.log(response)
                },
                error: function(response) {
                    console.log(response)
                }
            })
        }

        const mixed = () => {

        }
    </script>
@endsection