<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Pale Ivory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- PUBLIC SECTION: Student Registration -->
    <div id="public-app" class="app-view">

        <div class="registration-container">
            <div class="reg-card">
                <div class="reg-header">
                    <h2>Student Registration</h2>
                    <p>Register for your trade and make payment securely.</p>
                </div>

                <form id="registration-form" action="{{ route('student.register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" id="reg-name" placeholder="e.g. Stephanie Umukoro" required>
                    </div>

                    <div class="form-group">
                        <label>Matric Number</label>
                        <input type="text" name="matric_number" id="reg-matric" placeholder="e.g. 22/0096" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label>Email Address</label>
                            <input type="email" name="email" id="reg-email" placeholder="student@example.com" required>
                        </div>
                        <div class="form-group half">
                            <label>Phone Number</label>
                            <input type="tel" name="phone_number" id="reg-phone" placeholder="+234..." required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label>Department</label>
                            <input type="text" name="department" id="reg-dept" placeholder="e.g. Software Engineering" required>
                        </div>
                        <div class="form-group half">
                            <label>Level</label>
                            <div class="select-wrapper">
                                <select name="level" id="reg-level" required>
                                    <option value="" disabled selected>Select Level</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Trade</label>
                        <div class="select-wrapper">
                            <select name="trade_id" id="reg-trade" required>
                                <option value="" disabled selected>Select Trade</option>
                                @foreach($trades as $trade)
                                <option value="{{ $trade->id }}">{{ $trade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="trade-capacity-hint" class="hint-text"></small>
                    </div>

                    @if (session()->has('message'))
                    <div class="alert alert-{{ session('message')['type'] }}" style="color: {{ session('message')['type'] == 'error' ? 'red' : 'green' }}; margin-bottom: 15px;">
                        {{ session('message')['msg'] }}
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success" style="color: green; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="btn-primary full-width">
                            Pay Now <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
