@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div id='contain'>
        <div>
            <button class='btn btn-primary'>Api</button>
            <button onClick='handleLocal()' class='btn btn-primary'>Local</button>
            <button class='btn btn-primary'>Mixed</button>
        </div>
        @if (isset($recepies))
            @foreach ($recepies as $recepie)
                <div>{{$recepie}}</div>
            @endforeach
        @endif
        <table id='week-cont'>
            <thead>
                <tr>
                    <th>Grade</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <Script>
        const api = () => {

        }

        const handleLocal = () => {

            $.ajax({
                url: '{{url("getlocalmenu")}}',
                type: 'get',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function( response ) {
                    importRecepie(response)
                },
                error: function(response) {
                    alert(response.responseJSON.error)
                }
            })
        }

        function importRecepie(res) {
            console.log(res);
            $(`tbody`).empty()
            res.recepies.map((elem) => {
                let str = `<tr><td>${elem.class_data.minYear} - ${elem.class_data.maxYear}</td>`
                for (let i = 0; i < 5; ++i) {
                    str+= `<td>${elem[i].name}</td>`
                }
                str+= '</tr>'
                $(`tbody`).append(str)
            })
        }

        const mixed = () => {

        }
    </script>
@endsection