@extends('layouts.app')

@section('content')
    <div class="header">
        <h1>{{ __('Reports') }}</h1>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <h2>Total Patients</h2>
            <p>{{ $patientCount }}</p>
        </div>

        <div class="card">
            <h2>Total Laboratory Services</h2>
            <p>{{ $laboratoryServiceCount }}</p>
        </div>

        <div class="card">
            <h2>Total Transactions</h2>
            <p>{{ $transactionCount }}</p>
        </div>

        <div class="chart-container card">
            <h2>Monthly Patients</h2>
            <canvas id="monthlyPatientsChart"></canvas>
        </div>

        <div class="chart-container card">
            <h2>Monthly Revenue</h2>
            <canvas id="monthlyRevenueChart"></canvas>
        </div>

        <div class="card">
            <h2>Top Laboratory Services</h2>
            <ul>
                @foreach ($topLaboratoryServices as $service)
                    <li>{{ $service->service_name }} - {{ $service->transactions_count }} transactions</li>
                @endforeach
            </ul>
        </div>
    </div>

    <footer class="footer">
        &copy; 2024 PRMIS EPH. All rights reserved.
        <br>
        <span id="liveDateTime"></span>
    </footer>

    <!-- Include Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to get current time and date in Asia/Manila timezone
        function getCurrentDateTime() {
            const options = {
                timeZone: 'Asia/Manila',
                hour12: true,
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date().toLocaleString('en-US', options);
        }

        // Update live date and time every second
        function updateLiveDateTime() {
            const liveDateTimeElem = document.getElementById('liveDateTime');
            if (liveDateTimeElem) {
                liveDateTimeElem.textContent = getCurrentDateTime();
            }
        }

        // Update initially and then every second
        document.addEventListener('DOMContentLoaded', function () {
            updateLiveDateTime(); // Update initially
            setInterval(updateLiveDateTime, 1000); // Update every second
        });

        // Monthly Patients Chart (Bar)
        const monthlyPatientsCtx = document.getElementById('monthlyPatientsChart').getContext('2d');
        const monthlyPatientsData = {
            labels: @json($monthlyPatients->pluck('month')),
            datasets: [{
                label: 'Patients',
                data: @json($monthlyPatients->pluck('count')),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        new Chart(monthlyPatientsCtx, {
            type: 'bar',
            data: monthlyPatientsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Revenue Chart (Line)
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        const monthlyRevenueData = {
            labels: @json($monthlyRevenue->pluck('month')),
            datasets: [{
                label: 'Revenue',
                data: @json($monthlyRevenue->pluck('revenue')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        };
        new Chart(monthlyRevenueCtx, {
            type: 'line',
            data: monthlyRevenueData,
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
