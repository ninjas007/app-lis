@extends('auth.template')

@section('styles')
<style>
    .login-form-bg {
        background-image: url('{{ asset('images/background.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
</style>
@endsection

@section('content')
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-5">
                    <div class="form-input-content">
                        <div class="card login-form mb-0" style="opacity: 0.85">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ asset('images/gambar-login.png') }}" alt="" style="width: 100px; height: 100px; background-size: contain; border-radius: 20px">
                                    <br>
                                    <br>
                                    <h4>Login</h4>
                                </div>
                                <form class="mt-2 mb-3 login-input" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control" name="username" placeholder="Username" style="border-bottom: 0.5px solid #a2a2a2">

                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password" style="border-bottom: 0.5px solid #a2a2a2">

                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100">
                                       <i class="fa fa-sign-in"></i> Sign In
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
