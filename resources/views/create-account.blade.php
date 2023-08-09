@extends('layouts.app')

@section('content')

<section class="homeloginpage full-page-container py-5">
  <div class="container">
   <div class="row g-0">






      <div class="col-lg-6 text-center d-flex align-items-center justify-content-center">
        
          <div class="d-flex flex-column gap-4 align-items-center justify-content-center">
            <div class="logos"><img  src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" width="350px"></div>
            <div><h6 class="fw-bold">Cavite States University - Carmona</h6><h2 class="fw-bold text-uppercase">Extension Service Office</h2></div>
          </div> 
      </div>



      <div class="col-lg-6">
        <h1 class="text-center p-5">Register</h1>

    <form>
        <div class="container p-3">
            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Username1">Username:</label>
                  <input type="user1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Firstname1">First Name:</label>
                  <input type="first1" class="form-control" aria-describedby="usernameHelp" placeholder="Username">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Middelname1">Middle Name:</label>
                  <input type="middle1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Lastname1">Last Name:</label>
                  <input type="last1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Emailaddress1">Email Address:</label>
                  <input type="email1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="Password1">Password:</label>
                  <input type="pass1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="offset-1 col-lg-10">
                  <label class="bold-label fw-bold py-3" for="ConfirmPassword1">Confirm Password:</label>
                  <input type="confirmpass1" class="form-control " aria-describedby="passwordHelp" placeholder="Password">
                </div>
            </div>
        </div>

        <div class="container p-3 btn-block">
            <div class="form-group text-center">
                <div class="offset-1 col-lg-10">
                  <button type="register" class="btn btn-success">Register</button>
                </div>
            </div>
        </div>
        
    </form>





      </div>
    </div>
  </div>
</section>



@endsection