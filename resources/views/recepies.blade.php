@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@if (isset($recepies))
    <div class="recepies">
        <button type="button" class="btn btn-success" onclick="addRecepie()">Add recepie</button>
        <div id='recepie-modal' class='modal hide normal-padding'>
            <button onclick="handleClose()" class='btn btn-danger close-btn'><i class="bi bi-x-lg"></i></button>
            <form id='recepie-form' action{{route('createRecepie')}} method='POST'>
              @csrf
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                  <div class="f-field col">
                    <div class="form-outline">
                      <label class="form-label" for="recepie-name">Recepie name</label>
                      <input name='recepie-name' type="text" id="recepie-name" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                    <div class="f-field col">
                      <div class="form-outline">
                        <label class="form-label" for="prep-time">Prep time</label>
                        <input name='prep-time' type="number" id="prep-time" class="form-control" />
                      </div>
                    </div>
                    <div class="f-field col">
                      <div class="form-outline">
                        <label class="form-label" for="cook-time">Cook time</label>
                        <input name='cook-time' type="number" id="cook-time" class="form-control" />
                      </div>
                    </div>
                </div>
              
                <div class="row mb-4">
                    <div class="f-field col">
                      <div class="form-outline">
                        <label class="form-label" for="calories">Calories</label>
                        <input name='calories' type="number" id="calories" class="form-control" />
                      </div>
                    </div>
                    <div class="f-field col">
                      <div class="form-outline">
                        <label class="form-label" for="servings">Servings</label>
                        <input name='servings' type="number" id="servings" class="form-control" />
                      </div>
                    </div>
                </div>

                <div class="row mb-4">
                  <div class="f-field col">
                    <div class="form-outline">
                      <label for="instructions" class="form-label">Instructions</label>
                      <textarea class="form-control" name='instructions' id="instructions" rows="3"></textarea>
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
        <table class="regular-table table">
            <tr class="reg-table-hr">
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Cook time</th>
              <th scope="col">Prep time</th>
              <th scope="col">Calories</th>
              <th scope='col'></th>
            </tr>
            @foreach ($recepies as $key => $recepie)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td><a href='recepie/{{$recepie->id}}'>{{$recepie->name}}</a></td>
                    <td>{{floor($recepie->cook_time / 60)}} h {{$recepie->cook_time % 60}} min</td>
                    <td>{{floor($recepie->prep_time / 60)}} h {{$recepie->prep_time % 60}} min</td>
                    <td>{{$recepie->calories}}</td>
                    <td><button onClick='handleRecepieDelete({{$recepie->id}})' class="btn btn-danger"><i class="bi bi-x-lg"></i></button></td>
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
      $('#ingred-input').empty()
    }

    const handleRecepieDelete = (id) => {
      $.ajax({
        url: `{{url('delete/${id}')}}`,
        type: 'delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        success: function( response ) {
            console.log(response)
            location.reload()
          },
          error: function(response) {
            alert(response.responseJSON.error)
          }
      })

    }

    $('#ingred-btn').click(function () {
        event.preventDefault();
        let str = `<div id='ingred-cont-${$('#ingred-input > div').length+1}'><h2 class="form-label">Ingredient #${$('#ingred-input > div').length+1}</h2><div class="row mb-4">
            <div class="ingr-cont row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="ingred-name-${$('#ingred-input > div').length+1}">Ingredient name</label>
                        <select name='ingred-${$('#ingred-input > div').length+1}' class='js-example-templating'> 
                              <option value="">Select a Ingredient...</option>
                              <?php
                                foreach ($ingredients as $ingr) {
                                  echo '<option value="'.$ingr->id.'">'.$ingr->name.'</option>';
                                }
                              ?>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="count-${$('#ingred-input > div').length+1}">Count</label>
                        <input name='count-${$('#ingred-input > div').length+1}' type="number" id="count-${$('#ingred-input > div').length+1}" class="form-control" />
                      </div>
                      <div class="ingr-ms">
                        <label class="form-label" for="mes-${$('#ingred-input > div').length+1}">Measurements</label>
                        <select name='mes-${$('#ingred-input > div').length+1}'> 
                                <option value="tbsp">tablespoon</option>
                                <option value="tsp">teaspoon</option>
                                <option value="oz">Table ounce</option>
                                <option value="fl. oz">fluid ounce</option>
                                <option value="c">cup</option>
                                <option value="qt">quart</option>
                                <option value="pt">pint</option>
                                <option value="gal">gallon</option>
                                <option value="lb">pound</option>
                                <option value="mL">milliliter</option>
                                <option value="g">grams</option>
                                <option value="kg">kilogram</option>
                                <option value="l">liter</option>
                          </select>
                      </div>
                    </div>
                    <button style='width: 2.5rem;' onClick='closeIngred(${$('#ingred-input > div').length+1})' class="btn btn-danger"><i class="bi bi-x-lg"></i></button>
                </div></div>`
        $('#ingred-input').append(str)
    })

    function closeIngred(id) {
      event.preventDefault();
      $(`#ingred-cont-${id}`).remove()
    }

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
      if (error === 0) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: "{{url('createrecepie')}}",
          type: "POST",
          data: {"data": JSON.stringify(formData)},
          traditional: true,
          success: function( response ) {
            console.log(response.msg)
            location.reload()
          },
          error: function(response) {
            alert(response.responseJSON.error)
          }
        });
      }
    })
</script>
@endif
@if (!isset($recepies)) 
<div>
  <h1>You can't view recepies</h1>
</div>
@endif
@endsection