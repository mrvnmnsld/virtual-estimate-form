<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Virtual Estimate Form</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --primary-color: #F2A61D;
            --secondary-color: #0D2949;
            --accent-color: #F2A61D;
            --dark-color: #1f2937;
            --light-color: #f8f9fa;
            --white: #ffffff;
            --border-color: #e5e7eb;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 20px 60px rgba(13, 41, 73, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            color: var(--dark-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #0a1f3a 100%) !important;
            box-shadow: var(--shadow-sm);
            padding: 0.75rem 0;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1000;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-lg);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
        }

        .navbar-brand img {
            height: 36px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: rotate(5deg);
        }

        .navbar-brand img[src=""],
        .navbar-brand img:not([src]) {
            display: none;
        }

        .navbar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
            border-radius: 10px;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(242, 166, 29, 0.3);
        }

        .navbar-brand .logo-icon[style*="display: flex"],
        .navbar-brand .logo-icon[style*="display:flex"] {
            display: flex !important;
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.4rem 0.75rem !important;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            width: 80%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(242, 166, 29, 0.1);
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            border-color: var(--primary-color);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            animation: fadeInDown 0.3s ease;
            z-index: 1050;
            position: absolute;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            margin: 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
            color: white;
            transform: translateX(5px);
        }

        /* Dashboard Container */
        .dashboard-container {
            padding: 1.5rem 1.5rem;
            min-height: calc(100vh - 70px);
            animation: fadeIn 0.6s ease;
            overflow: visible;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .dashboard-header {
            margin-bottom: 1.5rem;
            animation: slideInDown 0.8s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.25rem;
            display: inline-block;
        }

        .dashboard-subtitle {
            color: #718096;
            font-size: 0.875rem;
            font-weight: 400;
        }

        /* Chart Card */
        .chart-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease 0.2s both;
            transition: all 0.3s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .chart-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--light-color);
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-title i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .chart-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(242, 166, 29, 0.2);
            transition: all 0.3s ease;
        }

        .chart-card:hover .chart-icon {
            transform: rotate(5deg) scale(1.05);
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.6s ease both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(242, 166, 29, 0.03) 0%, rgba(13, 41, 73, 0.03) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            margin-bottom: 0.75rem;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover .stat-icon {
            transform: rotate(-3deg) scale(1.05);
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
        }

        .stat-icon.secondary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #1a3d6b 100%);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .stat-label {
            color: #718096;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .dashboard-title {
                font-size: 1.25rem;
            }

            .chart-container {
                height: 250px;
            }

            .chart-card {
                padding: 1rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }

        /* User Dropdown */
        .nav-item.dropdown .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 8px rgba(242, 166, 29, 0.2);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .nav-link:hover .user-avatar {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(242, 166, 29, 0.4);
        }

        .nav-item.dropdown .nav-link::after {
            margin-left: auto;
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Smooth Number Counter Animation */
        .stat-value.animate {
            animation: countUp 1.5s ease-out;
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Gradient Background Effect */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(242, 166, 29, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(13, 41, 73, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-container {
            position: relative;
            z-index: 1;
        }

        /* Ensure dropdown is clickable */
        .navbar .dropdown {
            position: static;
        }

        .navbar .dropdown-menu {
            z-index: 1050 !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url('assets/img/logo.webp'); ?>" alt="Virtual Estimator Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="logo-icon" style="display: none;">VE</div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('dashboard'); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('submitted-forms'); ?>">
                            <i class="bi bi-file-earmark-text"></i> Submitted Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('forms'); ?>">
                            <i class="bi bi-file-plus"></i> Forms
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="user-avatar">A</span>
                            <span class="ms-2">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('main/logout'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <div class="container-fluid">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">
                    <i class="bi bi-speedometer2"></i> Admin Dashboard
                </h1>
                <p class="dashboard-subtitle">Welcome back! Here's an overview of your system.</p>
            </div>

            <!-- Stats Cards Row -->
            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="stat-value">1,234</div>
                        <div class="stat-label">Total Estimates</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon secondary">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-value">856</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-value">378</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon secondary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="stat-value">$45.2K</div>
                        <div class="stat-label">Total Value</div>
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="row">
                <div class="col-12">
                    <div class="chart-card">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">
                                    <i class="bi bi-graph-up"></i> Estimates Overview
                                </h3>
                            </div>
                            <div class="chart-icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="dashboardChart"></canvas>
                        </div>
                    </div>
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
            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('scrolled');
                } else {
                    $('.navbar').removeClass('scrolled');
                }
            });

            // Animated Counter Function
            function animateCounter(element, target, duration = 2000) {
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;
                
                const timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        element.textContent = formatNumber(target);
                        clearInterval(timer);
                    } else {
                        element.textContent = formatNumber(Math.floor(current));
                    }
                }, 16);
            }

            // Format number with commas
            function formatNumber(num) {
                if (num >= 1000) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                return num.toString();
            }

            // Format currency
            function formatCurrency(num) {
                if (num >= 1000) {
                    return '$' + (num / 1000).toFixed(1) + 'K';
                }
                return '$' + num.toString();
            }

            // Animate stat counters when they come into view
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const statValue = entry.target.querySelector('.stat-value');
                        if (statValue && !statValue.classList.contains('animated')) {
                            statValue.classList.add('animated', 'animate');
                            const text = statValue.textContent.trim();
                            
                            // Check if it's currency
                            if (text.includes('$')) {
                                const num = parseFloat(text.replace(/[$,K]/g, '')) * 1000;
                                statValue.textContent = '$0';
                                setTimeout(() => {
                                    let current = 0;
                                    const increment = num / 60;
                                    const timer = setInterval(() => {
                                        current += increment;
                                        if (current >= num) {
                                            statValue.textContent = formatCurrency(num);
                                            clearInterval(timer);
                                        } else {
                                            statValue.textContent = formatCurrency(Math.floor(current));
                                        }
                                    }, 16);
                                }, 200);
                            } else {
                                // Regular number
                                const num = parseInt(text.replace(/,/g, ''));
                                statValue.textContent = '0';
                                setTimeout(() => {
                                    animateCounter(statValue, num);
                                }, 200);
                            }
                        }
                    }
                });
            }, observerOptions);

            // Observe all stat cards
            document.querySelectorAll('.stat-card').forEach(card => {
                observer.observe(card);
            });

            // Chart.js Configuration
            const ctx = document.getElementById('dashboardChart').getContext('2d');
            
            // Company colors
            const primaryColor = '#F2A61D';
            const secondaryColor = '#0D2949';
            const lightPrimary = 'rgba(242, 166, 29, 0.15)';
            const lightSecondary = 'rgba(13, 41, 73, 0.15)';

            // Sample data - Replace with actual data from your backend
            const chartData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Estimates Created',
                        data: [65, 78, 90, 81, 95, 105, 120, 115, 130, 125, 140, 150],
                        backgroundColor: lightPrimary,
                        borderColor: primaryColor,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.5,
                        pointBackgroundColor: primaryColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: primaryColor,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    },
                    {
                        label: 'Estimates Completed',
                        data: [50, 65, 75, 70, 85, 90, 100, 95, 110, 105, 120, 130],
                        backgroundColor: lightSecondary,
                        borderColor: secondaryColor,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.5,
                        pointBackgroundColor: secondaryColor,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: secondaryColor,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }
                ]
            };

            // Chart configuration
            const chartConfig = {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                                labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    family: "'Roboto', 'Open Sans', sans-serif",
                                    size: 12,
                                    weight: 500
                                },
                                color: '#1f2937',
                                boxWidth: 10,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            padding: 12,
                            titleFont: {
                                family: "'Roboto', 'Open Sans', sans-serif",
                                size: 13,
                                weight: 600
                            },
                            bodyFont: {
                                family: "'Roboto', 'Open Sans', sans-serif",
                                size: 12,
                                weight: 500
                            },
                            borderColor: primaryColor,
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                font: {
                                    family: "'Roboto', 'Open Sans', sans-serif",
                                    size: 11,
                                    weight: 500
                                },
                                color: '#718096',
                                padding: 6
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: "'Roboto', 'Open Sans', sans-serif",
                                    size: 11,
                                    weight: 500
                                },
                                color: '#718096',
                                padding: 6
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === 'data' && context.mode === 'default') {
                                delay = context.dataIndex * 50;
                            }
                            return delay;
                        }
                    },
                    onHover: (event, activeElements) => {
                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                    }
                }
            };

            // Create and render chart with delay for smooth entrance
            setTimeout(() => {
                const dashboardChart = new Chart(ctx, chartConfig);
                
                // Update chart on window resize
                $(window).resize(function() {
                    dashboardChart.resize();
                });
            }, 500);

            // Add smooth scroll to top on page load
            $('html, body').animate({ scrollTop: 0 }, 0);

        });
    </script>
</body>
</html>

