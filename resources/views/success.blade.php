<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Pale Ivory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
        }
        .success-icon {
            color: #10B981;
            font-size: 64px;
            margin-bottom: 20px;
        }
        .receipt-details {
            text-align: left;
            background: #F3F4F6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 10px;
        }
        .receipt-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .btn-download {
            background-color: #3B82F6;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .btn-download:hover {
            background-color: #2563EB;
        }
    </style>
</head>
<body>
    <div class="app-view">
        <div class="success-container">
            <i class="fa-solid fa-circle-check success-icon"></i>
            <h2>Registration Successful!</h2>
            <p>Thank you for registering for Enterpreneurship. Your payment has been processed successfully.</p>

            <div class="receipt-details">
                <div class="receipt-row">
                    <strong>Student Name:</strong>
                    <span>{{ $student->name }}</span>
                </div>
                <div class="receipt-row">
                    <strong>Matric Number:</strong>
                    <span>{{ $student->matric_number }}</span>
                </div>
                <div class="receipt-row">
                    <strong>Trade:</strong>
                    <span>{{ $student->trade->name }}</span>
                </div>
                <div class="receipt-row">
                    <strong>Amount Paid:</strong>
                    <span>₦15,000.00</span>
                </div>
                <div class="receipt-row">
                    <strong>Reference:</strong>
                    <span>{{ $reference }}</span>
                </div>
            </div>

            <a href="{{ route('receipt.download', ['student' => $student->id, 'reference' => $reference]) }}" class="btn-download">
                <i class="fa-solid fa-download"></i> Download Receipt
            </a>
            
            <div style="margin-top: 20px;">
                <a href="{{ route('home') }}" style="color: #6B7280; text-decoration: none;">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
