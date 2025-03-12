@extends('layouts.app')
@section('content')
<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .form-grid6 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .form-group6 {
        margin-top: 30px;
        background-color: #ffffff;
        padding: 30px;
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        margin-left: 20px;
        font-family: 'Arial', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group6:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .form-group6 h5 {
        font-size: 30px;
        color: #343a40;
        margin-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        font-weight: bold;
    }

    .form-group8 h5 {
        font-size: 30px;
        color: #343a40;
        margin-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        font-weight: bold;
    }

    .card-title6 {
        color: #495057;
        margin-bottom: 15px;
    }

    .form-group6 p:last-child {
        margin-bottom: 0;
    }

    .form-group7 {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        margin-left: 20px;
        max-width: 800px;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .form-group7 h5 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 8px;
        font-weight: 600;
    }

    .form-group7 tr {
        font-size: 18px;
        line-height: 1.6;
        color: #666;
        margin-bottom: 15px;
    }

    .form-group8 {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        width: 97%;
        margin-left: 20px;
        max-width: 800px;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .card-body4 h2 {
        font-size: 1.5rem;
        color: #343a40;
        margin-bottom: 15px;
    }

    .card-body4 p {
        font-size: 18px;
        color: #6c757d;
        line-height: 1.5;
    }

    .card-text {
        font-size: 20px;
        color: #495057;
        line-height: 1.6;
        margin-bottom: 15px;
        font-family: 'Arial', sans-serif;
    }

    .ins {
        font-size: 30px;
        color: #343a40;
        background-color: #f8f9fa;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        font-family: 'Arial', sans-serif;
    }

    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        #service-invoice, #service-invoice * {
            visibility: visible;
        }
        #service-invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
        }
    }
</style>
<div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-4 py-8 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:12px_12px]"></div>
        <div class="absolute h-24 w-24 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-24 w-24 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
                <i class="fas fa-file-invoice-dollar text-2xl text-yellow-600 bg-yellow-100 p-3 rounded-lg mr-4"></i>
                {{ __('Transaction Details') }}
            </h1>

            <div class="flex space-x-4">
                <!-- Edit Transaction Button -->
                <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="px-6 py-3 bg-yellow-400/40 text-yellow-700 rounded-xl font-semibold hover:bg-yellow-400/50 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-edit"></i> <span>Edit Transaction</span>
                </a>

                <!-- Print Button -->
                <a href="javascript:void(0)" onclick="printServiceInvoice()" class="px-6 py-3 bg-green-400/40 text-green-700 rounded-xl font-semibold hover:bg-green-400/50 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-print"></i> <span>Print Invoice</span>
                </a>
                <!-- Back Button -->
                <a href="{{ route('admin.transactions.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/50 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i><span>{{ __('Back') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-container">
            <div class="form-grid6">
                <div class="form-group6">
                    <h5 class="card-title6">Transaction ID</h5>
                    <p class="card-text">
                        <span class="font-bold">Transaction ID:</span> {{ $transaction->id }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Date:</span> {{ $transaction->date }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Total Payments:</span> {{ $transaction->total_payments }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Payment Status:</span> {{ $transaction->payment_status }}
                    </p>

                    @if ($transaction->physician)
                        <p class="card-text">
                            <span class="font-bold">Physician:</span> {{ $transaction->physician }}
                        </p>
                    @endif

                    @if ($transaction->radiologic_technologist)
                        <p class="card-text">
                            <span class="font-bold">Radiologic Technologist:</span> {{ $transaction->radiologic_technologist }}
                        </p>
                    @endif

                    @if ($transaction->queue)
                        <h5 class="card-title6">Queue Information</h5>
                        <p class="card-text">
                            <span class="font-bold">Queue Number:</span> {{ $transaction->queue->queuing_number }}
                        </p>
                        <p class="card-text">
                            <span class="font-bold">Queue Created At:</span> {{ $transaction->queue->created_at->format('Y-m-d H:i:s') }}
                        </p>
                    @endif
                </div>

                <div class="form-group6">
                    <h5 class="card-title6">Patient Information</h5>
                    <p class="card-text">
                        <span class="font-bold">Name:</span> {{ $transaction->patient->first_name }} {{ $transaction->patient->last_name }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Date of Birth:</span> {{ $transaction->patient->date_of_birth }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Gender:</span> {{ $transaction->patient->gender }}
                    </p>
                </div>

                <div class="form-group6">
                    <h5 class="card-title6">Last Meal</h5>
                    <p class="card-text">
                        <span class="font-bold"> Last Meal:</span> {{ $transaction->last_meal }}
                    </p>
                </div>
            </div>

            <div class="form-grid6">
                <div class="form-group7">
                    <h5 class="card-title6">Services Availed</h5>
                    <table class="all-table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->services as $service)
                            <tr>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->descriptions }}</td>
                                <td>{{ $service->fee }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Drug Test Consent Section -->
                <div class="form-group8">
                    <h5 class="card-title6">Drug Test Consent</h5>
                    <p class="card-text">
                        <span class="font-bold">Purpose of Drug Test:</span>{{ $transaction->drug_test_purpose }}<br>
                        <span class="font-bold">Confirmatory Testing Agreement:</span>
                        @if ($transaction->confirmatory_testing_agreement === 'accepted')
                            Accepted
                        @else
                            Not Accepted
                        @endif
                        <br>
                        <span class="font-bold">Sample Acknowledgement:</span>
                        @if ($transaction->sample_acknowledgement)
                            Acknowledged
                        @else
                            Not Acknowledged
                        @endif
                        <br>
                        <span class="font-bold">Medication in the Past 30 Days:</span>
                        @if ($transaction->medication_past_30_days)
                            Yes
                        @else
                            No
                        @endif
                        <br>
                        <span class="font-bold">Alcohol in the Past 24 Hours:</span>
                        @if ($transaction->alcohol_past_24_hours)
                            Yes
                        @else
                            No
                        @endif
                        <br>
                        <span class="font-bold">Sample Type:</span>{{ $transaction->sample_type }}<br>
                    </p>
                </div>
            </div>

            <!-- Consultation Information Section -->
            <div class="form-group6">
                <h5 class="card-title6">Consultation Details</h5>
                @if ($transaction->consultation)
                    <p class="card-text">
                        <span class="font-bold">Consultation ID:</span> {{ $transaction->consultation->id }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Consultation Date:</span> {{ \Carbon\Carbon::parse($transaction->consultation->date)->format('Y-m-d') }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Symptoms:</span> {{ $transaction->consultation->symptoms }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Diagnoses:</span> {{ $transaction->consultation->diagnoses }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Treatment Plan:</span> {{ $transaction->consultation->treatment_plan }}
                    </p>
                    <p class="card-text">
                        <span class="font-bold">Status:</span> {{ $transaction->consultation->status }}
                    </p>
                @else
                    <p class="card-text"><span class="font-bold">No consultation details available.</span></p>
                @endif
            </div>

            <!-- Instructions Section -->
            <div class="ins">{{ __('Instructions') }}</div>
            <div class="card-body4">
                <h2>Fasting and Reminder</h2>
                <p><span class="font-bold">Please ensure that the patient has fasted for at least 8 hours before the transaction.</span></p>
            </div>
        </div>
    </div>

</div>
<!-- Hidden Printable Service Invoice -->
<div id="printable-invoice" class="hidden print:block bg-white p-6">
    <div class="border-b-2 border-black pb-2 mb-4 text-center">
        <div class="flex items-center justify-center space-x-3">
            <!-- Clinic Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" class="w-12 h-12">
            <!-- Clinic Info -->
            <div class="text-center">
                <h2 class="text-base font-bold">EPH MULTI-SPECIALTY AND DIAGNOSTIC CENTER INC.</h2>
                <p class="italic text-xs">Because We Saw The Need.</p>
                <p class="text-xs">G/F YAP BLDG., Tibanga Highway, Santiago, Iligan City</p>
                <p class="text-xs">229-6558 | 0917-125-7121 | eph.tibanga2020@gmail.com</p>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h3 class="text-lg font-semibold mb-1">Patient Information</h3>
        <div class="grid grid-cols-2 gap-1 text-sm">
            <p><strong>Name:</strong> {{ $transaction->patient->first_name }} {{ $transaction->patient->last_name }}</p>
            <p><strong>Age:</strong>
                @php
                    $birthDate = \Carbon\Carbon::parse($transaction->patient->date_of_birth);
                    $age = (int) $birthDate->diffInYears(\Carbon\Carbon::now());
                @endphp
                {{ $age }}
            </p>
            <p><strong>Gender:</strong> {{ $transaction->patient->gender }}</p>
            <p><strong>Date of Birth:</strong> {{ $transaction->patient->date_of_birth }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-1">Services Availed</h3>
        <table class="w-full border-collapse border border-black text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black p-1">Service Name</th>
                    <th class="border border-black p-1">Description</th>
                    <th class="border border-black p-1">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalOriginalAmount = 0;
                @endphp
                @foreach ($transaction->services as $service)
                <tr>
                    <td class="border border-black p-1">{{ $service->service_name }}</td>
                    <td class="border border-black p-1">{{ $service->descriptions }}</td>
                    <td class="border border-black p-1 text-right">{{ number_format($service->fee, 2) }}</td>
                </tr>
                @php
                    $totalOriginalAmount += $service->fee;
                @endphp
                @endforeach
                <tr>
                    <td colspan="2" class="border border-black p-1 text-right">Total (Original)</td>
                    <td class="border border-black p-1 text-right">{{ number_format($totalOriginalAmount, 2) }}</td>
                </tr>
                <tr class="font-bold">
                    <td colspan="2" class="border border-black p-1 text-right">Total Payments (Discounted)</td>
                    <td class="border border-black p-1 text-right">{{ number_format($transaction->total_payments, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-center text-xs">
        <p class="italic">Thank you for your service</p>
    </div>
</div>

<!-- JavaScript to Print Invoice -->
<script>
    function printServiceInvoice() {
        var printContents = document.getElementById("printable-invoice").innerHTML;

        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Service Invoice</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid black; padding: 5px; text-align: left; }
                    .text-center { text-align: center; }
                    .italic { font-style: italic; }
                    .hidden { display: none; }
                    img { width: 100px !important; height: auto !important; }
                    @media print {
                        .hidden { display: block !important; }
                    }
                </style>
            </head>
            <body onload="window.print(); window.onafterprint = function() { window.close(); }">
                ${printContents}
            </body>
            </html>
        `);

        printWindow.document.close();
    }
</script>



@endsection

