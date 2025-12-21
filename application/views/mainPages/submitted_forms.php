<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Forms - Virtual Estimate Form</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #F2A61D;
            --primary-hover: #d4941a;
            --secondary-color: #0D2949;
            --secondary-dark: #0a1f3a;
            --accent-color: #F2A61D;
            --dark-color: #1f2937;
            --light-color: #f8f9fa;
            --white: #ffffff;
            --border-color: #e5e7eb;
            --text-muted: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: var(--dark-color);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        html {
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background: rgba(13, 41, 73, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: var(--shadow-md);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(242, 166, 29, 0.1);
        }

        /* Container */
        .page-container {
            padding: 2rem 1.5rem;
            min-height: calc(100vh - 70px);
            position: relative;
        }

        .page-header {
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title i {
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* Card */
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeInUp 0.6s ease-out 0.2s both;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Search and Filters */
        .search-container {
            margin-bottom: 2rem;
        }

        .search-input {
            border: 2px solid rgba(229, 231, 235, 0.5);
            border-radius: 12px;
            padding: 0.875rem 1.25rem 0.875rem 3rem;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(242, 166, 29, 0.15), var(--shadow-md);
            outline: none;
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .search-input:focus + .search-icon,
        .search-container:has(.search-input:focus) .search-icon {
            color: var(--primary-color);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.5);
            padding: 0.5rem;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.9rem;
            background: transparent;
        }

        .table thead th {
            background: linear-gradient(135deg, rgba(13, 41, 73, 0.05) 0%, rgba(242, 166, 29, 0.05) 100%);
            border-bottom: 2px solid rgba(242, 166, 29, 0.2);
            font-weight: 600;
            color: var(--secondary-color);
            padding: 1rem 0.75rem;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
        }

        .table thead th:hover {
            background: linear-gradient(135deg, rgba(13, 41, 73, 0.1) 0%, rgba(242, 166, 29, 0.1) 100%);
            color: var(--primary-color);
        }

        .table thead th.sortable {
            position: relative;
            padding-right: 2rem;
        }

        .table thead th.sortable::after {
            content: '⇅';
            position: absolute;
            right: 0.75rem;
            opacity: 0.4;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .table thead th.sortable:hover::after {
            opacity: 0.7;
        }

        .table thead th.sort-asc::after {
            content: '↑';
            opacity: 1;
            color: var(--primary-color);
            font-weight: bold;
        }

        .table thead th.sort-desc::after {
            content: '↓';
            opacity: 1;
            color: var(--primary-color);
            font-weight: bold;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            transition: all 0.2s ease;
        }

        .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(242, 166, 29, 0.05) 0%, rgba(242, 166, 29, 0.02) 100%);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .status-pending::before {
            background: #f59e0b;
        }

        .status-reviewed {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .status-reviewed::before {
            background: #3b82f6;
        }

        .status-approved {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-approved::before {
            background: #10b981;
        }

        .status-rejected {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .status-rejected::before {
            background: #ef4444;
        }

        /* Buttons */
        .btn-view {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #b8860b 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(242, 166, 29, 0.4);
            color: white;
        }

        .btn-view:active {
            transform: translateY(0);
        }

        /* Pagination */
        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(229, 231, 235, 0.5);
        }

        .pagination-info {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .pagination {
            margin: 0;
            gap: 0.5rem;
            display: flex;
        }

        .page-link {
            color: var(--secondary-color);
            border: 1px solid rgba(229, 231, 235, 0.5);
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.8);
        }

        .page-link:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border-color: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .page-item.disabled .page-link {
            color: #cbd5e0;
            pointer-events: none;
            opacity: 0.5;
        }

        /* Modal */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-dark) 100%);
            color: white;
            border-bottom: none;
            padding: 1.5rem 2rem;
            position: relative;
        }

        .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color) 0%, transparent 100%);
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: var(--light-color);
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .detail-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(248, 249, 250, 0.5);
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .detail-section:hover {
            background: rgba(248, 249, 250, 0.8);
            transform: translateX(4px);
        }

        .detail-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(242, 166, 29, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-section-title::before {
            content: '';
            width: 4px;
            height: 16px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border-radius: 2px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 1.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            padding: 0.5rem 0;
            transition: all 0.2s ease;
        }

        .detail-row:hover {
            background: rgba(255, 255, 255, 0.5);
            padding-left: 0.5rem;
            border-radius: 6px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .detail-value {
            color: var(--dark-color);
            font-weight: 500;
        }

        /* Attachments */
        .attachments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .attachment-card {
            border: 2px solid rgba(229, 231, 235, 0.5);
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .attachment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color) 0%, transparent 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .attachment-card:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px) scale(1.02);
        }

        .attachment-card:hover::before {
            transform: scaleX(1);
        }

        .attachment-preview {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .attachment-card:hover .attachment-preview {
            box-shadow: var(--shadow-md);
        }

        .attachment-name {
            font-size: 0.8rem;
            color: var(--dark-color);
            word-break: break-word;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .attachment-size {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .loading-spinner {
            display: inline-block;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(242, 166, 29, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.4;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0;
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-container {
                padding: 1rem;
            }

            .content-card {
                padding: 1.25rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .pagination-container {
                flex-direction: column;
                align-items: stretch;
            }

            .table-container {
                padding: 0.25rem;
            }

            .table thead th {
                font-size: 0.7rem;
                padding: 0.75rem 0.5rem;
            }

            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url('assets/img/logo.webp'); ?>" alt="Virtual Estimator Logo" class="logo-img" onerror="this.style.display='none';">
                <span>Virtual Estimator</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('submitted-forms'); ?>">
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
                            <span class="user-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color) 0%, #d4941a 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem;">A</span>
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

    <!-- Page Container -->
    <div class="page-container">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="bi bi-file-earmark-text"></i> Submitted Forms
                </h1>
                <p class="page-subtitle">View and manage all submitted estimates</p>
            </div>

            <!-- Content Card -->
            <div class="content-card">
                <!-- Search -->
                <div class="search-container">
                    <div class="position-relative">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Search by estimate number, name, email, phone, company, project type, status...">
                    </div>
                </div>

                <!-- Table -->
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="estimate_number">Estimate #</th>
                                <th class="sortable" data-sort="first_name">Name</th>
                                <th class="sortable" data-sort="email">Email</th>
                                <th>Phone</th>
                                <th class="sortable" data-sort="company">Company</th>
                                <th class="sortable" data-sort="project_type">Project Type</th>
                                <th>Charger Model</th>
                                <th class="sortable" data-sort="status">Status</th>
                                <th class="sortable" data-sort="created_at">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="estimatesTableBody">
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="loading-spinner"></div> Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">
                        Showing 0 - 0 of 0 records
                    </div>
                    <nav>
                        <ul class="pagination" id="pagination">
                            <!-- Pagination will be generated by JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Estimate Details Modal -->
    <div class="modal fade" id="estimateModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-text"></i> Estimate Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="estimateModalBody">
                    <div class="text-center">
                        <div class="loading-spinner"></div> Loading...
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
            let currentPage = 1;
            let currentLimit = 10;
            let currentSearch = '';
            let currentSortBy = 'created_at';
            let currentSortOrder = 'DESC';
            let totalPages = 1;

            // Initialize
            loadEstimates();

            // Search functionality
            let searchTimeout;
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    currentSearch = $('#searchInput').val().trim();
                    currentPage = 1;
                    loadEstimates();
                }, 500);
            });

            // Sort functionality
            $('.sortable').on('click', function() {
                const sortBy = $(this).data('sort');
                
                // Update sort order
                if (currentSortBy === sortBy) {
                    currentSortOrder = currentSortOrder === 'ASC' ? 'DESC' : 'ASC';
                } else {
                    currentSortBy = sortBy;
                    currentSortOrder = 'ASC';
                }
                
                // Update UI
                $('.sortable').removeClass('sort-asc sort-desc');
                $(this).addClass('sort-' + currentSortOrder.toLowerCase());
                
                loadEstimates();
            });

            // Load estimates
            function loadEstimates() {
                const tbody = $('#estimatesTableBody');
                tbody.html('<tr><td colspan="10" class="text-center"><div class="loading-spinner"></div> Loading...</td></tr>');

                $.ajax({
                    url: '<?php echo base_url("getEstimates"); ?>',
                    type: 'GET',
                    data: {
                        page: currentPage,
                        limit: currentLimit,
                        search: currentSearch,
                        sort_by: currentSortBy,
                        sort_order: currentSortOrder
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            displayEstimates(response.data);
                            updatePagination(response.pagination);
                        } else {
                            tbody.html('<tr><td colspan="10" class="text-center text-danger">Error loading data</td></tr>');
                        }
                    },
                    error: function() {
                        tbody.html('<tr><td colspan="10" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                    }
                });
            }

            // Display estimates
            function displayEstimates(estimates) {
                const tbody = $('#estimatesTableBody');
                
                if (estimates.length === 0) {
                    tbody.html('<tr><td colspan="10"><div class="empty-state"><i class="bi bi-inbox"></i><p>No estimates found</p></div></td></tr>');
                    return;
                }

                let html = '';
                estimates.forEach(function(estimate, index) {
                    const statusClass = 'status-' + estimate.status.toLowerCase();
                    html += '<tr style="animation: fadeInRow 0.4s ease-out ' + (index * 0.05) + 's both;">';
                    html += '<td><strong style="color: var(--secondary-color);">' + escapeHtml(estimate.estimate_number) + '</strong></td>';
                    html += '<td>' + escapeHtml(estimate.name) + '</td>';
                    html += '<td><a href="mailto:' + escapeHtml(estimate.email) + '" style="color: var(--primary-color); text-decoration: none;">' + escapeHtml(estimate.email) + '</a></td>';
                    html += '<td><a href="tel:' + escapeHtml(estimate.phone) + '" style="color: var(--secondary-color); text-decoration: none;">' + escapeHtml(estimate.phone) + '</a></td>';
                    html += '<td>' + escapeHtml(estimate.company) + '</td>';
                    html += '<td>' + escapeHtml(estimate.project_type) + '</td>';
                    html += '<td>' + escapeHtml(estimate.charger_model) + '</td>';
                    html += '<td><span class="status-badge ' + statusClass + '">' + escapeHtml(estimate.status) + '</span></td>';
                    html += '<td style="color: var(--text-muted);">' + escapeHtml(estimate.created_at_formatted) + '</td>';
                    html += '<td><button class="btn btn-view btn-sm" onclick="viewEstimate(' + estimate.id + ')"><i class="bi bi-eye"></i> View</button></td>';
                    html += '</tr>';
                });
                
                tbody.html(html);
            }

            // Update pagination
            function updatePagination(pagination) {
                totalPages = pagination.total_pages;
                const info = $('#paginationInfo');
                const start = ((pagination.current_page - 1) * pagination.per_page) + 1;
                const end = Math.min(start + pagination.per_page - 1, pagination.total_records);
                
                info.text(`Showing ${start} - ${end} of ${pagination.total_records} records`);

                let paginationHtml = '';
                
                // Previous button
                paginationHtml += '<li class="page-item ' + (pagination.current_page === 1 ? 'disabled' : '') + '">';
                paginationHtml += '<a class="page-link" href="#" onclick="changePage(' + (pagination.current_page - 1) + '); return false;">Previous</a>';
                paginationHtml += '</li>';

                // Page numbers
                const maxPages = 5;
                let startPage = Math.max(1, pagination.current_page - Math.floor(maxPages / 2));
                let endPage = Math.min(pagination.total_pages, startPage + maxPages - 1);
                
                if (endPage - startPage < maxPages - 1) {
                    startPage = Math.max(1, endPage - maxPages + 1);
                }

                if (startPage > 1) {
                    paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="changePage(1); return false;">1</a></li>';
                    if (startPage > 2) {
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += '<li class="page-item ' + (i === pagination.current_page ? 'active' : '') + '">';
                    paginationHtml += '<a class="page-link" href="#" onclick="changePage(' + i + '); return false;">' + i + '</a>';
                    paginationHtml += '</li>';
                }

                if (endPage < pagination.total_pages) {
                    if (endPage < pagination.total_pages - 1) {
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="changePage(' + pagination.total_pages + '); return false;">' + pagination.total_pages + '</a></li>';
                }

                // Next button
                paginationHtml += '<li class="page-item ' + (pagination.current_page === pagination.total_pages ? 'disabled' : '') + '">';
                paginationHtml += '<a class="page-link" href="#" onclick="changePage(' + (pagination.current_page + 1) + '); return false;">Next</a>';
                paginationHtml += '</li>';

                $('#pagination').html(paginationHtml);
            }

            // Change page
            window.changePage = function(page) {
                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    loadEstimates();
                    $('html, body').animate({ scrollTop: 0 }, 300);
                }
            };

            // View estimate details
            window.viewEstimate = function(estimateId) {
                const modal = new bootstrap.Modal(document.getElementById('estimateModal'));
                const modalBody = $('#estimateModalBody');
                
                modalBody.html('<div class="text-center"><div class="loading-spinner"></div> Loading...</div>');
                modal.show();

                $.ajax({
                    url: '<?php echo base_url("getEstimateDetails"); ?>',
                    type: 'GET',
                    data: { id: estimateId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            displayEstimateDetails(response.data);
                        } else {
                            modalBody.html('<div class="alert alert-danger">' + (response.message || 'Error loading estimate details') + '</div>');
                        }
                    },
                    error: function() {
                        modalBody.html('<div class="alert alert-danger">Error loading estimate details. Please try again.</div>');
                    }
                });
            };

            // Display estimate details
            function displayEstimateDetails(estimate) {
                let html = '';

                // Basic Information
                html += '<div class="detail-section">';
                html += '<div class="detail-section-title">Basic Information</div>';
                html += '<div class="detail-row"><div class="detail-label">Estimate Number:</div><div class="detail-value"><strong>' + escapeHtml(estimate.estimate_number) + '</strong></div></div>';
                html += '<div class="detail-row"><div class="detail-label">Status:</div><div class="detail-value"><span class="status-badge status-' + estimate.status.toLowerCase() + '">' + escapeHtml(estimate.status) + '</span></div></div>';
                html += '<div class="detail-row"><div class="detail-label">Date Submitted:</div><div class="detail-value">' + escapeHtml(estimate.created_at_formatted) + '</div></div>';
                html += '</div>';

                // Contact Information
                html += '<div class="detail-section">';
                html += '<div class="detail-section-title">Contact Information</div>';
                html += '<div class="detail-row"><div class="detail-label">Name:</div><div class="detail-value">' + escapeHtml(estimate.first_name + ' ' + estimate.last_name) + '</div></div>';
                html += '<div class="detail-row"><div class="detail-label">Email:</div><div class="detail-value">' + escapeHtml(estimate.email) + '</div></div>';
                html += '<div class="detail-row"><div class="detail-label">Phone:</div><div class="detail-value">' + escapeHtml(estimate.phone) + '</div></div>';
                if (estimate.company) {
                    html += '<div class="detail-row"><div class="detail-label">Company:</div><div class="detail-value">' + escapeHtml(estimate.company) + '</div></div>';
                }
                html += '<div class="detail-row"><div class="detail-label">Address:</div><div class="detail-value">' + escapeHtml(estimate.address) + '</div></div>';
                html += '</div>';

                // Project Information
                html += '<div class="detail-section">';
                html += '<div class="detail-section-title">Project Information</div>';
                html += '<div class="detail-row"><div class="detail-label">Project Type:</div><div class="detail-value">' + escapeHtml(estimate.project_type) + '</div></div>';
                if (estimate.charger_model_name) {
                    html += '<div class="detail-row"><div class="detail-label">Charger Model:</div><div class="detail-value">' + escapeHtml(estimate.charger_model_name) + '</div></div>';
                }
                if (estimate.project_description) {
                    html += '<div class="detail-row"><div class="detail-label">Description:</div><div class="detail-value">' + escapeHtml(estimate.project_description) + '</div></div>';
                }
                if (estimate.timeline) {
                    html += '<div class="detail-row"><div class="detail-label">Timeline:</div><div class="detail-value">' + escapeHtml(estimate.timeline) + '</div></div>';
                }
                if (estimate.additional_requirements) {
                    html += '<div class="detail-row"><div class="detail-label">Additional Requirements:</div><div class="detail-value">' + escapeHtml(estimate.additional_requirements) + '</div></div>';
                }
                html += '</div>';

                // Duke Energy Information
                html += '<div class="detail-section">';
                html += '<div class="detail-section-title">Duke Energy Information</div>';
                html += '<div class="detail-row"><div class="detail-label">Duke Rebate:</div><div class="detail-value">' + (estimate.duke_rebate === 'yes' ? 'Yes' : 'No') + '</div></div>';
                html += '<div class="detail-row"><div class="detail-label">Renting Home:</div><div class="detail-value">' + (estimate.renting_home === 'yes' ? 'Yes' : 'No') + '</div></div>';
                html += '<div class="detail-row"><div class="detail-label">Duke Customer:</div><div class="detail-value">' + (estimate.duke_customer === 'yes' ? 'Yes' : 'No') + '</div></div>';
                html += '<div class="detail-row"><div class="detail-label">EV Registered:</div><div class="detail-value">' + (estimate.ev_registered === 'yes' ? 'Yes' : 'No') + '</div></div>';
                html += '</div>';

                // Attachments
                const hasAttachments = estimate.attachments['electrical-panel'].length > 0 || 
                                     estimate.attachments['installation-area'].length > 0 || 
                                     estimate.attachments['charger-location'].length > 0;

                if (hasAttachments) {
                    html += '<div class="detail-section">';
                    html += '<div class="detail-section-title">Attachments</div>';
                    
                    const categories = {
                        'electrical-panel': 'Electrical Panel',
                        'installation-area': 'Installation Area',
                        'charger-location': 'Charger Location'
                    };

                    Object.keys(categories).forEach(function(category) {
                        if (estimate.attachments[category].length > 0) {
                            html += '<div style="margin-bottom: 1.5rem;">';
                            html += '<strong style="display: block; margin-bottom: 0.75rem; color: var(--secondary-color);">' + categories[category] + '</strong>';
                            html += '<div class="attachments-grid">';
                            
                            estimate.attachments[category].forEach(function(attachment) {
                                const isImage = attachment.file_type && attachment.file_type.startsWith('image/');
                                html += '<div class="attachment-card">';
                                if (isImage) {
                                    html += '<img src="' + escapeHtml(attachment.file_path) + '" alt="' + escapeHtml(attachment.file_name) + '" class="attachment-preview" onerror="this.src=\'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage%3C/text%3E%3C/svg%3E\'">';
                                } else {
                                    html += '<div style="width: 100%; height: 150px; background: var(--light-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;"><i class="bi bi-file-earmark" style="font-size: 3rem; color: #718096;"></i></div>';
                                }
                                html += '<div class="attachment-name">' + escapeHtml(attachment.file_name) + '</div>';
                                html += '<div class="attachment-size">' + formatFileSize(attachment.file_size) + '</div>';
                                html += '<a href="' + escapeHtml(attachment.file_path) + '" target="_blank" class="btn btn-sm btn-outline-primary mt-2" style="font-size: 0.7rem;"><i class="bi bi-download"></i> Download</a>';
                                html += '</div>';
                            });
                            
                            html += '</div></div>';
                        }
                    });
                    
                    html += '</div>';
                } else {
                    html += '<div class="detail-section">';
                    html += '<div class="detail-section-title">Attachments</div>';
                    html += '<div class="text-muted">No attachments uploaded</div>';
                    html += '</div>';
                }

                $('#estimateModalBody').html(html);
            }

            // Utility functions
            function escapeHtml(text) {
                if (!text) return '';
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
            }

            function formatFileSize(bytes) {
                if (!bytes || bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }
        });
    </script>
</body>
</html>

