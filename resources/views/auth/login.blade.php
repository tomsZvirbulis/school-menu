@extends('layouts.main')

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
              <form method='POST' action='/login'>
                @csrf
                <div class="row">
                  <div class="col-md-12 mb-4 pb-2">
  
                    <div class="form-outline">
                      <input name='email' type="email" id="emailAddress" class="form-control form-control-lg" required />
                      <label class="form-label" for="emailAddress">Email</label>
                    </div>
  
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4 pb-2">
    
                      <div class="form-outline">
                        <input name='password' type="password" id="password" class="form-control form-control-lg" required />
                        <label class="form-label" for="emailAddress">Password</label>
                      </div>
    
                    </div>
                </div>         
  
                <div class="mt-4 pt-2">
                  <input class="btn btn-primary btn-lg" type="submit" value="Login" />
                </div>

                <div class='mt-4 pt-2'>
                    <a href='register'>
                        Register
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