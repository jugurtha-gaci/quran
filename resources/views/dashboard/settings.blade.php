@extends('layouts.dashboardLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/app.css') }}">
@endsection


@section('content')

    <div class="bg-light">

        <div class="py-5">
            
            
            @if (!$errors->isEmpty())
                <div class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            @if (session('status'))
                <div class="alert alert-success p-3">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-4">
                    <h1 class="special-heading">Edit Profile <span>Settings</span></h1>
                    <form action="{{ route('dashboard.settings.update') }}" method="POST">

                        @csrf
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" name="fullName" placeholder="Full Name" value="{{ $profile->fullName }}" class="form-control customized">
                        </div>
                      
                        <div class="form-group">
                            <label for="group">Group : </label>
                            <select name="group" id="group" class="form-control">
                                <option value="{{ $profile->group->id }}">{{ $profile->group->name }}</option>
                                @foreach ($available_groups as $group)
                                    @if ($group->id == $profile->group->id)
                                        @php
                                            continue;
                                        @endphp
                                    @else
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>                        
                                    @endif                            
                                @endforeach
                            </select>
                        </div>
        
                        <button type="submit" class="main-btn">
                            Save
                        </button>
                    </form>
                </div>

                <div class="col-md-6 item-shadowed">
                    <h1 class="special-heading">Change <span>Password</span></h1>
                    <form action="{{ route('dashboard.settings.update-password') }}" method="POST">

                        @csrf
                        <div class="form-group">
                            <label for="fullName">Current Password</label>
                            <input type="password" name="curr_pass" placeholder="Current Password" class="form-control customized">
                        </div>
                      
                        <div class="form-group">
                            <label for="fullName">New Password</label>
                            <input type="password" name="password" placeholder="New Password" class="form-control customized">
                        </div>
        
                        <div class="form-group">
                            <label for="fullName">Confirm New Password</label>
                            <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="form-control customized">
                        </div>

                        <button type="submit" class="main-btn">
                            Save
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