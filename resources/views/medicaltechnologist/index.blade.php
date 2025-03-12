@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<div class="card">
<div id="mainContent" class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Toggle Button for Mobile -->
        <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2 rounded-lg shadow-lg">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-l-4 border-blue-500">
            <div class="flex items-center">
                <i class="fas fa-file-medical-alt text-2xl text-blue-600 bg-blue-100 p-3 rounded-lg mr-4"></i>
                <h1 class="text-3xl font-bold text-gray-800">
                    Medical Laboratory Reports
                </h1>
            </div>
        </div>


            <!--  Pending Queues Section -->
<div class="mb-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-800 font-semibold flex items-center">
                <i class="fas fa-clock text-orange-500 mr-2"></i>
                Pending Transactions
            </h3>
            <span class="text-sm text-gray-500">{{ count($pendingQueues) }} Transactions</span>
        </div>
        <div class="overflow-x-auto">
            <div class="max-h-[300px] overflow-y-auto">
                <table class="min-w-full bg-white">
                    <thead class="sticky top-0 bg-white">
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Queue Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Services</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendingQueues as $queue)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-medium">Q-{{ str_pad($queue->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    ID: {{ $queue->transaction->patient->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @foreach($queue->transaction->services as $service)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                            {{ $service->service_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $queue->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       ($queue->status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                                       'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($queue->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Patients Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-600 font-semibold uppercase text-sm tracking-wider">
                            TOTAL PATIENTS
                        </p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2">
                            {{ $patientCount }}
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Active Records</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-600">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Updated real-time
                </div>
            </div>

            <!-- Laboratory Services Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-600 font-semibold uppercase text-sm tracking-wider">
                            LABORATORY SERVICES
                        </p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2">
                            {{ $laboratoryServiceCount }}
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Available Tests</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-flask text-2xl text-purple-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-purple-600">
                    <i class="fas fa-check-circle mr-2"></i>
                    Certified Tests
                </div>
            </div>

            <!-- Total Transactions Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-600 font-semibold uppercase text-sm tracking-wider">
                            TOTAL TRANSACTIONS
                        </p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2">
                            {{ $transactionCount }}
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Completed Tests</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-exchange-alt text-2xl text-green-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-green-600">
                    <i class="fas fa-check-circle mr-2"></i>
                    Verified Results
                </div>
            </div>

            <!-- Top Services Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-800 font-semibold flex items-center mb-4">
                    <i class="fas fa-star text-yellow-400 mr-2"></i>
                    Top Services
                </h3>
                <div class="space-y-3">
                    @foreach($topLaboratoryServices as $service)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                        <span class="text-gray-700">{{ $service->service_name }}</span>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm">
                            {{ $service->transactions_count }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>



        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Patients Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-800 font-semibold flex items-center mb-4">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                    Monthly Patient Statistics
                </h3>
                <div class="h-80">
                    <canvas id="monthlyPatientsChart"></canvas>
                </div>
            </div>

            <!-- Monthly Revenue Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-800 font-semibold flex items-center mb-4">
                    <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                    Monthly Revenue Analysis
                </h3>
                <div class="h-80">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-8 text-center">
            <div class="bg-white rounded-xl shadow-md p-4">
                <p class="text-gray-600">&copy; 2024 PRMIS EPH. All rights reserved.</p>
                <p class="text-blue-600 mt-2" id="liveDateTime"></p>
            </div>
        </footer>
    </div>
</div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        let isSidebarOpen = true; // Default state

        function checkWindowWidth() {
            return window.innerWidth <= 768;
        }

        function updateSidebarState() {
            if (isSidebarOpen) {
                mainContent.classList.add('sidebar-open');
                mainContent.classList.remove('sidebar-closed');
            } else {
                mainContent.classList.remove('sidebar-open');
                mainContent.classList.add('sidebar-closed');
            }
        }

        // Initialize sidebar state
        updateSidebarState();

        // Listen for sidebar toggle event
        window.addEventListener('sidebarToggle', function(e) {
            isSidebarOpen = e.detail.isOpen;
            updateSidebarState();
        });

        // Toggle sidebar on button click
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                isSidebarOpen = !isSidebarOpen;
                updateSidebarState();
                window.dispatchEvent(new CustomEvent('toggleSidebar'));
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (checkWindowWidth()) {
                mainContent.classList.add('sidebar-open');
                mainContent.classList.remove('sidebar-closed');
            } else {
                updateSidebarState();
            }
        });

        // DateTime Functions
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

        function updateLiveDateTime() {
            const liveDateTimeElem = document.getElementById('liveDateTime');
            if (liveDateTimeElem) {
                liveDateTimeElem.textContent = getCurrentDateTime();
            }
        }

        // Initialize DateTime
        updateLiveDateTime();
        setInterval(updateLiveDateTime, 1000);

        // Chart Configuration
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: 'Inter',
                            weight: '500'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        };

        // Initialize Charts
        const monthlyPatientsCtx = document.getElementById('monthlyPatientsChart').getContext('2d');
        new Chart(monthlyPatientsCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyPatients->pluck('month')),
                datasets: [{
                    label: 'Patient Count',
                    data: @json($monthlyPatients->pluck('count')),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(59, 130, 246, 0.7)'
                }]
            },
            options: chartOptions
        });

        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(monthlyRevenueCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenue->pluck('month')),
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue->pluck('revenue')),
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(16, 185, 129, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: chartOptions
        });
    });
</script>
@endsection
