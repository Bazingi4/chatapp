@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/requests.css') }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Отправка заявки в техподдержку</div>

                <div class="card-body">
                    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="topic" class="form-label">Тема заявки</label>
                            <select class="form-select" id="topic" name="topic_id" required>
                                <option value="" selected disabled>Выберите тему заявки</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Текст заявки</label>
                            <textarea class="form-control" id="text" name="text" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Прикрепить файл</label>
                            <input type="file" class="form-control" id="file" name="file" >
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить заявку</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
