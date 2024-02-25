@extends('layouts.adminLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="float-left special-heading py-4">Users</div>

    <div class="py-4 float-right">
        <a href="{{ route('admin.user.create') }}" class="main-btn"><i class="fas fa-plus"></i> New user</a>
    </div>
    <table class="table products-table table-bordered table-respdonsive">
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Created Date</th>
            <th>Group</th>
            <th>Subscription Status</th>
            <th>action</th>
        </tr>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div class="avatar">
                        <img src="{{ asset('imgs/avatar-default.png') }}" alt="">
                    </div>
                </td>
                <td>{{ $user->fullName }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ Carbon\Carbon::parse($user->created_at)->isoFormat("lll") }}</td>
                <td>
                    @if ($user->group)
                        <span class="group">{{ $user->group->name }}</span>
                    @else 
                        /
                    @endif
                </td>

                <td>
                
                    @if ($user->current_subscription)
                        @if (!boolval($user->current_subscription->expired))
                            <div class="status success">Active</div>
                        @else 
                            <div class="status danger">Expired</div>
                        @endif
                    @else
                        /
                    @endif
                   
                
                     
                </td>

                <td class="edit">
                    <form action="{{ route('admin.user.delete', ['id' => $user->id ]) }}" method="POST">
                        @csrf
                        <a href="{{ route('admin.user', ["id" => $user->id]) }}" class="btn btn-info"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-danger return-confirm"> <i class="fas fa-trash"></i> </button>
                    </form>
                </td>
            </tr>
        @empty
            
        @endforelse
        
    </table>

@endsection


@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/app.js') }}"></script>
@endsection