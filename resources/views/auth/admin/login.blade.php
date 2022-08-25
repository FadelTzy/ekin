@extends('layouts.app')

@section('content')
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="index.html" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('img/01ekinerja.jpg')}}" alt="" height="80">
                                    </span>
                                </a>
                            </div>
                            <h3 class="mt-3">ADMIN LOGIN</h3>
                            <p class="mb-3 ">Masukkan Username & Password</p>

                        </div>
                        @if(Session::get('error'))
                        <div class="alert alert-danger fade show" role="alert">
                            {{Session::get('error')}}
                        </div>
                        @endif
                        @if(Session::get('warning'))
                        <div class="alert alert-warning fade show" role="alert">
                            {{Session::get('warning')}}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('admin.proses') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="usernameaddress">Username</label>
                                <input class="form-control @error('username') is-invalid @enderror" type="text" id="usernameaddress" required="" placeholder="Input Username" name="username" value="{{ old('username') }}" autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Input Password" name="password" required autocomplete="current-password">

                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>



                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Masuk </button>
                            </div>

                        </form>


                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
@endsection