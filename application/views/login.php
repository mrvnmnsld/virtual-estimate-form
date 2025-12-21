<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Virtual Estimate Form</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #F2A61D;
            --secondary-color: #0D2949;
            --accent-color: #F2A61D;
            --dark-color: #1f2937;
            --light-color: #f8f9fa;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Open Sans', sans-serif;
            background: var(--secondary-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: var(--secondary-color);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(242, 166, 29, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 1;
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            opacity: 0.95;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: 3rem 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(242, 166, 29, 0.1);
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            z-index: 3;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .btn-login {
            width: 100%;
            background: var(--primary-color);
            color: white;
            padding: 0.875rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: #d4941a;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(242, 166, 29, 0.4);
            color: white;
        }

        .btn-login:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-danger {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border-left-color: #10b981;
            color: #166534;
        }

        .forgot-password {
            text-align: center;
            margin-top: 1.5rem;
        }

        .forgot-password a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--primary-color);
        }

        .back-to-home {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .back-to-home a {
            color: #718096;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-to-home a:hover {
            color: var(--secondary-color);
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-login.loading .loading-spinner {
            display: inline-block;
        }

        @media (max-width: 768px) {
            .login-body {
                padding: 2rem 1.5rem;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <img src="<?php echo base_url('assets/img/logo.webp'); ?>" alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; width: 80px; height: 80px; background: var(--primary-color); border-radius: 50%; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem; margin: 0 auto;">
                        VE
                    </div>
                </div>
                <h1><i class="bi bi-shield-lock"></i> Admin Login</h1>
                <p>Access the admin dashboard</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Error/Success Messages -->
                <div id="alertMessage" style="display: none;"></div>

                <form id="loginForm">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-person"></i> Username
                        </label>
                        <div class="input-group">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <div class="input-group">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <span class="loading-spinner"></span>
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <div class="forgot-password">
                    <a href="#" id="forgotPasswordLink">Forgot your password?</a>
                </div>

                <div class="back-to-home">
                    <a href="<?php echo base_url(); ?>">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            const loginForm = $('#loginForm');
            const loginBtn = $('#loginBtn');
            const alertMessage = $('#alertMessage');

            function showAlert(message, type) {
                alertMessage.removeClass('alert-danger alert-success')
                           .addClass('alert alert-' + type)
                           .html('<i class="bi bi-' + (type === 'danger' ? 'exclamation-triangle' : 'check-circle') + '-fill"></i> ' + message)
                           .slideDown(300);
                
                setTimeout(function() {
                    alertMessage.slideUp(300);
                }, 5000);
            }

            loginForm.on('submit', function(e) {
                e.preventDefault();
                
                const username = $('#username').val().trim();
                const password = $('#password').val();
                const userIP = ''; // Can be populated with actual IP if needed

                if (!username || !password) {
                    showAlert('Please enter both username and password.', 'danger');
                    return;
                }

                // Disable button and show loading
                loginBtn.prop('disabled', true).addClass('loading');
                loginBtn.html('<span class="loading-spinner"></span> Logging in...');

                // Submit login credentials
                $.ajax({
                    url: '<?php echo base_url("main/checkLoginCredentials"); ?>',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password,
                        user_ip: userIP
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.isProceed) {
                            showAlert('Login successful! Redirecting...', 'success');
                            setTimeout(function() {
                                window.location.href = '<?php echo base_url("dashboard"); ?>';
                            }, 1000);
                        } else {
                            showAlert(response.msg || 'Invalid credentials. Please try again.', 'danger');
                            loginBtn.prop('disabled', false).removeClass('loading');
                            loginBtn.html('<i class="bi bi-box-arrow-in-right"></i> Login');
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred. Please try again later.';
                        
                        // Try to parse error response
                        if (xhr.responseJSON && xhr.responseJSON.msg) {
                            errorMessage = xhr.responseJSON.msg;
                        } else if (xhr.responseText) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.msg) {
                                    errorMessage = response.msg;
                                }
                            } catch (e) {
                                // Keep default error message
                            }
                        }
                        
                        showAlert(errorMessage, 'danger');
                        loginBtn.prop('disabled', false).removeClass('loading');
                        loginBtn.html('<i class="bi bi-box-arrow-in-right"></i> Login');
                    }
                });
            });

            // Enter key to submit
            $('#username, #password').on('keypress', function(e) {
                if (e.which === 13) {
                    loginForm.submit();
                }
            });
        });
    </script>
</body>
</html>

