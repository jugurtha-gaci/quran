@extends('layouts.dashboardLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/app.css') }}">
@endsection


@section('content')

    <div class="bg-light">

        <div class="py-5">

            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-center special-heading pb-3">Group members</h1>
                    <table class="table table-bordered">
                        <tr>
                            <th>Full Name</th>
                            <th>Joined Date</th>
        
                        </tr>
                        @forelse ($classroom as $user)
                            <tr>
                                <td> {{ $user->fullName }} </td>
                                <td> {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('ll') }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">/</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <div class="col-md-5" id="studying-times">
                    <h1 class="text-center special-heading pb-3">Studying times</h1>
                    <table class="table table-bordered">
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>
                        @forelse ($days as $day)
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
                        @empty
                            <tr>
                                <td class="text-center" colspan="2">/</td>
                            </tr>
                        @endforelse
                    </table>
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