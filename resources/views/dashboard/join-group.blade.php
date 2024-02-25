@extends('layouts.mainLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/app.css') }}">
@endsection


@section('content')


    @include('dashboard.partials.upper-nav')
    <style>
        table tr:first-child {
            background: rgb(68, 114, 170);
        }
        table tr th, table tr td {
            padding: 17px 10px !important
        }
    </style>
    <div class="bg-light join-group">
        <div class="client-path py-4">
            <div class="container">
                <a href="{{ route('home') }}">Dashboard</a> / <a href="">Join the group <b>{{ $group->name }}</b></a>
            </div>
        </div>
        <div class="container py-5">

            @if (!$errors->isEmpty())
                <div class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <div style="list-style: none">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h1 class="special-heading" style="font-size: 35px;">Join group <span>{{ $group->name }}</span> with only <span>{{ $price }}$</span><span style="font-size: 13px">/mo</span></h1>
                    <p class="p-content py-4">
                        First step to start learning at <strong>Quran Academy</strong> is to select a group and subscribe to it. <br> Subscription is only with <span>{{ $price }}$</span><span style="font-size: 13px">/mo</span>
                    </p>
                    <h4 class="special-heading">Modules :</h4>
                    <ul class="modules">
                        <li><i class="fas fa-check"></i> Memorize Quran</li>
                        <li><i class="fas fa-check"></i> Women's fatwas</li>
                        <li><i class="fas fa-check"></i> Tajweed Al Quran</li>
                        <li><i class="fas fa-check"></i> Tafsir Al Quran</li>

                    </ul>
                </div>
                <div class="col-md-6">
        
                    <h1 class="special-heading">Studying Time</h1>


                    <table class="table table-bordered my-4">
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>
                        @foreach ($group->days as $day) 
                            <tr>
                                <td>{{ $day->day }}</td>
                                <td>
                                    <?php
                                        $start = strtotime($day->start_time);
                                        echo date('H:i', $start).' - ';
                                        $end = strtotime($day->end_time);
                                        echo date('H:i', $end);
                                    ?>
                                    &nbsp; &nbsp; GMT+1
                                </td>
                                
                            </tr>
                        @endforeach
                    </table>

                    <div class="mb-4">
                        <div class="py-2">
                            <b>Subscription starts on : </b> {{ \Helper::nextGroupSession($group->id)->isoFormat("LL") }} <br>
                        </div>
                        <b>Subscription ends on : </b> {{ \Helper::nextGroupSession($group->id)->addMonth()->isoFormat("LL") }}
                    </div>

                    
                    <form action="{{ route("checkout.paypal", [ 'id' => $group->id ]) }}" method="POST" class="mt-4" id="paywith-paypal">
                        @csrf
                       
                        <button type="submit" style="background: none; border: none" class="d-block m-auto w-100">
                            <img style="height: 200px; width: 80%" src="{{ asset('imgs/paypal-btn.png') }}" alt="">
                        </button>

                    </form>

                    
                </div>
            </div>

        
        </div>
        

    </div>

   


@endsection



@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection





