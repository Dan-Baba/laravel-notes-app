@extends('layouts.master')

@section('content')
@include('partials.info')

<div class="row">
    @foreach($notes as $note)
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-header">
                    {{ $note->title }}
                </div>
                <div class="card-body">
                    {{ $note->content }}
                </div>
                <div class="card-footer">
                    <a href="{{ route('edit', ['id' => $note->id]) }}">Edit Note</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<hr>

@stop