@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@section('content')
@if (Auth::user()->master == 1)
    <div class="user">
        <div class="reg-worker">
            <form action="">
                <h1>Register new worker</h1>
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example1" class="form-control" />
                        <label class="form-label" for="form6Example1">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="text" id="form6Example2" class="form-control" />
                        <label class="form-label" for="form6Example2">Last name</label>
                        </div>
                    </div>
                </div>
            
                <!-- Email input -->
                <div class="form-outline mb-4">
                <input type="email" id="form6Example5" class="form-control" />
                <label class="form-label" for="form6Example5">Email</label>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example1" class="form-control" />
                        <label class="form-label" for="form6Example1">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                        <input type="password" id="form6Example2" class="form-control" />
                        <label class="form-label" for="form6Example2">Confirm password</label>
                        </div>
                    </div>
                </div>
            
                <!-- Submit button -->
                <button onClick="event.preventDefault()" type="submit" class="btn btn-primary btn-block">Register worker</button>
            </form>
        </div>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    @endif
@endif

@endsection