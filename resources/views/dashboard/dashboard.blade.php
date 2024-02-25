@extends('layouts.dashboardLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/app.css') }}">
@endsection


@section('content')

    <div class="bg-light">

        <div class="py-5">
            <h1 class="text-center special-heading"><i style="color: rgb(228, 186, 51)" class="fas fa-sign-language"></i> Welcome <span>{{ auth()->user()->fullName }}</span></h1>

            @if (
                    \App\Models\Subscription::where('user_id', auth()->user()->id)->where('expired', 0)->count() > 0 
                    || auth()->user()->admin
                )
                <div id="wait" class="text-center m-auto">
                    <div class="lds-facebook"><div></div><div></div><div></div></div>
                </div>

                @if($today_session)
                    @if ($stream)

                        <div class="text-center pt-3">
                            <button type="button" id="leave" class="btn btn-danger d-none">Leave session</button>
                        </div>
                         
                        <div class="row py-3">
                            <div class="col-md-8">
                                <div class="stream-video">
                            
                                    <div class="text-center mb-3">
                                        <div id="video">
                                            <video style="height: 335px" class="w-100" controls></video>
                                            <button class="main-btn" id="audience-join">Join live</button>       

                                        </div>
                                        
                                        

                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="conversation" id="conversation" style="background: #fff">

                                    <div class="conversation-header">
                                        Chat conversation ({{ $groupCountMembers }} users)
                                    </div>


                                    <div class="messages messages--received pt-2">
                                        <div class="username">Teacher</div>
                                        <div class="message">Enjoy!</div>
                                    </div>
                                    @foreach ($messages as $msg)

                                        @if ($msg->message->user_id != auth()->user()->id)
                                            <div class="messages messages--received">
                                                <div class="username">{{ $msg->message->user->fullName }}</div>
                                                <div class="message">{{ $msg->message->message }}</div>
                                            </div>
                                        @else 
                                            <div class="messages messages--sent">
                                                <div class="message">{{ $msg->message->message }}</div>
                                            </div>
                                        @endif
                                        

                                    @endforeach
                                </div>
                                <div class="text-bar">
                                    <form>
                                        <div class="text-bar__field" id="form-message">
                                            <input required type="text" placeholder="Type a message.."/>

                                        </div>
                                        <div class="pt-2 text-center" style="background: #fff; height: inherit">
                                            <button class="send" type="submit">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </form>
                                    
                                </div>

                            </div>
                        </div>
                        

                    @else 
                        @php
                            session()->forget('live_id');
                        @endphp
                        
                        <div class="text-center py-5">

                            @if($lastStream && \Carbon\Carbon::parse($lastStream->created_at)->format("Y-m-d") == date("Y-m-d"))

                                @if($lastStream->deprecated) 
                                    <h1 style="font-size: 20px; color: rgb(109, 39, 35)" class="special-heading">
                                        Today's session is unfortunately deprecated for many reasons.
                                    </h1>
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 alert alert-warning py-3">
                                            <strong>This session will be remboursed. Check the table of studying times please</strong>
                                        </div>
                                    </div>
                                @else
                                    <h1 style="font-size: 20px; color: rgb(23, 146, 105)" class="special-heading">
                                        <i class="fas fa-check"></i> Today's session is done.
                                    </h1>
                                    <h2 style="font-size: 20px" class="special-heading">
                                        Next Session will be on {{ \Carbon\Carbon::parse($nextSession)->isoFormat("LL") }}
                                    </h2>

                                @endif

                                    
                            @else
                                @if(strtotime($today_end_time) - strtotime(date("H:i:s")) >= 0)
                                    <h1 style="font-size: 20px" class="special-heading">
                                        Today's session will start at {{ \Carbon\Carbon::parse($today_start_time)->format('H:i') }}, and end at {{ \Carbon\Carbon::parse($today_end_time)->format('H:i') }}
                                    </h1>  
                                @else
                                    @if (strtotime($today_end_time) - strtotime(date("H:i:s")) <= 0)
                                        <h1 style="font-size: 20px;color: rgb(160, 33, 61)" class="special-heading">
                                            Today's session is unfortunately not done. We are sorry :(
                                        </h1>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 alert alert-warning py-3">
                                                <strong>This session will be remboursed. Check the table of studying times please</strong>
                                            </div>
                                        </div>
                                                                                
                                    @endif 
                                    
                                @endif
                                
                            @endif

                            
                            You can see your studying times <a href="{{ route('dashboard.classroom') }}#studying-times">here</a>

                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center img">
                                <img class="w-100" src="{{ asset('imgs/learning.svg') }}" alt="">
                            </div>
                        </div>
                    @endif
                @else 
                    <div class="text-center py-5">
                        @if($nextSession)
                            <h1 style="font-size: 20px" class="special-heading">
                                Next session will be on {{ \Carbon\Carbon::parse($nextSession)->isoFormat("LL") }}
                            </h1>
                            You can see your studying times <a href="{{ route('dashboard.classroom') }}#studying-times">here</a>

                        @else
                            This group haven't yet studying times
                        @endif
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center img">
                            <img class="w-100" src="{{ asset('imgs/learning.svg') }}" alt="">
                        </div>
                    </div>
                    
                @endif


                 
            @else
                <div class="py-5 my-5 item-shadowed" style="border-radius: 30px">
                    <h1 class="special-heading text-center">Sorry, your subscription was ended.</h1>
                    <p class="p-content text-center">Please <a href="{{ route("renew-subscription") }}">re-new it now</a> </p>
                </div>
            @endif



        </div>

    </div>
@endsection



@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script>
        document.querySelector('.conversation').scrollTop = document.querySelector('.conversation').scrollHeight;
    </script>
    @if ($stream)
        <script>

            let options = {
                // Pass your app ID here.
                appId: "0ec8c79b7d384bdf834b597a8c130267",
                // Set the channel name.
                channel: "{{ $stream->channel }}",
                // Use a temp token
                token: '{{ $stream->token }}',
                // Uid
                uid: 0
            };
        </script>
    @else
        <script>let options = {};</script>
    @endif
    

    <script src="{{ asset('js/app.js') }}"></script>
   
    @if(!$stream)
        <script>

            var interval = setInterval(() => {
                @if ( strtotime($today_start_time) - strtotime(date("H:i:s")) <= 0 && strtotime($today_end_time) - strtotime(date("H:i:s")) > 0)  
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('dashboard.check-started-video') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                            if(data > 0) {
                                window.location.reload();
                                
                            }
                        }

                    })
                @endif
            }, 1000);


            
        </script>
    @else 

        <script>
            var lastResult = [{id: -1}],
                messageBox = document.getElementById('conversation');

            var interval = setInterval(() => {
                

                $.ajax({
                    url: "{{ route('messages.get') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(result) {

                        // console.log(result)

                        
                        if(Object.keys(result).length > 0) {
                            Object.entries(result).forEach((res) => {


                                const [key, val] = res;

                                var div = document.createElement('div'),
                                    username = document.createElement('div'), 
                                    comment = document.createElement('div');

                                if(val.id == "{{ auth()->user()->id }}") {
                                    div.setAttribute('class', "messages messages--sent");

                                } else {
                                    div.setAttribute('class', "messages messages--received");
                                    username.setAttribute('class', "username");
                                    username.innerHTML = val.fullName;
                                    div.appendChild(username);

                                }

                                comment.setAttribute('class', "message");
                                comment.innerHTML = val.message;

                                
            
                                div.appendChild(comment);
                                messageBox.appendChild(div);

                                document.querySelector('.conversation').scrollTop = document.querySelector('.conversation').scrollHeight;
                            });
                           

                        }
                        
                    }
                });

                $.ajax({
                    method: 'POST',
                    url: "{{ route('dashboard.check-deprecated-video') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(data) {
                        if(data > 0) {
                            window.location.reload();
                            
                        }
                    }
                })

            }, 1000);
            

        </script>
    @endif


    

    
    
    
@endsection