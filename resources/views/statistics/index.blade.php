@extends('layouts.app')

@section('content')
<div class="container" style="background-color: #f2f2f2; padding: 20px;">
    <h1 style="color: black;">Статистика</h1>

    <div class="row">
        <div class="col-md-6">
            <div style="background-color: white; padding: 20px; border-radius: 10px;">
                <h3 style="color: black;">Общая статистика</h3>
                <ul>
                    <li style="color: black;">Количество пользователей: {{ $usersCount }}</li>
                    <li style="color: black;">Количество чатов: {{ $chatsCount }}</li>
                    <li style="color: black;">Количество заявок: {{ $requestsCount }}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background-color: white; padding: 20px; border-radius: 10px;">
                <h3 style="color: black;">Статистика заявок по темам</h3>
                <canvas id="requestsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('requestsChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topics) !!},
            datasets: [{
                label: 'Количество заявок',
                data: {!! json_encode($counts) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
