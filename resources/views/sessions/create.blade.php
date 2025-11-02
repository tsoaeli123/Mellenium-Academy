@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Zoom Session</h3>

    <form action="{{ route('sessions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Topic</label>
            <input type="text" name="topic" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Zoom Link</label>
            <input type="url" name="zoom_link" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <button class="btn btn-primary">Create Session</button>
    </form>
</div>
@endsection
