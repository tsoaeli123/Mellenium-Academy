@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Chat</h3>

    <div class="chat-box border p-3 mb-3" style="height:300px; overflow-y:scroll;">
        @foreach($messages as $msg)
            <div class="{{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                <p><strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}</p>
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.send') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $teacherId == auth()->id() ? $studentId : $teacherId }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div>
@endsection
