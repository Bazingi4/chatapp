@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/log.css') }}">

<div class="container">
    <h1 class="text-center mb-4">Логи</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="log-list">
                        @forelse ($userLogs as $index => $log)
                            <div class="log-item {{ $index % 2 == 0 ? 'bg-light' : '' }}">
                                <span class="badge badge-primary">{{ $index + 1 }}</span>
                                {{ $log }}
                            </div>
                        @empty
                            <div class="log-item bg-light">Нет логов для отображения.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
