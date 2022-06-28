@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Profile</div>
                <div class="card-body">
                    <form action="{{route('users.update-profile')}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name " value="{{$user->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea cols="5" rows="5" name="about" id="about " value="{{$user->about}}" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-success btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection