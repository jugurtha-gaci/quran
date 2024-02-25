@extends('layouts.mainLayout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection


@section('content')

    @include('partials.navbar')
    
    <div class="container py-5 mb-5">
        <h1 class="text-center py-5 special-heading">{{ __('Reset Password') }}</h1>
        
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" placeholder="E-Mail Address" class="form-control customized @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>



    @include('partials.footer')
    

@endsection




@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

















































@section('content')

@endsection
