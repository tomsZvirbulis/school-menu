@extends('layouts.main')

@section('content')
    <div class="recepies">
        <button type="button" class="btn btn-success" onclick="addRecepie()">Add recepie</button>
        <div calss='model'>
            <form action='/test'>
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
                
                <!-- Message input -->
                <div class="form-outline mb-4">
                  <textarea class="form-control" id="form6Example7" rows="4"></textarea>
                  <label class="form-label" for="form6Example7">Additional information</label>
                </div>
              
                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form6Example8" checked />
                  <label class="form-check-label" for="form6Example8"> Create an account? </label>
                </div>
              
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Place order</button>
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

    }

    $('#ingred-btn').click(function () {
        event.preventDefault();
        let str1 = `<div><h2 class="form-label">Ingredient #${$('#ingred-input div').length+1}</h2><label class="form-label" for="ingred-name">Ingredient name</label><input name="ingred-name" type="number" id="ingred-name" class="form-control" />`
        let str = `<div><h2 class="form-label">Ingredient #${$('#ingred-input div').length+1}</h2><div class="row mb-4">
            <div class="row mb-4">
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="ingred-name">Ingredient name</label>
                        <input name='calories' type="number" id="ingred-name" class="form-control" />
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-outline">
                        <label class="form-label" for="servings">Servings</label>
                        <input name='servings' type="number" id="servings" class="form-control" />
                      </div>
                    </div>
                </div></div>`
        $('#ingred-input').append(str)
    })
</script>
@endsection