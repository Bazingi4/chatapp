@extends('layouts.app')

@section('content')
<div class="container" style="color:#fff;">
    <h1 class="text-white mb-4">Бэкап базы данных</h1>

    <div class="card">
        <div class="card-body">
            <p>На этой странице вы можете создать бэкап базы данных.</p>
            <form action="{{ route('backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Создать бэкап</button>
            </form>
        </div>
    </div>
</div>
@endsection
