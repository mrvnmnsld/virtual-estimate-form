<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Estimate Form - Create Estimate</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #F2A61D;
            --secondary-color: #0D2949;
            --accent-color: #F2A61D;
            --dark-color: #1f2937;
            --light-color: #f8f9fa;
            --success-color: #10b981;
            --warning-color: #f59e0b;
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
            padding: 2rem 0;
        }

        .form-container {
            max-width: 950px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 80px rgba(13, 41, 73, 0.25);
            overflow: hidden;
        }

        .form-header {
            background: var(--primary-color);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(242, 166, 29, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .form-header h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .form-header p {
            opacity: 0.95;
            font-size: 1.05rem;
            position: relative;
            z-index: 1;
        }

        .progress-bar-container {
            padding: 2rem;
            background: #f8f9fa;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 1rem;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e2e8f0;
            z-index: 1;
        }

        .progress-line {
            position: absolute;
            top: 20px;
            left: 0;
            height: 4px;
            background: var(--primary-color);
            z-index: 2;
            transition: width 0.5s ease;
            box-shadow: 0 0 10px rgba(242, 166, 29, 0.5);
        }

        .step-item {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: 600;
            color: #718096;
            transition: all 0.3s ease;
        }

        .step-item.active .step-circle {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(242, 166, 29, 0.4);
        }

        .step-item.completed .step-circle {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }

        .step-item.completed .step-circle::before {
            content: '\2713';
            font-size: 1.2rem;
        }

        .step-label {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 500;
        }

        .step-item.active .step-label {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .form-body {
            padding: 3.5rem;
        }

        .form-body h3 {
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-color);
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .form-label .required {
            color: #ef4444;
            margin-left: 3px;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(242, 166, 29, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 3.5rem 2rem;
            text-align: center;
            background: var(--light-color);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            user-select: none;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
            background: #fffbf0;
            border-style: solid;
        }

        .file-upload-area.dragover {
            border-color: var(--primary-color);
            background: #fffbf0;
            border-style: solid;
            transform: scale(1.01);
            box-shadow: 0 8px 25px rgba(242, 166, 29, 0.15);
        }

        .file-upload-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 1.25rem;
        }

        .file-upload-text {
            font-size: 1.1rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .file-upload-hint {
            font-size: 0.9rem;
            color: #718096;
        }

        .file-list {
            margin-top: 1.5rem;
        }

        .file-item {
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .file-icon {
            font-size: 1.75rem;
            color: var(--secondary-color);
            margin-right: 1rem;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .file-size {
            font-size: 0.85rem;
            color: #718096;
        }

        .file-remove {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-remove:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .sample-image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 0;
            height: 100%;
            min-height: 200px;
        }

        .sample-image-label {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 0.75rem;
            font-weight: 500;
            text-align: center;
            width: 100%;
        }

        .sample-image {
            width: 100%;
            height: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sample-image:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: scale(1.02);
        }

        /* Image Modal Styles */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            animation: fadeIn 0.3s ease;
        }

        .image-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9998;
        }

        .image-modal-content {
            position: relative;
            z-index: 9999;
            max-width: 90%;
            max-height: 90%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: zoomIn 0.3s ease;
        }

        .image-modal-content img {
            max-width: 100%;
            max-height: 90vh;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .image-modal-close {
            position: fixed;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .image-modal-close:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: rotate(90deg);
            border-color: rgba(255, 255, 255, 0.6);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .file-upload-wrapper .row {
            align-items: stretch;
            display: flex;
        }

        .file-upload-wrapper .col-md-7,
        .file-upload-wrapper .col-md-5 {
            display: flex;
            flex-direction: column;
        }

        .file-upload-wrapper .file-upload-section {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .file-upload-wrapper .sample-image-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            background: var(--light-color);
        }

        .sample-image-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            overflow: hidden;
        }

        /* Modern Searchable Select Styles */
        .modern-select-wrapper {
            position: relative;
        }

        .modern-select-input {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .modern-select-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(242, 166, 29, 0.1);
            outline: none;
        }

        .modern-select-input.has-value {
            color: var(--dark-color);
        }

        .modern-select-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            margin-top: 4px;
        }

        .modern-select-dropdown.active {
            display: block;
            animation: slideDown 0.2s ease;
        }

        .modern-select-option {
            padding: 0.875rem 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .modern-select-option:last-child {
            border-bottom: none;
        }

        .modern-select-option:hover {
            background: #f8f9fa;
        }

        .modern-select-option.selected {
            background: var(--primary-color);
            color: white;
        }

        .modern-select-option.no-results {
            padding: 1rem;
            text-align: center;
            color: #718096;
            font-style: italic;
        }

        .modern-select-add-new {
            padding: 0.875rem 1.25rem;
            background: #e3f2fd;
            border-top: 2px solid var(--primary-color);
            cursor: pointer;
            font-weight: 500;
            color: var(--secondary-color);
            transition: all 0.2s ease;
        }

        .modern-select-add-new:hover {
            background: #bbdefb;
        }

        .modern-select-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #718096;
            transition: transform 0.3s ease;
        }

        .modern-select-wrapper.active .modern-select-icon {
            transform: translateY(-50%) rotate(180deg);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .btn-form {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-next, .btn-submit {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .btn-next:hover, .btn-submit:hover {
            background: #d4941a;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(242, 166, 29, 0.4);
            color: white;
        }

        .btn-prev {
            background: var(--light-color);
            color: var(--secondary-color);
            border: 2px solid var(--border-color);
        }

        .btn-prev:hover {
            background: #e5e7eb;
            border-color: var(--secondary-color);
            color: var(--secondary-color);
        }

        .btn-prev.hidden,
        .btn-submit.hidden,
        .btn-next.hidden {
            display: none !important;
        }

        .summary-card {
            background: var(--light-color);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            background: #f0f0f0;
            transform: translateX(5px);
        }

        .summary-label {
            font-weight: 600;
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .summary-value {
            font-size: 1.1rem;
            color: var(--dark-color);
            font-weight: 500;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1.25rem 1.5rem;
            border-left: 4px solid;
        }

        .alert-info {
            background: #eff6ff;
            border-left-color: #3b82f6;
            color: #1e40af;
        }

        .alert-success {
            background: #f0fdf4;
            border-left-color: var(--success-color);
            color: #166534;
        }

        .alert-warning {
            background: #fffbeb;
            border-left-color: var(--warning-color);
            color: #92400e;
        }

        .form-group.has-error .form-label {
            color: #ef4444;
        }

        hr {
            border-color: var(--border-color);
            opacity: 0.5;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(242, 166, 29, 0.25);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .progress-bar-container {
            background: var(--light-color);
            border-bottom: 1px solid var(--border-color);
        }

        .form-actions {
            background: var(--light-color);
            margin: 2rem -3.5rem -3.5rem;
            padding: 2rem 3.5rem;
            border-top: 2px solid var(--border-color);
        }

        /* Success Page Styles */
        .success-page {
            display: none;
            text-align: center;
            padding: 4rem 2rem;
        }

        .success-page.active {
            display: block;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--success-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3.5rem;
            color: white;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .success-message {
            font-size: 1.2rem;
            color: #4a5568;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .ticket-number-box {
            background: linear-gradient(135deg, var(--primary-color), #d4941a);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(242, 166, 29, 0.3);
        }

        .ticket-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .ticket-number {
            font-size: 2.5rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            margin: 1rem 0;
        }

        .ticket-warning {
            background: #fff3cd;
            border-left: 4px solid var(--warning-color);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: left;
        }

        .ticket-warning strong {
            color: #92400e;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Loading Screen Styles */
        .loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 41, 73, 0.95);
            backdrop-filter: blur(10px);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .loading-screen.active {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(242, 166, 29, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 2rem;
        }

        .loading-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
        }

        .loading-subtext {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-top: 1rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Validation Error Styles */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #ef4444;
        }

        .form-control.is-invalid ~ .invalid-feedback,
        .form-select.is-invalid ~ .invalid-feedback {
            display: block;
        }

        .form-group.has-error .form-label {
            color: #ef4444;
        }

        .email-notification {
            background: #e7f3ff;
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: left;
        }

        .email-notification strong {
            color: #1e40af;
            display: block;
            margin-bottom: 0.5rem;
        }

        .btn-home {
            background: var(--secondary-color);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 2rem;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background: #0a1f3a;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(13, 41, 73, 0.3);
            color: white;
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 2rem 1.5rem;
            }

            .form-actions {
                margin: 2rem -1.5rem -1.5rem;
                padding: 1.5rem;
            }

            .step-label {
                font-size: 0.75rem;
            }

            .form-header h1 {
                font-size: 1.75rem;
            }

            .form-header {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Header -->
            <div class="form-header">
                <h1><i class="bi bi-calculator"></i> Virtual Estimate Form</h1>
                <p>Fill out the form below to get your estimate</p>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-steps">
                    <div class="progress-line" id="progressLine"></div>
                    <div class="step-item active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Personal Info</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Project Details</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Charger & Files</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Review & Submit</div>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <!-- Success Page -->
                <div class="success-page" id="successPage">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="success-title">Estimate Request Submitted Successfully!</h2>
                    <p class="success-message">
                        Thank you for submitting your virtual estimate request. We have received your information and will process it shortly.
                    </p>
                    
                    <div class="ticket-number-box">
                        <div class="ticket-label">Your Ticket Number</div>
                        <div class="ticket-number" id="ticketNumber">-</div>
                        <div style="font-size: 0.9rem; opacity: 0.9;">Please save this number for your records</div>
                    </div>

                    <div class="ticket-warning">
                        <strong><i class="bi bi-shield-exclamation"></i> Important: Keep Your Ticket Number Safe</strong>
                        <p class="mb-0">Please save or screenshot this ticket number. You will need it to track your estimate request and for any future correspondence with our team.</p>
                    </div>

                    <div class="email-notification">
                        <strong><i class="bi bi-envelope-check"></i> Email Confirmation Sent</strong>
                        <p class="mb-0">A confirmation email containing your ticket number and estimate request details has been sent to your email address. Please check your inbox (and spam folder) for the confirmation email.</p>
                    </div>

                    <a href="<?php echo base_url(); ?>" class="btn-home">
                        <i class="bi bi-house"></i> Return to Home
                    </a>
                </div>

                <form id="estimateForm">
                    <!-- Step 1: Personal Information -->
                    <div class="form-step active" id="step1">
                        <h3 class="mb-4"><i class="bi bi-person"></i> Personal Information</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        First Name <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="firstName">
                                    <div class="invalid-feedback">First name is required.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Last Name <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="lastName">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="email">
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Phone Number <span class="required">*</span>
                                    </label>
                                    <input type="tel" class="form-control" name="phone">
                                    <div class="invalid-feedback">Phone number is required.</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Company/Organization
                            </label>
                            <input type="text" class="form-control" name="company">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Address <span class="required">*</span>
                            </label>
                            <textarea class="form-control" name="address" rows="3"></textarea>
                            <div class="invalid-feedback">Address is required.</div>
                        </div>
                    </div>

                    <!-- Step 2: Project Details -->
                    <div class="form-step" id="step2">
                        <h3 class="mb-4"><i class="bi bi-clipboard-data"></i> Project Details</h3>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Project Type <span class="required">*</span>
                            </label>
                            <select class="form-select" name="projectType">
                                <option value="">Select project type...</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="industrial">Industrial</option>
                                <option value="renovation">Renovation</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="invalid-feedback">Project type is required.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Project Description <span class="required">*</span>
                            </label>
                            <textarea class="form-control" name="projectDescription" rows="5" placeholder="Please describe your project in detail..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Timeline <span class="required">*</span>
                            </label>
                            <select class="form-select" name="timeline">
                                <option value="">Select timeline...</option>
                                <option value="1-3days">1-3 Days</option>
                                <option value="4-6days">4-6 Days</option>
                                <option value="2weeks">2 Weeks</option>
                                <option value="1month">1 Month</option>
                            </select>
                            <div class="invalid-feedback">Timeline is required.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Additional Requirements
                            </label>
                            <textarea class="form-control" name="additionalRequirements" rows="4" placeholder="Any additional requirements or special considerations..."></textarea>
                        </div>
                    </div>

                    <!-- Step 3: File Upload & Charger Details -->
                    <div class="form-step" id="step3">
                        <h3 class="mb-4"><i class="bi bi-cloud-upload"></i> Charger Details & File Upload</h3>
                        
                        <!-- Charger Model -->
                        <div class="form-group">
                            <label class="form-label">
                                Model of the Charger <span class="required">*</span>
                            </label>
                            <div class="modern-select-wrapper" id="chargerModelWrapper">
                                <input type="text" 
                                       class="modern-select-input form-control" 
                                       id="chargerModelInput" 
                                       name="chargerModel" 
                                       placeholder="Search or type to add new model..."
                                       autocomplete="off"
                                       data-selected-id="">
                                <i class="bi bi-chevron-down modern-select-icon"></i>
                                <div class="modern-select-dropdown" id="chargerModelDropdown">
                                    <div class="modern-select-option no-results">Loading models...</div>
                                </div>
                            </div>
                            <div class="invalid-feedback" style="display: none;">Charger model is required.</div>
                            <input type="hidden" name="chargerModelId" id="chargerModelId" value="">
                        </div>

                        <!-- Duke Rebate Program -->
                        <div class="form-group">
                            <label class="form-label">
                                Is this through Duke Rebate Program? <span class="required">*</span>
                            </label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="dukeRebate" id="dukeRebateYes" value="yes">
                                <label class="form-check-label" for="dukeRebateYes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dukeRebate" id="dukeRebateNo" value="no">
                                <label class="form-check-label" for="dukeRebateNo">
                                    No
                                </label>
                            </div>
                        </div>

                        <!-- Duke Rebate Questions (shown only if Yes) -->
                        <div id="dukeRebateQuestions" style="display: none;">
                            <div class="alert alert-warning mb-4">
                                <i class="bi bi-exclamation-triangle-fill"></i> <strong>Duke Rebate Qualification</strong>
                                <p class="mb-0 mt-2">To qualify for the Duke rebate, please answer the following questions:</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Are you renting this home? <span class="required">*</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="rentingHome" id="rentingYes" value="yes">
                                    <label class="form-check-label" for="rentingYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rentingHome" id="rentingNo" value="no">
                                    <label class="form-check-label" for="rentingNo">
                                        No
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Are you a Duke Energy customer? <span class="required">*</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="dukeCustomer" id="dukeCustomerYes" value="yes">
                                    <label class="form-check-label" for="dukeCustomerYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="dukeCustomer" id="dukeCustomerNo" value="no">
                                    <label class="form-check-label" for="dukeCustomerNo">
                                        No
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Will the electric vehicle be registered to this home address under a personal name? <span class="required">*</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="evRegistered" id="evRegisteredYes" value="yes">
                                    <label class="form-check-label" for="evRegisteredYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="evRegistered" id="evRegisteredNo" value="no">
                                    <label class="form-check-label" for="evRegisteredNo">
                                        No
                                    </label>
                                </div>
                            </div>

                            <!-- Automated Information -->
                            <div class="alert alert-info mt-4" id="dukeRebateNote">
                                <i class="bi bi-info-circle-fill"></i> <strong>Duke Rebate Program Information</strong>
                                <div class="mt-3">
                                    <p><strong>Installation & Payment Process:</strong></p>
                                    <p>Upon completion of your installation, your new charger will be fully operational and ready for use. We accept payment on-site via cash, check, or card.</p>
                                    
                                    <p class="mt-3"><strong>Permit & Inspection Process:</strong></p>
                                    <p>Our team will handle the city permit application and all associated fees on your behalf. Please disregard any emails from the city regarding permits, as we have this process covered. Within two weeks of your installation date, we will contact you to schedule your city inspection.</p>
                                    
                                    <p class="mt-3"><strong>Rebate Application Process:</strong></p>
                                    <p>Once the inspection is complete, you will receive an email from us containing two forms needed for your Duke rebate submission. After receiving this email, you will simply complete the online Duke application. Duke Energy will then review your application and mail you the rebate check.</p>
                                    
                                    <p class="mt-3"><strong>What You Need to Know:</strong></p>
                                    <p>While this process involves several steps, you don't need to take any action until you receive the final email from us after the inspection is complete. We will manage every other step throughout the process.</p>
                                    
                                    <p class="mt-3"><strong>Installation Pricing:</strong></p>
                                    <p>For this installation, we can complete the work for the Duke rebate maximum of $1,117. We will need the charger to be on-site, and we will take care of everything else.</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- File Upload Sections -->
                        <h4 class="mb-3" style="color: var(--secondary-color); font-weight: 600;">Upload Photos</h4>
                        <p class="text-muted mb-4">Please upload photos for each of the following areas. Maximum file size: 10MB per file.</p>

                        <!-- Electrical Panel -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="bi bi-lightning-charge"></i> Electrical Panel <span class="required">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="file-upload-section" data-category="electrical-panel">
                                            <div class="file-upload-area" data-category="electrical-panel">
                                                <div class="file-upload-icon">
                                                    <i class="bi bi-cloud-upload"></i>
                                                </div>
                                                <div class="file-upload-text">Drag & drop files here or click to browse</div>
                                                <div class="file-upload-hint">Supported formats: PDF, JPG, PNG</div>
                                                <input type="file" class="file-input-category" name="electrical-panel[]" data-category="electrical-panel" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            </div>
                                            <div class="file-list" data-category="electrical-panel"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="sample-image-container">
                                            <div class="sample-image-label">Sample Photo</div>
                                            <div class="sample-image-wrapper">
                                                <img src="" alt="Electrical Panel Sample" class="sample-image" data-category="electrical-panel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Installation Area -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="bi bi-geo-alt"></i> Installation Area <span class="required">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="file-upload-section" data-category="installation-area">
                                            <div class="file-upload-area" data-category="installation-area">
                                                <div class="file-upload-icon">
                                                    <i class="bi bi-cloud-upload"></i>
                                                </div>
                                                <div class="file-upload-text">Drag & drop files here or click to browse</div>
                                                <div class="file-upload-hint">Supported formats: PDF, JPG, PNG</div>
                                                <input type="file" class="file-input-category" name="installation-area[]" data-category="installation-area" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            </div>
                                            <div class="file-list" data-category="installation-area"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="sample-image-container">
                                            <div class="sample-image-label">Sample Photo</div>
                                            <div class="sample-image-wrapper">
                                                <img src="" alt="Installation Area Sample" class="sample-image" data-category="installation-area">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Area Going to Charger Location -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="bi bi-signpost"></i> Electrical panel going to the Charger Location <span class="required">*</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="file-upload-section" data-category="charger-location">
                                            <div class="file-upload-area" data-category="charger-location">
                                                <div class="file-upload-icon">
                                                    <i class="bi bi-cloud-upload"></i>
                                                </div>
                                                <div class="file-upload-text">Drag & drop files here or click to browse</div>
                                                <div class="file-upload-hint">Supported formats: PDF, JPG, PNG</div>
                                                <input type="file" class="file-input-category" name="charger-location[]" data-category="charger-location" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            </div>
                                            <div class="file-list" data-category="charger-location"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="sample-image-container">
                                            <div class="sample-image-label">Sample Photo</div>
                                            <div class="sample-image-wrapper">
                                                <img src="" alt="Charger Location Sample" class="sample-image" data-category="charger-location">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Note:</strong> Uploading clear photos of these areas will help us provide a more accurate estimate.
                        </div>
                    </div>

                    <!-- Step 4: Review & Submit -->
                    <div class="form-step" id="step4">
                        <h3 class="mb-4"><i class="bi bi-check-circle"></i> Review & Submit</h3>
                        
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> Please review your information before submitting.
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Full Name</div>
                            <div class="summary-value" id="summaryName">-</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Email</div>
                            <div class="summary-value" id="summaryEmail">-</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Phone</div>
                            <div class="summary-value" id="summaryPhone">-</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Project Type</div>
                            <div class="summary-value" id="summaryProjectType">-</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Budget Range</div>
                            <div class="summary-value" id="summaryBudget">-</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-label">Files Uploaded</div>
                            <div class="summary-value" id="summaryFiles">0 files</div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeTerms">
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the terms and conditions and privacy policy <span class="required">*</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-form btn-prev hidden" id="prevBtn">
                            <i class="bi bi-arrow-left"></i> Previous
                        </button>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-form btn-next" id="nextBtn">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn btn-form btn-submit hidden" id="submitBtn">
                                <i class="bi bi-send"></i> Submit Estimate Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <div class="image-modal-backdrop"></div>
        <span class="image-modal-close">&times;</span>
        <div class="image-modal-content">
            <img id="modalImage" src="" alt="Full size image">
        </div>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-screen">
        <div class="loading-spinner"></div>
        <div class="loading-text">Submitting Estimate...</div>
        <div class="loading-subtext">Please wait while we process your request</div>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-screen">
        <div class="loading-spinner"></div>
        <div class="loading-text">Submitting Estimate...</div>
        <div class="loading-subtext">Please wait while we process your request</div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Define base_url for AJAX calls
        var base_url = '<?php echo base_url(); ?>';
        
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 4;
            let uploadedFiles = {
                'electrical-panel': [],
                'installation-area': [],
                'charger-location': []
            };

            // Clear validation errors on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();
            });

            // Clear charger model validation when selected
            $(document).on('click', '.modern-select-option', function() {
                $('#chargerModelInput').removeClass('is-invalid');
                $('#chargerModelWrapper').next('.invalid-feedback').hide();
            });

            // Duke Rebate Toggle
            $('input[name="dukeRebate"]').on('change', function() {
                if ($(this).val() === 'yes') {
                    $('#dukeRebateQuestions').slideDown(300);
                } else {
                    $('#dukeRebateQuestions').slideUp(300);
                    $('#dukeRebateQuestions input[type="radio"]').prop('checked', false);
                }
            });

            // File Upload Handling with Categories
            $(document).on('click', '.file-upload-area', function(e) {
                // Only trigger if not clicking on a child element that has its own handler
                if ($(e.target).hasClass('file-upload-area') || 
                    $(e.target).closest('.file-upload-icon, .file-upload-text, .file-upload-hint').length > 0) {
                    e.preventDefault();
                    e.stopPropagation();
                    const category = $(this).data('category');
                    const fileInput = $(`.file-input-category[data-category="${category}"]`)[0];
                    if (fileInput) {
                        fileInput.click();
                    }
                }
            });

            $('.file-upload-area').on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            $('.file-upload-area').on('dragleave', function() {
                $(this).removeClass('dragover');
            });

            $('.file-upload-area').on('drop', function(e) {
                e.preventDefault();
                const category = $(this).data('category');
                $(this).removeClass('dragover');
                const files = e.originalEvent.dataTransfer.files;
                handleFiles(files, category);
            });

            $('.file-input-category').on('change', function() {
                const category = $(this).data('category');
                handleFiles(this.files, category);
            });

            function handleFiles(files, category) {
                const fileInput = $(`.file-input-category[data-category="${category}"]`)[0];
                const dataTransfer = new DataTransfer();
                
                // Add existing files from the input
                if (fileInput && fileInput.files) {
                    Array.from(fileInput.files).forEach(file => {
                        dataTransfer.items.add(file);
                    });
                }
                
                // Add existing files from uploadedFiles array
                uploadedFiles[category].forEach(file => {
                    dataTransfer.items.add(file);
                });
                
                Array.from(files).forEach(file => {
                    if (file.size > 10 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: `File ${file.name} is too large. Maximum size is 10MB.`,
                            confirmButtonColor: '#F2A61D'
                        });
                        return;
                    }
                    uploadedFiles[category].push(file);
                    dataTransfer.items.add(file);
                    displayFile(file, category);
                });
                
                // Update the file input with all files
                if (fileInput) {
                    fileInput.files = dataTransfer.files;
                }
            }

            function displayFile(file, category) {
                const fileList = $(`.file-list[data-category="${category}"]`);
                const fileItem = $('<div class="file-item"></div>');
                const fileIcon = getFileIcon(file.name);
                const fileSize = formatFileSize(file.size);

                fileItem.html(`
                    <div class="file-info">
                        <div class="file-icon">${fileIcon}</div>
                        <div class="file-details">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${fileSize}</div>
                        </div>
                    </div>
                    <button type="button" class="file-remove" data-file="${file.name}" data-category="${category}">
                        <i class="bi bi-x"></i>
                    </button>
                `);

                fileList.append(fileItem);

                fileItem.find('.file-remove').on('click', function() {
                    const fileName = $(this).data('file');
                    const fileCategory = $(this).data('category');
                    uploadedFiles[fileCategory] = uploadedFiles[fileCategory].filter(f => f.name !== fileName);
                    fileItem.remove();
                    
                    // Sync with file input
                    const fileInput = $(`.file-input-category[data-category="${fileCategory}"]`)[0];
                    if (fileInput) {
                        const dataTransfer = new DataTransfer();
                        uploadedFiles[fileCategory].forEach(file => {
                            dataTransfer.items.add(file);
                        });
                        fileInput.files = dataTransfer.files;
                    }
                    
                    updateSummary();
                });
            }

            function getFileIcon(fileName) {
                const ext = fileName.split('.').pop().toLowerCase();
                const icons = {
                    'pdf': '<i class="bi bi-file-pdf"></i>',
                    'jpg': '<i class="bi bi-file-image"></i>',
                    'jpeg': '<i class="bi bi-file-image"></i>',
                    'png': '<i class="bi bi-file-image"></i>',
                    'doc': '<i class="bi bi-file-word"></i>',
                    'docx': '<i class="bi bi-file-word"></i>'
                };
                return icons[ext] || '<i class="bi bi-file"></i>';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            // Step Navigation
            function updateProgress() {
                const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
                $('#progressLine').css('width', progress + '%');

                $('.step-item').each(function() {
                    const stepNum = parseInt($(this).data('step'));
                    $(this).removeClass('active completed');
                    if (stepNum < currentStep) {
                        $(this).addClass('completed');
                    } else if (stepNum === currentStep) {
                        $(this).addClass('active');
                    }
                });
            }

            function showStep(step) {
                $('.form-step').removeClass('active');
                $('#step' + step).addClass('active');
                currentStep = step;
                updateProgress();

                // Update buttons
                if (currentStep === 1) {
                    $('#prevBtn').addClass('hidden');
                } else {
                    $('#prevBtn').removeClass('hidden');
                }

                // Only show submit button on final step (step 4)
                if (currentStep === totalSteps) {
                    $('#nextBtn').addClass('hidden');
                    $('#submitBtn').removeClass('hidden');
                    updateSummary();
                } else {
                    $('#nextBtn').removeClass('hidden');
                    $('#submitBtn').addClass('hidden');
                }

                // Load sample images when step 3 is shown
                if (step === 3) {
                    loadSampleImages();
                }
            }

            function loadSampleImages() {
                $.ajax({
                    url: base_url + 'getSampleImages',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.images) {
                            // Update each image based on its category
                            $('.sample-image[data-category="electrical-panel"]').attr('src', response.images.electrical_panel || '');
                            $('.sample-image[data-category="installation-area"]').attr('src', response.images.installation_area || '');
                            $('.sample-image[data-category="charger-location"]').attr('src', response.images.charger_location || '');
                        } else {
                            console.error('Failed to load sample images:', response.message || 'Unknown error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error loading sample images:', error);
                        // Fallback to placeholder images on error
                        $('.sample-image[data-category="electrical-panel"]').attr('src', 'https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=400&h=300&fit=crop&q=80');
                        $('.sample-image[data-category="installation-area"]').attr('src', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop&q=80');
                        $('.sample-image[data-category="charger-location"]').attr('src', 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=400&h=300&fit=crop&q=80');
                    }
                });
            }

            // Image Modal Functionality
            const imageModal = $('#imageModal');
            const modalImage = $('#modalImage');
            const modalClose = $('.image-modal-close');
            const modalBackdrop = $('.image-modal-backdrop');

            // Open modal when sample image is clicked
            $(document).on('click', '.sample-image', function() {
                const imageSrc = $(this).attr('src');
                const imageAlt = $(this).attr('alt');
                
                if (imageSrc && imageSrc.trim() !== '') {
                    modalImage.attr('src', imageSrc);
                    modalImage.attr('alt', imageAlt);
                    imageModal.addClass('active');
                    $('body').css('overflow', 'hidden'); // Prevent background scrolling
                }
            });

            // Close modal functions
            function closeImageModal() {
                imageModal.removeClass('active');
                $('body').css('overflow', ''); // Restore scrolling
            }

            // Close on close button click
            modalClose.on('click', function() {
                closeImageModal();
            });

            // Close on backdrop click
            modalBackdrop.on('click', function() {
                closeImageModal();
            });

            // Close on Escape key press
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && imageModal.hasClass('active')) {
                    closeImageModal();
                }
            });

            // Validation Functions
            function validateStep1() {
                let isValid = true;
                const errors = [];

                // First Name
                const firstName = $('input[name="firstName"]').val().trim();
                if (!firstName) {
                    $('input[name="firstName"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('input[name="firstName"]').removeClass('is-invalid');
                }

                // Last Name
                const lastName = $('input[name="lastName"]').val().trim();
                if (!lastName) {
                    $('input[name="lastName"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('input[name="lastName"]').removeClass('is-invalid');
                }

                // Email
                const email = $('input[name="email"]').val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email) {
                    $('input[name="email"]').addClass('is-invalid');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    $('input[name="email"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('input[name="email"]').removeClass('is-invalid');
                }

                // Phone
                const phone = $('input[name="phone"]').val().trim();
                if (!phone) {
                    $('input[name="phone"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('input[name="phone"]').removeClass('is-invalid');
                }

                // Address
                const address = $('textarea[name="address"]').val().trim();
                if (!address) {
                    $('textarea[name="address"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('textarea[name="address"]').removeClass('is-invalid');
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields correctly.',
                        confirmButtonColor: '#F2A61D'
                    });
                }

                return isValid;
            }

            function validateStep2() {
                let isValid = true;

                // Project Type
                const projectType = $('select[name="projectType"]').val();
                if (!projectType) {
                    $('select[name="projectType"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('select[name="projectType"]').removeClass('is-invalid');
                }

                // Timeline
                const timeline = $('select[name="timeline"]').val();
                if (!timeline) {
                    $('select[name="timeline"]').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('select[name="timeline"]').removeClass('is-invalid');
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields.',
                        confirmButtonColor: '#F2A61D'
                    });
                }

                return isValid;
            }

            function validateStep3() {
                let isValid = true;

                // Charger Model
                const chargerModelId = $('#chargerModelId').val();
                if (!chargerModelId || chargerModelId === '') {
                    $('#chargerModelInput').addClass('is-invalid');
                    $('#chargerModelWrapper').next('.invalid-feedback').show();
                    isValid = false;
                } else {
                    $('#chargerModelInput').removeClass('is-invalid');
                    $('#chargerModelWrapper').next('.invalid-feedback').hide();
                }

                // Duke Rebate
                const dukeRebate = $('input[name="dukeRebate"]:checked').val();
                if (!dukeRebate) {
                    isValid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please select whether you are interested in the Duke rebate program.',
                        confirmButtonColor: '#F2A61D'
                    });
                }

                // If Duke Rebate is Yes, validate additional questions
                if (dukeRebate === 'yes') {
                    const rentingHome = $('input[name="rentingHome"]:checked').val();
                    const dukeCustomer = $('input[name="dukeCustomer"]:checked').val();
                    const evRegistered = $('input[name="evRegistered"]:checked').val();

                    if (!rentingHome || !dukeCustomer || !evRegistered) {
                        isValid = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Please answer all Duke rebate questions.',
                            confirmButtonColor: '#F2A61D'
                        });
                    }
                }

                // File uploads validation
                const totalFiles = uploadedFiles['electrical-panel'].length + 
                                 uploadedFiles['installation-area'].length + 
                                 uploadedFiles['charger-location'].length;

                if (totalFiles === 0) {
                    isValid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Files Required',
                        text: 'Please upload at least one file for the required categories.',
                        confirmButtonColor: '#F2A61D'
                    });
                }

                if (!isValid && chargerModelId) {
                    $('#chargerModelInput').removeClass('is-invalid');
                }

                return isValid;
            }

            $('#nextBtn').on('click', function() {
                let canProceed = false;

                if (currentStep === 1) {
                    canProceed = validateStep1();
                } else if (currentStep === 2) {
                    canProceed = validateStep2();
                } else if (currentStep === 3) {
                    canProceed = validateStep3();
                } else {
                    canProceed = true;
                }

                if (canProceed) {
                    showStep(currentStep + 1);
                }
            });

            $('#prevBtn').on('click', function() {
                showStep(currentStep - 1);
            });


            function updateSummary() {
                const formData = new FormData($('#estimateForm')[0]);
                $('#summaryName').text((formData.get('firstName') || '') + ' ' + (formData.get('lastName') || ''));
                $('#summaryEmail').text(formData.get('email') || '-');
                $('#summaryPhone').text(formData.get('phone') || '-');
                
                const projectType = formData.get('projectType');
                const projectTypes = {
                    'residential': 'Residential',
                    'commercial': 'Commercial',
                    'industrial': 'Industrial',
                    'renovation': 'Renovation',
                    'other': 'Other'
                };
                $('#summaryProjectType').text(projectTypes[projectType] || '-');

                const budget = formData.get('budgetRange');
                const budgets = {
                    'under-10k': 'Under $10,000',
                    '10k-50k': '$10,000 - $50,000',
                    '50k-100k': '$50,000 - $100,000',
                    '100k-500k': '$100,000 - $500,000',
                    'over-500k': 'Over $500,000'
                };
                $('#summaryBudget').text(budgets[budget] || 'Not specified');

                // Add charger model and Duke rebate info
                const chargerModel = formData.get('chargerModel') || '-';
                if (!$('#summaryChargerModel').length) {
                    $('.summary-card').last().after(`
                        <div class="summary-card">
                            <div class="summary-label">Charger Model</div>
                            <div class="summary-value" id="summaryChargerModel">${chargerModel}</div>
                        </div>
                    `);
                } else {
                    $('#summaryChargerModel').text(chargerModel);
                }

                const dukeRebate = $('input[name="dukeRebate"]:checked').val();
                const dukeRebateText = dukeRebate === 'yes' ? 'Yes' : 'No';
                if (!$('#summaryDukeRebate').length) {
                    $('.summary-card').last().after(`
                        <div class="summary-card">
                            <div class="summary-label">Duke Rebate Program</div>
                            <div class="summary-value" id="summaryDukeRebate">${dukeRebateText}</div>
                        </div>
                    `);
                } else {
                    $('#summaryDukeRebate').text(dukeRebateText);
                }

                // Show Duke rebate answers if applicable
                if (dukeRebate === 'yes') {
                    const rentingHome = $('input[name="rentingHome"]:checked').val() || '-';
                    const dukeCustomer = $('input[name="dukeCustomer"]:checked').val() || '-';
                    const evRegistered = $('input[name="evRegistered"]:checked').val() || '-';
                    
                    if (!$('#summaryDukeDetails').length) {
                        $('.summary-card').last().after(`
                            <div class="summary-card" id="summaryDukeDetails">
                                <div class="summary-label">Duke Rebate Details</div>
                                <div class="summary-value">
                                    <div>Renting Home: ${rentingHome === 'yes' ? 'Yes' : rentingHome === 'no' ? 'No' : '-'}</div>
                                    <div>Duke Energy Customer: ${dukeCustomer === 'yes' ? 'Yes' : dukeCustomer === 'no' ? 'No' : '-'}</div>
                                    <div>EV Registered to Home: ${evRegistered === 'yes' ? 'Yes' : evRegistered === 'no' ? 'No' : '-'}</div>
                                </div>
                            </div>
                        `);
                    } else {
                        $('#summaryDukeDetails .summary-value').html(`
                            <div>Renting Home: ${rentingHome === 'yes' ? 'Yes' : rentingHome === 'no' ? 'No' : '-'}</div>
                            <div>Duke Energy Customer: ${dukeCustomer === 'yes' ? 'Yes' : dukeCustomer === 'no' ? 'No' : '-'}</div>
                            <div>EV Registered to Home: ${evRegistered === 'yes' ? 'Yes' : evRegistered === 'no' ? 'No' : '-'}</div>
                        `);
                    }
                } else {
                    $('#summaryDukeDetails').remove();
                }

                // Calculate total files
                const totalFiles = uploadedFiles['electrical-panel'].length + 
                                 uploadedFiles['installation-area'].length + 
                                 uploadedFiles['charger-location'].length;
                
                const filesBreakdown = `Electrical Panel: ${uploadedFiles['electrical-panel'].length}, ` +
                                     `Installation Area: ${uploadedFiles['installation-area'].length}, ` +
                                     `Charger Location: ${uploadedFiles['charger-location'].length}`;
                
                $('#summaryFiles').text(`${totalFiles} file(s) - ${filesBreakdown}`);
            }

            // Generate Ticket Number
            function generateTicketNumber() {
                const timestamp = Date.now().toString(36).toUpperCase();
                const random = Math.random().toString(36).substring(2, 8).toUpperCase();
                return 'EST-' + timestamp + '-' + random;
            }

            // Form Submission
            $('#estimateForm').on('submit', function(e) {
                e.preventDefault();

                // Check if terms are agreed
                if (!$('#agreeTerms').is(':checked')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Terms Required',
                        text: 'Please agree to the terms and conditions to continue.',
                        confirmButtonColor: '#F2A61D'
                    });
                    return;
                }

                // Show loading screen
                $('#loadingScreen').addClass('active');
                $('body').css('overflow', 'hidden');

                // Prepare FormData - files should already be in the file inputs
                const formData = new FormData($('#estimateForm')[0]);

                // Submit via AJAX
                $.ajax({
                    url: base_url + 'submitEstimate',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        // Hide loading screen
                        $('#loadingScreen').removeClass('active');
                        $('body').css('overflow', '');

                        if (response.success) {
                            // Hide form and show success page
                            $('#estimateForm').closest('.form-body').find('form').hide();
                            $('.progress-bar-container').hide();
                            $('.form-header').hide();
                            $('#successPage').addClass('active');
                            
                            // Set ticket number
                            $('#ticketNumber').text(response.estimate_number);
                            
                            // Scroll to top of success page
                            $('html, body').animate({
                                scrollTop: $('.form-container').offset().top - 100
                            }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: response.message || 'Failed to submit estimate. Please try again.',
                                confirmButtonColor: '#F2A61D'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Submission error:', error);
                        // Hide loading screen
                        $('#loadingScreen').removeClass('active');
                        $('body').css('overflow', '');
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while submitting your estimate. Please try again.',
                            confirmButtonColor: '#F2A61D'
                        });
                    }
                });
            });

            // Modern Searchable Select for Charger Models
            let chargerModelSearchTimeout;
            let allChargerModels = [];
            let selectedChargerModel = null;

            const chargerModelInput = $('#chargerModelInput');
            const chargerModelDropdown = $('#chargerModelDropdown');
            const chargerModelWrapper = $('#chargerModelWrapper');
            const chargerModelIdInput = $('#chargerModelId');

            // Load charger models on page load
            function loadChargerModels(search = '') {
                $.ajax({
                    url: base_url + 'getChargerModels',
                    type: 'GET',
                    data: { search: search },
                    dataType: 'json',
                    success: function(response) {

                        console.log(response);
                        if (response.success && response.models) {
                            allChargerModels = response.models;
                            renderChargerModelOptions(response.models, search);
                        }
                    },
                    error: function() {
                        chargerModelDropdown.html('<div class="modern-select-option no-results">Error loading models</div>');
                    }
                });
            }

            function renderChargerModelOptions(models, search = '') {
                chargerModelDropdown.empty();
                
                if (models.length === 0) {
                    if (search.trim() !== '') {
                        chargerModelDropdown.append(`
                            <div class="modern-select-add-new" data-action="add-new" data-model-name="${search}">
                                <i class="bi bi-plus-circle"></i> Add "${search}" as new model
                            </div>
                        `);
                    } else {
                        chargerModelDropdown.append('<div class="modern-select-option no-results">No models found</div>');
                    }
                } else {
                    models.forEach(function(model) {
                        const option = $('<div class="modern-select-option"></div>')
                            .text(model.display_name)
                            .data('model', model);
                        
                        if (selectedChargerModel && selectedChargerModel.id === model.id) {
                            option.addClass('selected');
                        }
                        
                        chargerModelDropdown.append(option);
                    });
                    
                    // Add option to create new if search doesn't match
                    if (search.trim() !== '' && !models.some(m => 
                        m.model_name.toLowerCase() === search.toLowerCase() || 
                        m.display_name.toLowerCase() === search.toLowerCase()
                    )) {
                        chargerModelDropdown.append(`
                            <div class="modern-select-add-new" data-action="add-new" data-model-name="${search}">
                                <i class="bi bi-plus-circle"></i> Add "${search}" as new model
                            </div>
                        `);
                    }
                }
            }

            // Handle input focus
            chargerModelInput.on('focus', function() {
                chargerModelWrapper.addClass('active');
                if (chargerModelDropdown.children().length === 0 || 
                    chargerModelDropdown.find('.no-results').text() === 'Loading models...') {
                    loadChargerModels();
                } else {
                    chargerModelDropdown.addClass('active');
                }
            });

            // Handle input typing
            chargerModelInput.on('input', function() {
                const search = $(this).val();
                chargerModelWrapper.addClass('active');
                
                clearTimeout(chargerModelSearchTimeout);
                chargerModelSearchTimeout = setTimeout(function() {
                    loadChargerModels(search);
                    chargerModelDropdown.addClass('active');
                }, 300);
            });

            // Handle option click
            $(document).on('click', '.modern-select-option', function() {
                const model = $(this).data('model');
                if (model) {
                    selectedChargerModel = model;
                    chargerModelInput.val(model.display_name).addClass('has-value');
                    chargerModelIdInput.val(model.id);
                    chargerModelDropdown.removeClass('active');
                    chargerModelWrapper.removeClass('active');
                    $('.modern-select-option').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            // Handle add new model
            $(document).on('click', '.modern-select-add-new', function() {
                const modelName = $(this).data('model-name');
                
                // Show loading state
                Swal.fire({
                    title: 'Adding Model...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: base_url + 'addChargerModel',
                    type: 'POST',
                    data: {
                        model_name: modelName,
                        brand: ''
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            selectedChargerModel = response.model;
                            chargerModelInput.val(response.model.display_name).addClass('has-value');
                            chargerModelIdInput.val(response.model.id);
                            chargerModelDropdown.removeClass('active');
                            chargerModelWrapper.removeClass('active');
                            
                            // Reload models to include the new one
                            loadChargerModels();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Model Added',
                                text: `"${response.model.display_name}" has been added successfully.`,
                                timer: 2000,
                                showConfirmButton: false,
                                confirmButtonColor: '#F2A61D'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to add model',
                                confirmButtonColor: '#F2A61D'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding charger model. Please try again.',
                            confirmButtonColor: '#F2A61D'
                        });
                    }
                });
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!chargerModelWrapper.is(e.target) && chargerModelWrapper.has(e.target).length === 0) {
                    chargerModelDropdown.removeClass('active');
                    chargerModelWrapper.removeClass('active');
                }
            });

            // Initialize - ensure buttons are in correct state on load
            $('#submitBtn').addClass('hidden');
            $('#nextBtn').removeClass('hidden');
            showStep(1);
            
            // Load initial charger models
            loadChargerModels();
        });
    </script>
</body>
</html>

