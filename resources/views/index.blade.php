@extends('layouts.mainLayout')

@section('metaTags')
    <meta name="description" content="{{ Helper::settings()->description }}">
    <meta keywords="{{ Helper::settings()->tags }}">

@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

    <header class="main-header">
        @include('partials.navbar')
        <div class="header-content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1 class="header-quot">
                            Learn <span>Quran</span> & Arabic language Online
                        </h1>
                        <p class="p-content py-4">At the Qurann Academy you will be able to learn the Quran and Arabic starting from zero or form any level. All you need is to join a group of students and start getting knowledge !</p>
                        
                        <a href="{{ route('register') }}" class="main-btn">Join & Start learning Now &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                    <div class="col-md-5">
                        <div class="header-img d-sm-block d-none">
                            <img src="{{ asset('imgs/quran-side.png') }}" class="active w-100" alt="">
                     

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f4f4f4" fill-opacity="1" d="M0,128L1440,0L1440,0L0,0Z"></path></svg>



    <div class="plans pb-5" id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="special-heading">
                        <span>Pricing</span> & Payment methods 
                    </h1>
                    <p class="p-content py-4">
                        At Quran Academy, we guarantee your satisfaction. So that your money won't go to waste.<br> We accept <strong>Paypal</strong> as a payment method. <br>
                        Join Us <a href="{{ route('register') }}">now</a>
                        
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="plan p-4">
                        <div class="special-heading"><span>
                            @if ( Helper::settings()->subscription_price )
                                {{ Helper::settings()->subscription_price }} $
                            @else
                                {{ env('SUBSCRIPTION_PRICE') }} $
                            @endif    
                        </span></div>
                        <ul class="features p-4">
                            <li>
                                <i class="fas fa-check"></i>
                                <b>6h</b> per week
                            </li>
                            <li>
                                <i class="fas fa-check"></i> 
                                Memorize the Quran
                            </li>
                            <li>
                                <i class="fas fa-check"></i> 
                                Learn through interactive lessons
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="main-btn text-center d-block">Join Now !</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section-devider">
        <div class="overlay"></div>
    </div>




    <div class="contact py-5" id="contact">
        <div class="container">
            <div class="contact-wrapper">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        

                        <div class="panel uhp" style="transform: translateY(-150px)">
                            <h1 class="special-heading py-5"><span>Contact</span> Us for more details</h1>
                            <div class="panel-body">
                                <form id="contact-form">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" placeholder="Full Name" required name="fullName" class="form-control" required> 
                                        @if ($errors->has('fullName'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="email" placeholder="Email" required name="email" class="form-control" required> 
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea placeholder="Mesasage" name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                                        @if ($errors->has('message'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit" value="Send" class="btn-block main-btn">
                                </form>
                            </div>
                            @if(Session::has('success'))
                                <div class="alert alert-success py-3">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="contact-infos py-md-4 pb-4">
                            <div class="panel">
                                <div class="box">
                                    <div class="icon">
                                        <i style="color: rgb(21, 77, 168)" class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="link">
                                        +213 x xx xx xx
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                               
                              
                            </div>
                        </div> 

                    </div> 
                </div>
            </div>
        </div>
    </div>


    @include('partials.footer')

@endsection



@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

