<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .receipt-title {
            font-size: 20px;
            margin-top: 10px;
            color: #666;
        }
        .details {
            margin-bottom: 30px;
        }
        .row {
            margin-bottom: 10px;
            border-bottom: 1px solid #f5f5f5;
            padding-bottom: 5px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .status {
            color: #10B981;
            font-weight: bold;
            border: 2px solid #10B981;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Pale Ivory</div>
        <div class="receipt-title">Payment Receipt</div>
        <div style="margin-top: 10px;">Date: {{ now()->format('F j, Y') }}</div>
    </div>

    <div style="text-align: center;">
        <div class="status">PAID</div>
    </div>

    <div class="details">
        <div class="row">
            <span class="label">Student Name:</span>
            <span>{{ $student->name }}</span>
        </div>
        <div class="row">
            <span class="label">Matric Number:</span>
            <span>{{ $student->matric_number }}</span>
        </div>
        <div class="row">
            <span class="label">Email:</span>
            <span>{{ $student->email }}</span>
        </div>
        <div class="row">
            <span class="label">Department:</span>
            <span>{{ $student->department }}</span>
        </div>
        <div class="row">
            <span class="label">Level:</span>
            <span>{{ $student->level }}</span>
        </div>
        <div class="row">
            <span class="label">Trade:</span>
            <span>{{ $student->trade->name }}</span>
        </div>
        <div class="row">
            <span class="label">Amount Paid:</span>
            <span>₦15,000.00</span>
        </div>
        <div class="row">
            <span class="label">Reference ID:</span>
            <span>{{ $reference }}</span>
        </div>
    </div>

    <div class="footer">
        <p>This is an electronically generated receipt.</p>
        <p>&copy; {{ date('Y') }} Pale Ivory. All rights reserved.</p>
    </div>
</body>
</html>
