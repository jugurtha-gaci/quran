@extends('layouts.adminLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="special-heading py-4">Subscriptions</div>

    @if (!$errors->isEmpty())
        <div class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <div style="list-style: none">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    

    <table class="table products-table table-bordered table-respdonsive">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Paiment Method</th>
            <th>Amount payed</th>
            <th>Status</th>
            <th>action</th>
        </tr>
        
        @forelse ($subscriptions as $subscription)
          
            <tr @if ($subscription->expired)
                    style="background: #ffe7e7;"
                @endif>

                <td>{{ $subscription->id }}</td>
                <td>{{ $subscription->user->fullName }}</td>
                <td>{{ \Carbon\Carbon::parse($subscription->start_day)->isoFormat('ll') }}</td>
                <td>{{ \Carbon\Carbon::parse($subscription->end_day)->isoFormat('ll') }}</td>
                <td>{{ Str::ucfirst($subscription->payment_method) }}</td>
                <td>{{ $subscription->amount }}$</td>
                <td>
                    @if (!boolval($subscription->expired))
                        <span class="status success">Active</span>
                    @else
                        <span class="status danger">Expired</span>
                    @endif
                </td>

                <td class="edit">
            
                    @if (!boolval($subscription->expired))
                        <form class="form-inline" action="{{ route('admin.subscription.disable', ['id' => $subscription->id ]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger return-confirm"> Disbale </button>
                        </form>
                    @else
                        <form class="form-inline" action="{{ route('admin.subscription.renew', ['id' => $subscription->user->id ]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success return-confirm"> Renew </button>
                        </form>
                    @endif
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