@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/requests_users.css') }}">

<div class="container">
    <h1 class="mb-4">Все заявки</h1>
    @if($requests->isEmpty())
        <div class="alert alert-info" role="alert">
            Нет заявок для отображения.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Тема заявки</th>
                        <th scope="col">Имя отправителя</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->topic->name }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->text }}</td>
                            <td><a href="{{ route('users.show', $request->user->id) }}" class="btn btn-primary">Перейти в чат</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
