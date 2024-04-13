@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/requests_users.css') }}">

<div class="container">
    <h1 class="mb-4">История ваших заявок</h1>
    @if($userRequests->isEmpty())
        <div class="alert alert-info" role="alert">
            У вас пока нет заявок.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Тема заявки</th>
                        <th scope="col">Имя отправителя</th>
                        <th scope="col">Описание</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userRequests as $request)
                        <tr>
                            <td>{{ $request->topic->name }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->text }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
