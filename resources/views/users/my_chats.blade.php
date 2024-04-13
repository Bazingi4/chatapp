@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/chat_show.css') }}">

<div class="container">
    <h1 class="text-white mb-4">Мои чаты</h1>

    @if($chats->isEmpty())
    <div class="alert alert-info" role="alert">
        У вас пока нет чатов.
    </div>
    @else
    <ul class="list-group">
        @foreach($chats as $chat)
        <li class="list-group-item">
            <div class="row">
                <div class="col">
                    <h3>{{ $chat->name }}</h3>
                    <p><strong>Пользователь:</strong> {{ $chat->user->name }}</p>
                    <p><strong>Последнее сообщение:</strong> {{ $chat->messages->last() ? $chat->messages->last()->content : 'Сообщений нет' }}</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary btn-sm" href="{{ route('users.show', $chat->user->id) }}">Перейти в чат</a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection
