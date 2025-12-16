@section('title','Login')

@php
    function displayErrorMessage($field, $message){
        echo '<div class="alert alert-danger text-danger w-100">'.$message.'</div>';
    }
@endphp

<x-header />
<div class="container">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            @session('error')
                <div class="alert alert-danger text-danger w-100 mt-2">{{ session('error') }}</div>
            @endsession
            <div class="card m-auto w-100">
                <div class="card-header bg-dark text-center text-white">
                    Login
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <label for="" class="m-1">Enter email</label>
                        <input type="email" class="form-control mb-3" placeholder="Enter Email" name="email">
                        @error('email')
                            {{ displayErrorMessage('email',$message) }}
                        @enderror
                        <label for="" class="m-1">Enter password</label>
                        <input type="password" class="form-control mb-3" placeholder="Enter password" name="password">
                        @error('password')
                            {{ displayErrorMessage('password',$message) }}
                        @enderror
                        <div>
                            <button class="btn btn-md btn-primary w-100" type="submit">Login</button>
                        </div>    
                    </form>
                </div>
                <div class="card-footer">
                    Don't have an account? <a href="{{ route('signupView') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
<x-footer />