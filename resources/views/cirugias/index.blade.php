@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Cantidad de Cirugías Mensuales</h1>
        <div id="monthly-surgeries">
            <p>Total de cirugías este mes: {{ $totalSurgeriesCurrentMonth }}</p>
            <p>Total de cirugías el mes pasado: {{ $totalSurgeriesLastMonth }}</p>
            <canvas id="surgeriesChart"></canvas>
        </div>

        <h2>Lista de Cirugías</h2>
        <ul>
            @foreach ($cirugias as $surgery)
                <li>
                    <strong>{{ $surgery->nombre }}</strong> - Fecha: {{ $surgery->fecha }} - Hora: {{ $surgery->hora }}
                </li>
            @endforeach
        </ul>

        <!-- Pagination Controls -->
        {{ $cirugias->links() }}
    </div>

    <script>
        const ctx = document.getElementById('surgeriesChart').getContext('2d');
        const surgeriesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mes Actual', 'Mes Anterior'],
                datasets: [{
                    label: 'Cantidad de Cirugías',
                    data: [{{ $totalSurgeriesCurrentMonth }}, {{ $totalSurgeriesLastMonth }}],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
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
