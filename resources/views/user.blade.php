@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@section('content')
@if (Auth::user()->master == 1 && Auth::user()->caterer_id != null)
<div id="forms">
    {{-- register school --}}
    <div class="user">
        <div class="reg-school">
            <form id='school-form' action={{route('createSchool')}} method='POST'>
                @csrf
                
                <h1>Register new school</h1>
                <!-- 2 column grid layout with text inputs for the first and last names -->

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example1 school_first_name" name='first_name' class="form-control" required />
                        <label class="form-label" for="form6Example1">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example2 school_surname" class="form-control" name='last_name' required />
                        <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                    </div>
                </div>
            
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="form6Example5 school_email" name='email' class="form-control" required />
                    <label class="form-label" for="form6Example5">Email</label>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example1" name='school_name' class="form-control" required />
                        <label class="form-label" for="form6Example1">School name</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='address' type="text" id="address" class="form-control form-control-lg" required />
                        <label class="form-label" for="address">Address</label>
                      </div>
    
                    </div>

                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='address2' type="text" id="address2" placeholder="Apt" class="form-control form-control-lg" />
                        <label class="form-label" for="address2">Address 2</label>
                      </div>
    
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='city' type="text" id="city" class="form-control form-control-lg" required />
                        <label class="form-label" for="city">City</label>
                      </div>
    
                    </div>

                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='district' type="text" id="district" class="form-control form-control-lg" />
                        <label class="form-label" for="district">District</label>
                      </div>
    
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='country' type="text" id="country" class="form-control form-control-lg" required />
                        <label class="form-label" for="country">Country</label>
                      </div>
    
                    </div>

                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='post_code' type="text" id="post_code" class="form-control form-control-lg" />
                        <label class="form-label" for="post_code">Post code</label>
                      </div>
    
                    </div>
                  </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example1 school_password" name='password' class="form-control" required />
                        <label class="form-label" for="form6Example1">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example2 school_password_confirmation" name='confirm_password' class="form-control" required/>
                        <label class="form-label" for="form6Example2">Confirm password</label>
                        </div>
                    </div>
                </div>
            
                <!-- Submit button -->
                <button id="school_sub" onClick='handleSubmit(school)' type="submit" class="btn btn-primary btn-block">Register school</button>
            </form>
        </div>
    </div>

    {{-- Worker register --}}
    <div class="user">
        <div class="reg-worker">
            <form id='worker-form' action={{route('createWorker')}} method='POST'>
                @csrf
                
                <h1>Register new worker</h1>
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example1" name='first_name' class="form-control" required />
                        <label class="form-label" for="form6Example1">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example2" class="form-control" name='last_name' required />
                        <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                    </div>
                </div>
            
                <!-- Email input -->
                <div class="form-outline mb-4">
                <input type="email" id="form6Example5" name='email' class="form-control" required />
                <label class="form-label" for="form6Example5">Email</label>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example1" name='password' class="form-control" required />
                        <label class="form-label" for="form6Example1">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example2" name='confirm_password' class="form-control" required />
                        <label class="form-label" for="form6Example2">Confirm password</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
  
                        @if (count($data) > 0)
                            <select name='school_id' class="select form-control-lg" required>
                                @foreach ($data as $school)
                                    <option value={{ $school->id }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        @else
                                <h1>No schools</h1>
                        @endif  
  
                </div>
            
                <!-- Submit button -->
                <button onClick='handleSubmit(worker)' type="submit" class="btn btn-primary btn-block">Register worker</button>
            </form>
        </div>
    </div>
    <script>
        const workerForm = document.getElementById('worker-form');
        const schoolForm = document.getElementById('school-form')

        const ajaxQuery = (form, data) => {
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#submit').html('Please Wait...');
                $("#submit"). attr("disabled", true);
                $.ajax({
                        url: "{{url('"+url+"')}}",
                        type: "POST",
                        data: $('#'+form).serialize(),
                        success: function( response ) {
                            alert('worker registered')
                        }
            });
        }

        const handleSubmit = (name) => {
            event.preventDefault();
            if (name === 'worker') {
                ajaxQuery('worker-form', 'createworkers')
            } else {
                ajaxQuery('school-form', 'createschool')
            }
            
        }
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    @endif
</div>
@endif
@if (Auth::user()->school_id !=null)
<div id="forms">
    <button type='button' class='clas-btn btn btn-success' onClick='showClasses()'>Classes</button>
    <div class='modal hide normal-padding' id='classes-modal'>
        <button onclick="handleClose()" class='btn btn-danger close-btn'><i class="bi bi-x-lg"></i></button>
        <table class='table'>
            <tr>
                <th>#</th>
                <th>Class</th>
                <th>Students</th>
                <th>Grade</th>
                <th>Calories</th>
            </tr>
            @if ($class_grade)
                @foreach ($class_grade as $key => $list_data)
                    <tr>
                        <td><b>{{$key+1}}</td>
                        <td>{{$list_data['name']}}</td>
                        <td>{{$list_data['student_count']}}</td>
                        <td>{{$list_data['grade'][0]['minYear']}} - {{$list_data['grade'][0]['maxYear']}}</td>
                        <td>{{$list_data['grade'][0]['calories']}}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    {{-- register school --}}
    <div class="user">
        <div class="reg-school">
            <form id='class-form' action={{route('addClass')}} method='POST'>
                @csrf
                
                <h1>Add class</h1>
                <!-- 2 column grid layout with text inputs for the first and last names -->

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="class_name" name='class_name' class="form-control" required />
                        <label class="form-label" for="class_name">Name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="number" id="student_count" class="form-control" name='student_count' required />
                        <label class="form-label" for="student_count">Student count</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="form-label" for="grade_id">Grade</label>
                    @if ($data && count($data) > 0)
                            <select name='grade_id' class="select form-control-lg" required>
                                @foreach ($data as $grade)
                                    <option value={{ $grade->id }}>{{ $grade->minYear}} - {{ $grade->maxYear }}</option>
                                @endforeach
                            </select>
                        @else
                                <h1>No grades</h1>
                        @endif 
                </div>
            
                <!-- Submit button -->
                <button onClick='handleSubmit(school)' type="submit" class="btn btn-primary btn-block">Add class</button>
            </form>

        </div>
        <div class="restriction-from-container">
            <form id='restrictions-form' action={{route('addRestriction')}} method='POST'>
                @csrf
                
                <h1>Add allergies</h1>
                <!-- 2 column grid layout with text inputs for the first and last names -->

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                            @if (isset($class_grade) && count($class_grade) > 0)
                            <select name='class_id' class="select form-control-lg" required>
                                @foreach ($class_grade as $class)
                                    <option value={{ $class['id'] }}>{{ $class['name']}}</option>
                                @endforeach
                            </select>
                            @else
                                    <h1>No grades</h1>
                            @endif 
                            <label class="form-label" for="class_name">Class</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="number" id="student_count" class="form-control" name='student_count' required />
                        <label class="form-label" for="student_count">Student count</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="form-outline">
                        {{-- {{dd($ingredients)}} --}}
                        @if (count($ingredients) > 0)
                        <select name='ingredient' class="select" required>
                            @foreach ($ingredients as $ingredient)
                                {{-- {{var_dump($ingredient)}} --}}
                                @if (count($ingredient) > 1)
                                    <option class='category' value='C_{{ $ingredient[0]['ingredient_category'] }}'><b>{{ $ingredient['category']}}</b></option>
                                    @foreach ($ingredient as $ingr) 
                                        @if (gettype($ingr) != 'string')
                                            <option value={{ $ingr['id'] }}>{{ $ingr['name']}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        @else
                                <h1>No ingredients</h1>
                        @endif 
                    </div>
                </div>
            
                <!-- Submit button -->
                <button onClick='handleSubmit(restriction)' type="submit" class="btn btn-primary btn-block">Add restriction</button>
            </form>
        </div>
        
    </div>
    <script>

    const showClasses = () => {
      $('#classes-modal').addClass('show-modal').removeClass('hide')
    }

    const handleClose = () => {
      $('#classes-modal').addClass('hide').removeClass('show-modal')
    }

        const ajaxQuery = (form, data) => {
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#submit').html('Please Wait...');
                $("#submit"). attr("disabled", true);
                $.ajax({
                        url: "{{url('"+url+"')}}",
                        type: "POST",
                        data: $('#'+form).serialize(),
                        success: function( response ) {
                            alert('data sent')
                        }
            });
        }

        const handleSubmit = (name) => {
            event.preventDefault();
            if (name === 'class') {
                ajaxQuery('class-form', 'addclass')
            } else {
                ajaxQuery('restrictions-form', 'addrestriction')
            }
            
        }
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    @endif
</div>
@endif
@endsection