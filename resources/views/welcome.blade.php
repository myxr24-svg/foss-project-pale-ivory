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

                <form id="registration-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="reg-name" placeholder="e.g. Stephanie Umukoro" required>
                    </div>

                    <div class="form-group">
                        <label>Matric Number</label>
                        <input type="text" id="reg-matric" placeholder="e.g. 22/0096" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label>Email Address</label>
                            <input type="email" id="reg-email" placeholder="student@example.com" required>
                        </div>
                        <div class="form-group half">
                            <label>Phone Number</label>
                            <input type="tel" id="reg-phone" placeholder="+234..." required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label>Department</label>
                            <input type="text" id="reg-dept" placeholder="e.g. Software Engineering" required>
                        </div>
                        <div class="form-group half">
                            <label>Level</label>
                            <div class="select-wrapper">
                                <select id="reg-level" required>
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
                            <select id="reg-trade" required>
                                <option value="" disabled selected>Loading trades...</option>
                                <!-- Options populated by JS -->
                            </select>
                        </div>
                        <small id="trade-capacity-hint" class="hint-text"></small>
                    </div>

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
