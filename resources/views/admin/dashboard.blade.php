@extends('layouts.adminLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="special-heading py-4" >Dashboard <span>Summary</span> :</div>

    <div class="stats pb-5">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="stat-box bg-clr-1">
                    <div class="row">
                        <div class="col-4 text-center">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="col-8">
                            <div class="value">
                                @php
                                    $val = 0;
                                    foreach ($subscriptions as $sub) {
                                        if(Carbon\Carbon::parse($sub->start_day)->isCurrentMonth()) {
                                            $val += $sub->amount;
                                        }
                                    } 
                                    echo $val;
                                @endphp $
                                
                            </div>
                            <div class="txt">This Month Income</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="stat-box bg-clr-3">
                    <div class="row">
                        <div class="col-4 text-center">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="col-8">
                            <div class="value">{{ count($subscriptions->where('expired', 0)) }}</div>
                            <div class="txt">Active subscribers</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="stat-box bg-clr-4">
                    <div class="row">
                        <div class="col-4 text-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="col-8">
                            <div class="value">{{ count($users) }}</div>
                            <div class="txt">Total Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="today-workingTime">
        <div class="special-heading py-3">Today program :</div>
        <table class="table table-bordered">
            <tr>
                <th>Group</th>
                <th>Start Time</th>
                <th>End time</th>
                <th>action</th>
            </tr>
            @php
                $i = 0;
            @endphp
            @forelse ($days as $day)
                @if (\Carbon\Carbon::now()->englishDayOfWeek == $day->day)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td class="group ml-3 mt-2">{{ $day->group->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($day->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($day->end_time)->format('H:i') }}</td>
                        <td>
                            @if ( strtotime($day->start_time) - strtotime(date("H:i:s")) <= 0)  
                            {{-- @if ( strtotime($day->start_time) - strtotime(date("H:i:s")) <= 0 && strtotime($day->end_time) - strtotime(date("H:i:s")) > 0)   --}}
                                @if(Helper::lastStream($day->group->id) && \Carbon\Carbon::parse(Helper::lastStream($day->group->id)->created_at)->format("Y-m-d") == date("Y-m-d"))
                                    @if(boolval(Helper::lastStream($day->group->id)->deprecated))
                                        <strong style="color: rgb(56, 170, 170)">Video Deprecated</strong>
                                    @else
                                        <strong style="color: rgb(23, 146, 105)"> <i class="fas fa-check"></i> Today's session is done. </strong>                
                                    @endif
                                @else 
                                    @if(Helper::streamInProgress($day->group->id))
                                        <form method="POST" action="{{ route('streaming.deprecate', ['stream_id' => Helper::streamInProgress($day->group->id)->id]) }}">
                                            @csrf

                                            <button type="submit" style="background:none; border:none; font-weight:bold; color:rgb(138, 7, 7); text-decoration:underline">Deprecate video</button>
                                        </form>
                                        
                                    @else
                                        @if (strtotime($day->end_time) - strtotime(date("H:i:s")) <= 0)
                                            <span class="status danger">Too late</span> &nbsp;
                                        @else 
                                        {{-- @if(strtotime($day->start_time) - strtotime(date("H:i:s")) <= 0) --}}
                                            <form method="POST" action="{{ route('start-streaming', ['id' => $day->group->id]) }}">
                                                @csrf

                                                <button type="submit" class="btn btn-success">Start video</button>
                                            </form>
                                        @endif
                                        
                                    @endif
                                        
                                @endif
                            @else                                
                                Wait until {{ \Carbon\Carbon::parse($day->start_time)->format('H:i') }}..
                            @endif
                        </td>
                    </tr>
                @endif
  
            @empty
                <tr>
                    <td colspan="4">/</td>
                </tr>
            @endforelse
            @if ($i == 0)
                <tr>
                    <td class="text-center" colspan="4">/</td>
                </tr>
            @endif

        </table>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/app.js') }}"></script>

@endsection