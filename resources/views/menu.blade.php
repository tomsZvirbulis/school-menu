@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div id='contain'>
        <div id='generate-btn'>
            <button onClick='handleLocal()' class='btn btn-primary'>Generate menu</button>
        </div>
        <table class='table'>
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
            if (Object.keys(res.recepies).length == 1) {
                let str = `<tr><td>${res.recepies[0].class_data.minYear} - ${res.recepies[0].class_data.maxYear}</td>`
                    for (let i = 0; i < 5; ++i) {
                        str+= `<td><a href='/recepie/${res.recepies[0][i].id}'>${res.recepies[0][i].name}</a></td>`
                    }
                    str+= '</tr>'
                    if ('res_rec' in res.recepies[0]) {
                        str+= `<tr><td>${res.recepies[0].class_data.minYear} - ${res.recepies[0].class_data.maxYear} restriction</td>`
                        for (let i = 0; i < 5; ++i) {
                            str+= `<td><a href='/recepie/${res.recepies[0]['res_rec'][i].id}'>${res.recepies[0]['res_rec'][i].name}</a></td>`
                        }
                        str+= '</tr>'
                    };
                    $(`tbody`).append(str)
            } else {
                res.recepies.map(elem => {
                    console.log(elem);
                    let str = `<tr><td>${elem.class_data.minYear} - ${elem.class_data.maxYear}</td>`
                    for (let i = 0; i < 5; ++i) {
                        str+= `<td><a href='/recepie/${elem[i].id}'>${elem[i].name}</a></td>`
                    }
                    str+= '</tr>'
                    if ('res_rec' in elem) {
                        str+= `<tr><td>${elem.class_data.minYear} - ${elem.class_data.maxYear} restriction</td>`
                        for (let i = 0; i < 5; ++i) {
                            str+= `<td><a href='/recepie/${elem['res_rec'][i].id}'>${elem['res_rec'][i].name}</a></td>`
                        }
                        str+= '</tr>'
                    };
                    $(`tbody`).append(str)
                })
            }
        }

    </script>
@endsection