@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <div class="recepies">
        <button type="button" class="btn btn-success" onclick="addRecepie()">Add recepie</button>
        <div id='recepie-modal' class='modal hide normal-padding'>
            <button onclick="handleClose()" class='btn btn-danger close-btn'><i class="bi bi-x-lg"></i></button>
            <form id='recepie-form' action{{route('createRecepie')}} method='POST'>
              @csrf
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                  <div class="col">
                    <div class="form-outline">
                      <input name='recepie-name' type="text" id="recepie-name" class="form-control" />
                      <label class="form-label" for="recepie-name">Recepie name</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <input name='prep-time' type="number" id="prep-time" class="form-control" />
                        <label class="form-label" for="prep-time">Prep time</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-outline">
                        <input name='cook-time' type="number" id="cook-time" class="form-control" />
                        <label class="form-label" for="cook-time">Cook time</label>
                      </div>
                    </div>
                </div>
              
                <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <input name='calories' type="number" id="calories" class="form-control" />
                        <label class="form-label" for="calories">Calories</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-outline">
                        <input name='servings' type="number" id="servings" class="form-control" />
                        <label class="form-label" for="servings">Servings</label>
                      </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success" id='ingred-btn'>Add ingredient</button>
                <div id='ingred-input'>

                </div>
                
              
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Add</button>
              </form>
        </div>
        <table>
            @foreach ($recepies as $recepie)
                <tr>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
<script>
    const addRecepie = () => {
      $('#recepie-modal').addClass('show-modal').removeClass('hide')
    }

    const handleClose = () => {
      $('#recepie-modal').addClass('hide').removeClass('show-modal')
    }

    $('#ingred-btn').click(function () {
        event.preventDefault();
        let str = `<div><h2 class="form-label">Ingredient #${$('#ingred-input > div').length+1}</h2><div class="row mb-4">
            <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="ingred-name-${$('#ingred-input > div').length+1}">Ingredient name</label>
                        <input name='ingred-name-${$('#ingred-input > div').length+1}' type="text" id="ingred-name-${$('#ingred-input > div').length+1}" class="form-control" />
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="count-${$('#ingred-input > div').length+1}">Count</label>
                        <input name='count-${$('#ingred-input > div').length+1}' type="number" id="count-${$('#ingred-input > div').length+1}" class="form-control" />
                      </div>
                    </div>
                </div></div>`
        $('#ingred-input').append(str)
    })

    $('#recepie-form').submit(function () {
      event.preventDefault()
      $('.error').remove()
      let formData = $('#recepie-form').serializeArray();
      let error = 0;
      let newData = [];
      formData.map((dat) => {
        if (dat.value == '') {
          ++error
          $(`[name=${dat.name}]`).parent().append('<h4 class="error">Field cannot be empty</h4>')
          $(`[name=${dat.name}]`).addClass('error-input')
        } else {
          $(`[name=${dat.name}]`).removeClass('error-input')
        }
      })
      console.log({data: JSON.stringify(formData)})
      if (error === 0) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: "{{url('createrecepie')}}",
          type: "POST",
          data: JSON.stringify({data: formData}),
          traditional: true,
          contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
          success: function( response ) {
            console.log(response)
          },
          error: function(response) {
            console.log(response)
          }
        });
      }
    })
</script>
@endsection