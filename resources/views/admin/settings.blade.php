@extends('layouts.adminLayout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
@endsection

@section('content')
    <div class="special-heading py-4">Settings</div>
    @if (!$errors->isEmpty())
        <div class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <div style="list-style: none">{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form action="{{ route('admin.settings.edit') }}" class="pb-5" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="fb">Facebook page link</label>    
                    <input value="{{ $settings->facebook }}" type="url" name="facebook" id="fb" class="form-control" placeholder="Facebook page url">
                </div> 
                <div class="form-group">
                    <label for="insta">Instagram page link</label>    
                    <input value="{{ $settings->instagram }}" type="url" name="instagram" id="insta" class="form-control" placeholder="Instagram page url">
                </div>  
                <div class="form-group">
                    <label for="ytb">Youtube channel link</label>    
                    <input value="{{ $settings->youtube }}" type="url" name="youtube" id="ytb" class="form-control" placeholder="Youtube channel url">
                </div>    
                <div class="form-group">
                    <label for="price">Subscription Price ($)</label>    
                    <input value="{{ $settings->subscription_price }}" type="number" name="price" id="price" class="form-control" placeholder="Subscription price">
                </div>   
                <div class="form-group">
                    <label for="description">Website description</label>  
                    <textarea name="description" id="description" cols="10" rows="10" class="form-control" placeholder="Website Description">{{ $settings->description }}</textarea>   
                </div>  
                <div class="form-group">
                    <label for="tags">Website Tags</label>   
                    <textarea name="tags" id="tags" cols="10" rows="10" class="form-control" placeholder="Website Tags">{{ $settings->tags }}</textarea> 
                </div>   
            </div>
            

            <div class="col-md-4">
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" name="logo" hidden accept="image/*" id="logo">
                    <label for="logo" class="import-img">
                        @if ($settings->logo)
                            <img src="{{ asset("storage/".$settings->logo)}}" alt="">
                            <a href="{{ route('admin.settings.deleteLogo') }}">delete logo</a>
                        @else
                            <div class="add-img">
                                <i class="far fa-image"></i>
                            </div>
                        @endif
                    </label>
                </div>

                <div class="form-group">
                    <label>Favicon</label>
                    <input type="file" name="favicon" hidden accept="image/*" id="favicon">
                    <label for="favicon" class="import-img">
                        @if ($settings->favicon)
                            <img src="{{ asset("storage/".$settings->favicon)}}" alt="">
                            <a href="{{ route('admin.settings.deleteFavicon') }}">delete favicon</a>

                        @else
                            <div class="add-img">
                                <i class="far fa-image"></i>
                            </div>
                        @endif
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="main-btn">
            Save
        </button>
       
    
    </form>    

@endsection


@section('scripts')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/jquery.simple-bar-graph.min.js') }}"></script>
    <script src="{{ asset('js/admin/app.js') }}"></script>
@endsection