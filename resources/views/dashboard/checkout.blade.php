@extends('layouts.mainLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/app.css') }}">

@endsection


@section('content')


    @include('dashboard.partials.upper-nav')

    <div class="bg-light py-5 checkout">
        <div class="container">
            <h1 class="py-5 special-heading text-center" style="font-size: 35px">Paye <span>{{ $price }}$</span> to Join the group <span>{{ $group->name }}</span></h1>
            
            <div class="pay-methods">
                <div class="row justify-content-center text-center">
                    <div class="col-md-8">
                        @if (!$errors->isEmpty())
                            <div class="alert alert-danger p-3">
                                @foreach ($errors->all() as $error)
                                    <div style="list-style: none">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-6">
                                <div class="method active" data-id="paywith-card">
                                    <div class="img">
                                        <img src="{{ asset('imgs/visa-master-card.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="method" data-id="paywith-paypal">
                                    <div class="img">
                                        <img src="{{ asset('imgs/paypal.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <form action="{{ route('checkout.card', [ 'id' => $group->id ]) }}" method="POST" class="mt-4 active" id="paywith-card">
                        @csrf
                        <input type="hidden" name="payment_method" id="payment_method">

                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input id="fullName" type="text" name="fullName" value="{{ auth()->user()->fullName }}" class="form-control" placeholder="Your full Name">
                        </div>

                        <label for="">Card infos</label>
                        <div id="card-element"></div>

                        <div class="my-3">
                            <div class="mb-4">
                                <div class="py-2">
                                    <b>Subscription starts on : </b> {{ Carbon\Carbon::parse($start)->isoFormat("LLL") }} <br>
                                </div>
                                <b>Subscription ends on : </b> {{ Carbon\Carbon::parse($start)->addMonth()->isoFormat("LLL") }}
                            </div>

                            <button id="submit-btn" type="submit" class="main-btn btn-block btn" style="font-size: 20px">
                                Paye {{ $price }}$
                            </button>   
                        </div>

                    </form>

                    <form action="{{ route("checkout.paypal", [ 'id' => $group->id ]) }}" method="POST" class="mt-4" id="paywith-paypal">
                        @csrf
                        
                        <button type="submit" class="main-btn d-block m-auto">PayPal Paye {{ $price }}$</button>

                    </form>
 
                </div>
            </div>
        </div>
    </div>
    

   


@endsection



@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/app.js') }}"></script>


    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    
        const elements = stripe.elements();
        const cardElement = elements.create('card');
    
        cardElement.mount('#card-element');
        $('#card-element').css({
            'border': "1px solid #ccc",
            "padding": "1.3rem 10px",
            "border-radius": "10px"
        })

        const cardButton = document.getElementById('submit-btn');

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement
            );

            if (error) {
                alert("Something went wrong! Please try again")
            } else {
                document.getElementById('payment_method').value = paymentMethod.id;
                document.getElementById('paywith-card').submit();
            }
        });


   
    </script>


@endsection