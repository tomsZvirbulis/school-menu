@extends('layouts.main')
@section('content')
  <link rel="stylesheet" href="{{ asset('css/userAuth.css') }}">
  <section class="vh-100 gradient-custom">
      <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
          <div class="col-12 col-lg-9 col-xl-7">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
              <div class="card-body p-4 p-md-5">
                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Register</h3>
                <form method='POST' action='/register'>
                  @csrf
                  <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='company_name' type="text" id="company_name" class="form-control form-control-lg" required />
                        <label class="form-label" for="company_name">Company name</label>
                      </div>
    
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='first_name' type="text" id="firstName" class="form-control form-control-lg" required />
                        <label class="form-label" for="firstName">First Name</label>
                      </div>
    
                    </div>
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                        <input name='last_name' type="text" id="lastName" class="form-control form-control-lg" required />
                        <label class="form-label" for="lastName">Last Name</label>
                      </div>
    
                    </div>
                  </div>
    
                  <div class="row">
                    <div class="col-md-12 mb-4 pb-2">
    
                      <div class="form-outline">
                        <input name='email' type="email" id="emailAddress" class="form-control form-control-lg" required />
                        <label class="form-label" for="emailAddress">Email</label>
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
                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
    
                      <div class="form-outline">
                        <input name='password' type="password" id="password" class="form-control form-control-lg" required />
                        <label class="form-label" for="emailAddress">Password</label>
                      </div>
    
                    </div>

                    <div class="col-md-6 mb-4 pb-2">
    
                        <div class="form-outline">
                          <input name='password_confirmation' type="password" id="password_confirmation" class="form-control form-control-lg" required />
                          <label class="form-label" for="emailAddress">Confirm password</label>
                        </div>
      
                      </div>
                  </div>
                  
    
                  <div class="mt-4 pt-2">
                    <input class="btn btn-primary btn-lg" type="submit" value="Register" />
                  </div>
                  
                  <div class='mt-4 pt-2'>
                      Already a user: <a href='login'>Login</a>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    @if ($errors->any())
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach
    @endif
@endsection