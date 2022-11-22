@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@section('content')
@if (Auth::user()->master == 1 && (Auth::user()->caterer_id != null || Auth::user()->school_id != null))
    <div class="user">
        <div class="reg-worker">
            <form id='worker-form' action={{route('createWorker')}} method='POST'>
                @csrf
                {{-- {{ dd(Auth::user()) }} --}}
                
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
            
                <!-- Submit button -->
                <button onClick='handleSubmit()' type="submit" class="btn btn-primary btn-block">Register worker</button>
            </form>
        </div>
    </div>
    <script>
        const form = document.getElementById('worker-form');

        const handleSubmit = () => {
            event.preventDefault();
            form.submit();
        }
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    @endif
@endif

@endsection