@extends('layouts.app')

@section('content')

<section class="homeloginpage py-5 bg-light">
  <div class="container">
    <div class="row g-0">

      <div class="col-lg-5 text-center">
        <img src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" class="img-fluid logo">
        <h1 class="title">Extension Service Office</h1>
        <h1 class="title">of</h1>
        <h1 class="title">Cavite State University Carmona</h1>
      </div>

      <div class="col-lg-7 text-center py-5">
        <h1>Welcome!</h1>
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