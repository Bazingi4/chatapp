<!-- resources/views/users/index.blade.php -->
<!-- Отображение списка пользователей-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Ваши дополнительные стили здесь -->
</head>
@extends('layouts.app')

@section('content')
    <h2>Список пользователей</h2>
    <ul>
        @foreach ($users as $user)
            <li><a class="user-link" href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
        @endforeach
    </ul>
@endsection
