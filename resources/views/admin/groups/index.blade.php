@extends('layouts.adminLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="float-left special-heading py-4">Groups</div>
    
    <div class="py-4 float-right">
        <a href="#" data-show="new-group" class="main-btn show-popup"><i class="fas fa-plus"></i> New group</a>
    </div>
    
    @if (!$errors->isEmpty())
        <div class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <div style="list-style: none">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="popup-bg"></div>

    <div id="new-group" class="popup">
        <div class="close">x</div>
        <form action="{{ route('admin.group.store') }}" method="POST"> 
            @csrf
            <h1 class="special-heading pt-2 pb-4">Create new group</h1>
            <div class="form-group">
                <label for="max_members">Max members</label>
                <input type="number" name="max_members" id="max_members" class="form-control customized" placeholder="Max members">
            </div>
            <input type="submit" value="Create" class="main-btn">
        </form>
    </div>

    <table class="table products-table table-bordered table-respdonsive">
        <tr>
            <th>Group Name</th>
            <th>Total involved members</th>
            <th>Max members</th>
            <th>Created Date</th>
            <th>action</th>
        </tr>
        @forelse ($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>{{ count(\App\Models\User::where('group_id', $group->id)->get()) }}</td>
                
                <td>{{ $group->max_members }}</td>

                <td>{{ \Carbon\Carbon::parse($group->created_at)->isoFormat('ll') }}</td>

                <td class="edit">
                    <form action="{{ route('admin.group.delete', ['id' => $group->id ]) }}" method="POST">
                        @csrf
                        <a href="{{ route('admin.group', ["id" => $group->id]) }}" class="btn btn-info"><i class="fas fa-pen"></i></a>
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