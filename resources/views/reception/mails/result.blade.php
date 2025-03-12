<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .content {
            margin-bottom: 20px;
            color: #444;
        }
        .footer {
            color: #666;
            font-size: 14px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Medical Results - Transaction #{{ $transactionId }}
        </div>

        <div class="content">
            <p>Dear {{ $patientName }},</p>

            <p>Please find attached your medical results for Transaction #{{ $transactionId }}.</p>

            <p>If you have any questions about your results, please contact our facility.</p>

            <p>Note: This is a confidential medical document. Please ensure it is stored securely.</p>
        </div>

        <div class="footer">
            <p>Best regards,<br>
            Your Healthcare Provider</p>

            <small>This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed.</small>
        </div>
    </div>
</body>
</html>
