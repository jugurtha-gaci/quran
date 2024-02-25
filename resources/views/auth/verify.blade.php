@extends('layouts.mainLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
        
    @include('partials.navbar')

    <div class="container">

        <div class="text-center py-5">
            <div class="special-heading">Please verify your email</div>
            <p class="p-content pt-5">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }} 
                
                <form class="" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    {{ __('If you did not receive the email') }},
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </p>
        </div>

    </div>



    @include('partials.footer')

@endsection



@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
























