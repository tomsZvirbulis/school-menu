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
                        <input type="text" id="form6Example1" name='first_name' class="form-control" />
                        <label class="form-label" for="form6Example1">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example2" class="form-control" name='last_name' />
                        <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                    </div>
                </div>
            
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="form6Example5" name='email' class="form-control" />
                    <label class="form-label" for="form6Example5">Email</label>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example1" name='school_name' class="form-control" />
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
                        <input type="password" id="form6Example1" name='password' class="form-control" />
                        <label class="form-label" for="form6Example1">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example2" name='confirm_password' class="form-control" />
                        <label class="form-label" for="form6Example2">Confirm password</label>
                        </div>
                    </div>
                </div>
            
                <!-- Submit button -->
                <button onClick='handleSubmit(school)' type="submit" class="btn btn-primary btn-block">Register school</button>
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
                        <input type="text" id="form6Example1" name='first_name' class="form-control" />
                        <label class="form-label" for="form6Example1">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example2" class="form-control" name='last_name' />
                        <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                    </div>
                </div>
            
                <!-- Email input -->
                <div class="form-outline mb-4">
                <input type="email" id="form6Example5" name='email' class="form-control" />
                <label class="form-label" for="form6Example5">Email</label>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example1" name='password' class="form-control" />
                        <label class="form-label" for="form6Example1">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example2" name='confirm_password' class="form-control" />
                        <label class="form-label" for="form6Example2">Confirm password</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
  
                        @if (count($schools) > 0)
                            <select name='school_id' class="select form-control-lg" required>
                                @foreach ($schools as $school)
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
                        <input type="text" id="class_name" name='class_name' class="form-control" />
                        <label class="form-label" for="class_name">Name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="number" id="student_count" class="form-control" name='student_count' />
                        <label class="form-label" for="student_count">Student count</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="number" id="grade" name='grade' class="form-control" />
                        <label class="form-label" for="grade">Grade</label>
                        </div>
                    </div>
                </div>
            
                <!-- Submit button -->
                <button onClick='handleSubmit(school)' type="submit" class="btn btn-primary btn-block">Add class</button>
            </form>

        </div>
    </div>
    <script>
        const workerForm = document.getElementById('worker-form');
        const schoolForm = document.getElementById('school-form')

        const ajaxQuery = () => {
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        url: "{{url('"+url+"')}}",
                        type: "POST",
                        data: $('#class-form').serialize(),
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
@endsection