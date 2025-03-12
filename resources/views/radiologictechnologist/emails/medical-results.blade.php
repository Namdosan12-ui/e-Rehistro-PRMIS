<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Medical Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $hospitalName }}</h1>
    </div>

    <div class="content">
        <p>Dear {{ $patientName }},</p>

        <p>Please find attached your medical results for your tests conducted on {{ $testDate }}.</p>

        <p>Reference Number: {{ $transactionId }}</p>

        <p>For any questions or concerns about your results, please contact your healthcare provider.</p>

        <p>Best regards,<br>
        {{ $receptionName }}<br>
        Reception Department<br>
        {{ $hospitalName }}</p>
    </div>

    <div class="footer">
        <p>This email contains confidential medical information. If you received this email in error, please delete it and notify us immediately.</p>

        <p>© {{ date('Y') }} {{ $hospitalName }}. All rights reserved.</p>
    </div>
</body>
</html>
