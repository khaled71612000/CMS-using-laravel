@extends('layouts.app')
@section('content')
<div class="card">
        <div class="card-header">
                {{ isset($tag) ? 'Edit tag' : 'Create tag'}}
        </div>
        <div class="card-body">
        @include('partials.errors')
                <form action="{{ isset($tag) ? route('tags.update',$tag->id) : route('tags.store') }}" method="POST">
                        @csrf
                        @if(isset($tag))
                        @method('PUT')
                        @endif
                        <div class="form-group">
                                <label for="name">Name</label>
                                <!-- depends on edit or create -->
                                <input value="{{ isset($tag) ? $tag->name : ' '}}" type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                                <button class="btn btn-success">
                                        
{{ isset($tag) ?'Update tag' : 'Add tag'}}

                                </button>
                        </div>
                </form>
        </div>
</div>
@endsection