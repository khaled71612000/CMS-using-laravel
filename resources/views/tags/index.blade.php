@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-end mb-2 ">
    <a href="{{route('tags.create')}}" class="btn btn-success">Add tag</a>
</div>
<div class="card">
    <div class="card-header">
        tags
    </div>
    <div class="card-body">
@if($tags->count() > 0) 
<table class="table">
            <thead>
                <th>Name</th>
                <th>Post Count</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                <tr>
                    <td>
                        {{$tag->name}}
                    </td>

                    <td>
                        {{$tag->posts->count()}}
                    </td>

                    <td>
                        <a href="{{route('tags.edit',$tag->id)}}" class="text-light btn-sm btn btn-info">Edit</a>
                        <!-- on click call delete -->
                        <button class="btn btn-sm btn-danger" onclick="handleDelete({{$tag->id}})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <!-- empty cause u want dynamic -->
                <form method="POST" id="deletetagForm">
                    <!-- to deltee -->
                    @method('DELETE')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete tag </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                            <button type="submit" class="btn btn-danger">Yes Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@else
<h3 class="text-center">No tags Yet</h3>
@endif
    </div>
</div>
@endsection

<!-- script everywhere -->
@section('scripts')
<script>
    function handleDelete(id) {
        let form = document.getElementById('deletetagForm');
        // the action is this one and fetch it with method delete
        form.action = '/tags/' + id;
        $('#deleteModal').modal('show');
    }
</script>
@endsection