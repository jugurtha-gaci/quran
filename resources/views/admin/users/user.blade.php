@extends('layouts.adminLayout')



@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="special-heading py-4">Edit {{ $user->fullName }}</div>

    @if (!$errors->isEmpty())
        <div class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <div style="list-style: none">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.user.update', ["id" => $user->id]) }}" method="POST">

        @csrf

        <div class="form-group">
            <label for="full-name">Full Name :</label>
            <input name="fullName" type="text" value="{{ $user->fullName }}" placeholder="Full Name" class="form-control customized">
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input id="email" name="email" type="text" value="{{ $user->email }}" placeholder="Email" class="form-control customized">
        </div>

        <div class="form-group">
            <label for="group">Group :</label>

            <select name="group" class="form-control" name="group" id="group">
                <option value="0">...</option>
                @foreach ($groups as $group)
                    <option {{ ($user->group_id && $user->group_id == $group->id) ? "selected" : "" }} value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <input type="submit" value="Save" class="main-btn">
    </form>

@endsection


@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/app.js') }}"></script>
@endsection