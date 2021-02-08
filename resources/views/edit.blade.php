@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ route('update') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $note->id }}">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $note->title }}">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="3">{{ $note->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@stop