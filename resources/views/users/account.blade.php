@extends('layouts.app')

@section('content')
<div class="container" style="color:#fff;">
    <h1 class="text-white mb-4">Мой аккаунт</h1>

    <div class="card">
        <div class="card-header">Информация о пользователе</div>
        <div class="card-body">
            <p><strong>Имя:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <!-- Другие данные о пользователе, если необходимо -->
        </div>
    </div>


@endsection
