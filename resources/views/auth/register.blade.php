@extends('layouts.app')

@section('content')

            
           

            <section class="reg-page full-page-container py-5">
                <div class="container">
                    <div class="row g-0 border">
                        <div class="col-lg-6 text-center d-flex align-items-center justify-content-center">
                            <div class="d-flex flex-column gap-4 align-items-center justify-content-center">
                                <div class="logos"><img  src="{{ asset('images/Picture1.png')}}" alt="Extension Service Office" width="350px"></div>
                                <div><h6 class="fw-bold">Cavite States University - Carmona</h6><h2 class="fw-bold text-uppercase">Extension Service Office</h2></div>
                            </div> 
                        </div>



                        <div class="col-lg-6">
                                <h1 class="text-center p-5">Registration!</h1>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="container p-3">
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="Username1">Username:</label>
                                                <input placeholder="Username" id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus >
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="firstname1">First Name:</label>
                                                <input placeholder="First Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="middlename1">Middle Name:</label>
                                                <input placeholder="Middle Name" id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" required autocomplete="name" autofocus>
                                                @error('middle_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="lastname1">Last Name:</label>
                                                <input placeholder="Last Name" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="lastname1">Email Address:</label>
                                                <input placeholder="Email Address" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="password1">Password:</label>  
                                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                            
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="password1">Confirm Password:</label>
                                                <input placeholder= "Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                            

                            
                                        
                                
                                        <div class="form-group">
                                            <div class="offset-1 col-lg-10">
                                                <label class="bold-label fw-bold py-2" for="password1">Department Selection:</label>
                                                <select name="department" id="department" class="form-select @error('department') is-invalid @enderror" value="{{ old('department') }}" required autocomplete="department" autofocus>
                                                    <option value="" disabled selected>Select your Department</option>
                                                    <option value="Department of Management">Department of Management</option>
                                                    <option value="Department of Industrial and Information Technology">Department of Industrial and Information Technology</option>
                                                    <option value="Department of Teacher Education">Department of Teacher Education</option>
                                                    <option value="Department of Arts and Science">Department of Arts and Science</option>
                                                </select>
                                                @error('department')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>    
                                        
                                        <div class="container p-3">
                                            <div class="form-group text-center">
                                                <div class="offset-1 col-lg-10">
                                                    <button type="submit" class="btn btn-success">
                                                        {{ __('Register') }}
                                                    </button>
                                                </div>
                                            </div>  
                                        </div>




                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </section>
@endsection