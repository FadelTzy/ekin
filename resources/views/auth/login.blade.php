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
                            <p class="mb-3 mt-3">Masukkan NIP & Password</p>

                        </div>
                        @if(Session::get('danger'))
                        <div class="alert alert-danger fade show" role="alert">
                            {{Session::get('danger')}}
                        </div>
                        @endif
                        @if(Session::get('warning'))
                        <div class="alert alert-warning fade show" role="alert">
                            {{Session::get('warning')}}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nipaddress">NIP</label>
                                <input class="form-control @error('nip') is-invalid @enderror" type="text" id="nipaddress" required="" placeholder="Enter your NIP" name="nip" value="{{ old('nip') }}" autocomplete="nip" autofocus>

                                @error('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" required autocomplete="current-password">

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