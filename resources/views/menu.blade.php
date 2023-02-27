@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
    <div id='contain'>
        <div id='generate-btn'>
            <button onClick='handleLocal()' class='btn btn-primary'>Generate menu</button>
        </div>
            <div class="c-block-table">
                @if (isset($menu))
                    @foreach ($menu as $item)
                        <div class='c-block-row left'>
                            <div class="c-block-title">
                                <h2 class="c-row-title c-row-block-title">{{$item['class_info']->minYear}} - {{$item['class_info']->maxYear}}</h2>
                            </div>
                            <div class="c-content-block">
                                <div>
                                    <span></span>
                                    <p>Monday</p>
                                    <p>Tuesday</p>
                                    <p>Wednesday</p>
                                    <p>Thursday</p>
                                    <p>Friday</p>
                                </div>
                                @if (count($item) >= 1)
                                    <div class="c-columns">
                                        <span>Normal</span>
                                        @foreach ($item[0] as $recepie)
                                            <div><a href={{'recepie/'.$recepie['recepie']}}>{{$recepie['recepie_name']}}</a></div>
                                        @endforeach
                                    </div>
                                @endif
                                @if (count($item) > 2)
                                    <div class="res-columns c-columns">
                                        <span>Restricted</span>
                                        @foreach ($item[1] as $res_recepie)
                                            <div><a href={{'recepie/'.$res_recepie['recepie']}}>{{$res_recepie['recepie_name']}}</a></div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
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
            if (Object.keys(res.recepies).length >= 1) {
                $(`.c-block-table`).empty()
                console.log(res.recepies)
                res.recepies.forEach((element, index) => {
                    let text = "<div class='c-block-row left'>"
                    for (const data in element) {
                        if (data == "class_data") {
                            text += `
                            <div class="c-block-title">
                                <h2 class="c-row-title c-row-block-title">${element[data].minYear} - ${element[data].maxYear}</h2>
                            </div>
                            <div class="c-content-block">
                                <div>
                                    <span></span>
                                    <p>Monday</p>
                                    <p>Tuesday</p>
                                    <p>Wednesday</p>
                                    <p>Thursday</p>
                                    <p>Friday</p>
                                </div>
                                `
                        } else if (data == "recepies") {
                            text += `
                                <div class="c-columns">
                                    <span>Normal</span>
                                `
                            element[data].forEach(recepie => {
                                text += `
                                    <div><a href=${'recepie/' + recepie.id}>${recepie.name}</a></div>
                                `
                            })
                            text += `</div>`
                            
                        } else if (data == "res_rec") {
                            text += `
                                    <div class="res-columns c-columns">
                                        <span>Restricted</span>
                                `
                            element[data].forEach(recepie => {
                                text += `<div><a href=${'recepie/'+ recepie.id}>${recepie.name}</a></div>`
                            })
                            text += `</div>`
                        }
                    }
                    text += `</div></div>`
                    $(`.c-block-table`).append(text);
                })
            }
        }

    </script>
@endsection