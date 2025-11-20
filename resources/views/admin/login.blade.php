<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pale Ivory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Admin Portal</h2>
                <p>Please sign in to continue</p>
            </div>
            <form id="login-form">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="login-id" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="login-pass" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <div class="select-wrapper">
                        <select id="login-role">
                            <option value="admin">Entrepreneurship Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-primary full-width">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
