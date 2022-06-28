@extends ('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        {{isset($post) ?'Edit Post ': 'Create Post'}}
    </div>
    <div class="card-body">
        <!-- always enctype if multimedia wont be submitted to server -->
        <form action="{{isset($post) ? route('posts.update',$post->id) : route('posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(isset($post))
            @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value=" {{isset($post) ?$post->title: ' '}}" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" name="description" cols="5" rows="5" id="description" class="form-control"> {{isset($post) ?$post->description : ' '}} </textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" value=" {{isset($post) ? $post->content : ' '}}" type="hidden" name="content">
                <trix-editor input="content"></trix-editor>
            </div>
            <div class="form-group">
                <label for="published_at">Published At</label>
                <input type="text" name="published_at" value=" {{isset($post) ?$post->published_at: ''}}" id="published_at" class="form-control">
            </div>

            @if(isset($post))
            <img width="120" height="60" src="<?php echo asset("storage/$post->image") ?>"></img>
            @endif
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control">
                    @foreach($categories as $category)
                    <!-- if category id is set to post category id then seleect it -->
                    <option value="{{$category->id}}" @if(isset($post)) @if($category->id===$post->category_id)
                        selected
                        @endif
                        @endif
                        >
                        {{$category->name}}
                    </option>
                    @endforeach
                </select>
            </div>


            @if($tags->count() > 0 )
            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="form-control tags-selector" multiple>
                    @foreach($tags as $tag)
                    <!-- if in array we have the tag id in post tags after to array transform
                and the id needs to be plucked from arrays -->
                    <option value="{{$tag->id}}"
                        
                    @if(isset($post))
                    @if($post->hasTag($tag->id))
                    selected
                    @endif 
                    @endif
                    >

                        {{$tag->name}}

                    </option>
                    @endforeach
                </select>
            </div>
            @endif


            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                    {{isset($post) ? 'Update Post' : 'Create Post' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix-core.min.js" integrity="sha512-6C0JJHOrwdlZ6YMongpJax0kXCfu23TIbEETNjBpoCHJVSw+2NL8eE/CQ0ZNdPbdzrJ/T0HgXhUbBtJl1jyEXQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#published_at", {
        enableTime: true,
        enableSeconds:true
    });
    $(document).ready(function() {
    $('.tags-selector').select2();
});
</script>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />
@endsection