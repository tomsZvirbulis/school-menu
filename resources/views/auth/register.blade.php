@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/userAuth.css') }}">
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
              <form method='POST' action='/register'>
                @csrf
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
  
                <div class="row">
                  <div class="col-12">
  
                    <select name='company_type' class="select form-control-lg" required>
                      <option value="1">School</option>
                      <option value="2">Caterer</option>
                    </select>

                    <div class="form-outline mt-4">
                        <input name='company_id' type="number" id="company_id" class="form-control form-control-lg" required />
                        <label class="form-label" for="id">Company ID</label>
                      </div>
  
                  </div>
                </div>
                
  
                <div class="mt-4 pt-2">
                  <input class="btn btn-primary btn-lg" type="submit" value="Register" />
                </div>
                
                <div class='mt-4 pt-2'>
                    <a href='login'>
                        Login
                    </a>
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