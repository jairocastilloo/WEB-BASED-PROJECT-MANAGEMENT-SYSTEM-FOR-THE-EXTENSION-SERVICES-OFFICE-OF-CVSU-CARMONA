@extends('layouts.app')

@section('content')

<section class="homeloginpage full-page-container py-5">
  <div class="container">
    <div class="row g-0">






      <div class="col-lg-5 text-center">
        <div class="outer-picture">
          <img src="{{ asset('images/bg-cvsu.png')}}" alt="Extension Service Office" class="img-fluid logo">
            <div class="column-wrapper">
                <img src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" class="img-fluid logo">
            </div>
        </div>
      </div>





      <div class="col-lg-7 text-center py-5">
        <h1>WELCOME!</h1>
        <form>
            <div class="form-row">
                <div class="offset-1 col-lg-10 py-3 pt-5">
                    <input class="inputbox" type="text" placeholder="Username">
                </div>
            </div>
            <div class="form-row">
                <div class="offset-1 col-lg-10">
                    <input class="inputbox" type="password" placeholder="Password">
                </div>
            </div>
            <div class="form-row">
                <div class="offset-1 col-lg-10 py-3 pt-5">
                    <button class="allhomebtn">Login</button>
                </div>
            </div>
            <div class="form-row">
                <div class="offset-1 col-lg-10">
                    <button class="allhomebtn">Register</button>
                </div>
            </div>
        </form>

      </div>
    </div>
  </div>
</section>



@endsection