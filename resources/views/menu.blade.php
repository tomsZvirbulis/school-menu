@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
    <div id='contain'>
        @if (Auth::user()->assigned_school || Auth::user()->school_id)
            @if (Auth::user()->assigned_school)
                <div id='generate-btn'>
                    <button onClick='handleLocal()' class='btn btn-primary'>Generate menu</button>
                </div>
            @endif
        @endif
            <div class="c-block-table">
                @if (isset($menu))
                    @foreach ($menu as $item)
                        <div class='c-block-row left'>
                            <div class="c-block-title">
                                <h2 class="c-row-title c-row-block-title">{{$item['data']['minYear']}} - {{$item['data']['maxYear']}}</h2>
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
                                        @foreach ($item["recepies"] as $recepie)
                                            <div><a href={{'recepie/'.$recepie['id']}}>{{$recepie['name']}}</a></div>
                                        @endforeach
                                    </div>
                                @endif
                                @if (count($item) > 2)
                                    <div class="res-columns c-columns">
                                        <span>Restricted</span>
                                        @foreach ($item["res_rec"] as $res_recepie)
                                            <div><a href={{'recepie/'.$res_recepie['id']}}>{{$res_recepie['name']}}</a></div>
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
            console.log(res)
            if (Object.keys(res.recepies).length >= 1) {
                $(`.c-block-table`).empty()
                Object.keys(res.recepies).forEach((key) => {
                    let element = res.recepies[key]
                    let text = "<div class='c-block-row left'>"
                    for (const data in element) {
                        if (data == "data") {
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