@section('title','Sign Up')
<x-header />

@php
    function displayErrorMessage($field, $message){
        echo '<div class="alert alert-danger text-danger w-100">'.$message.'</div>';
    }
@endphp

<div class="container">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="card m-auto w-100">
                <div class="card-header bg-dark text-center text-white">
                    Sign Up
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('signup') }}">
                        @csrf
                        <label for="" class="m-1">Enter name</label>
                        <input type="text" class="form-control mb-3" placeholder="Enter Name" name="name">
                        @error('name')
                            {{ displayErrorMessage('name',$message) }}
                        @enderror
                        <label for="" class="m-1">Enter email</label>
                        <input type="email" class="form-control mb-3" placeholder="Enter Email" name="email">
                        @error('email')
                            {{ displayErrorMessage('email',$message) }}
                        @enderror
                        <label for="" class="m-1">Enter Password</label>
                        <input type="password" class="form-control mb-3" placeholder="Enter password" name="pass1">
                        @error('pass1')
                            {{ displayErrorMessage('pass1',$message) }}
                        @enderror
                        <label for="" class="m-1">Re-enter Password</label>
                        <input type="password" class="form-control mb-3" placeholder="Re-enter password" name="pass2">
                        @error('pass2')
                            {{ displayErrorMessage('pass2',$message) }}
                        @enderror
                        <div>
                            <button class="btn btn-md btn-primary w-100" type="submit">Sign Up</button>
                        </div>    
                    </form>
                </div>
                <div class="card-footer">
                    Already have an account? <a href="{{ route('loginView') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer />
