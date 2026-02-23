<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite Links - Virtual Estimate Form</title>
    
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

        /* Action Buttons */
        .action-buttons {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-create {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-create:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #b8860b 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(242, 166, 29, 0.4);
            color: white;
        }

        .btn-create:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-create:disabled:hover {
            transform: none;
            box-shadow: var(--shadow-md);
        }

        .btn-loading {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(242, 166, 29, 0.05) 0%, rgba(242, 166, 29, 0.02) 100%);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
        }

        .status-active {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-used {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .status-expired {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #4b5563;
        }

        /* Link Display */
        .invite-link {
            font-family: 'Courier New', monospace;
            background: rgba(248, 249, 250, 0.8);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(229, 231, 235, 0.5);
            font-size: 0.85rem;
            word-break: break-all;
            display: inline-block;
            max-width: 100%;
        }

        .btn-copy {
            background: var(--info);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-copy:hover {
            background: #2563eb;
            transform: translateY(-1px);
            color: white;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
            color: white;
        }

        /* Modal */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-dark) 100%);
            color: white;
            border-bottom: none;
            padding: 1.5rem 2rem;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid rgba(229, 231, 235, 0.5);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(242, 166, 29, 0.15);
            outline: none;
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
                        <a class="nav-link" href="<?php echo base_url('submitted-forms'); ?>">
                            <i class="bi bi-file-earmark-text"></i> Submitted Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('invite-links'); ?>">
                            <i class="bi bi-link-45deg"></i> Invite Links
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
                    <i class="bi bi-link-45deg"></i> Invite Links
                </h1>
                <p class="page-subtitle">Create and manage one-time access links for the estimate form</p>
            </div>

            <!-- Content Card -->
            <div class="content-card">
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="button" class="btn btn-create" onclick="openCreateModal()">
                        <i class="bi bi-plus-circle"></i> Create New Invite Link
                    </button>
                </div>

                <!-- Table -->
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Invite Link</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Used At</th>
                                <th>Expires At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inviteLinksTableBody">
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="loading-spinner"></div> Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Invite Link Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i> Create New Invite Link
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createInviteForm">
                        <div class="mb-3">
                            <label for="expiresAt" class="form-label">Expiration Date (Optional)</label>
                            <input type="datetime-local" class="form-control" id="expiresAt" name="expires_at">
                            <small class="text-muted">Leave empty for no expiration</small>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" id="cancelBtn" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-create" id="submitBtn">
                                <span class="btn-text"><i class="bi bi-plus-circle"></i> Create Link</span>
                                <span class="btn-loading" style="display: none;">
                                    <span class="loading-spinner" style="width: 16px; height: 16px; border-width: 2px; display: inline-block; margin-right: 8px;"></span>
                                    Creating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            loadInviteLinks();

            // Create invite link form
            $('#createInviteForm').on('submit', function(e) {
                e.preventDefault();
                createInviteLink();
            });
        });

        function loadInviteLinks() {
            const tbody = $('#inviteLinksTableBody');
            tbody.html('<tr><td colspan="8" class="text-center"><div class="loading-spinner"></div> Loading...</td></tr>');

            $.ajax({
                url: '<?php echo base_url("getInviteLinks"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayInviteLinks(response.data);
                    } else {
                        tbody.html('<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>');
                    }
                },
                error: function() {
                    tbody.html('<tr><td colspan="8" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        function displayInviteLinks(links) {
            const tbody = $('#inviteLinksTableBody');
            
            if (links.length === 0) {
                tbody.html('<tr><td colspan="8"><div class="empty-state"><i class="bi bi-inbox"></i><p>No invite links found. Create your first one!</p></div></td></tr>');
                return;
            }

            let html = '';
            links.forEach(function(link) {
                const fullUrl = '<?php echo base_url("forms?token="); ?>' + link.token;
                const baseUrl = '<?php echo base_url(); ?>';
                const displayUrl = baseUrl + 'forms?token=' + link.token;
                
                // Determine status - use server-calculated status if available, otherwise calculate client-side
                let statusClass = 'status-active';
                let statusText = 'Active';
                
                if (link.status) {
                    // Use server-calculated status (most accurate)
                    switch(link.status) {
                        case 'used':
                            statusClass = 'status-used';
                            statusText = 'Used';
                            break;
                        case 'expired':
                            statusClass = 'status-expired';
                            statusText = 'Expired';
                            break;
                        case 'active':
                        default:
                            statusClass = 'status-active';
                            statusText = 'Active';
                            break;
                    }
                } else {
                    // Fallback: calculate client-side if server status not available
                    const isUsed = link.is_used === true || link.is_used === 1 || link.is_used === '1';
                    
                    if (isUsed) {
                        statusClass = 'status-used';
                        statusText = 'Used';
                    } else if (link.expires_at) {
                        // Check if expired (only if not used)
                        const expiresAt = new Date(link.expires_at);
                        const now = new Date();
                        
                        if (expiresAt < now) {
                            statusClass = 'status-expired';
                            statusText = 'Expired';
                        } else {
                            statusClass = 'status-active';
                            statusText = 'Active';
                        }
                    } else {
                        statusClass = 'status-active';
                        statusText = 'Active';
                    }
                }

                html += '<tr>';
                html += '<td><code style="font-size: 0.8rem;">' + escapeHtml(link.token.substring(0, 20) + '...') + '</code></td>';
                html += '<td><div class="invite-link">' + escapeHtml(displayUrl) + '</div></td>';
                html += '<td><span class="status-badge ' + statusClass + '">' + statusText + '</span></td>';
                html += '<td>' + escapeHtml(link.created_by_name || 'N/A') + '</td>';
                html += '<td>' + escapeHtml(link.created_at_formatted) + '</td>';
                html += '<td>' + (link.used_at_formatted ? escapeHtml(link.used_at_formatted) : '-') + '</td>';
                html += '<td>' + (link.expires_at_formatted ? escapeHtml(link.expires_at_formatted) : 'Never') + '</td>';
                html += '<td>';
                html += '<button class="btn btn-copy btn-sm me-1" onclick="copyLink(\'' + escapeHtml(fullUrl) + '\')" title="Copy Link"><i class="bi bi-clipboard"></i></button>';
                if (!link.is_used) {
                    html += '<button class="btn btn-delete btn-sm" onclick="deleteLink(' + link.id + ')" title="Delete"><i class="bi bi-trash"></i></button>';
                }
                html += '</td>';
                html += '</tr>';
            });
            
            tbody.html(html);
        }

        function openCreateModal() {
            const modal = new bootstrap.Modal(document.getElementById('createModal'));
            $('#createInviteForm')[0].reset();
            
            // Set default expiration date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            // Format for datetime-local input (YYYY-MM-DDTHH:mm)
            const year = tomorrow.getFullYear();
            const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
            const day = String(tomorrow.getDate()).padStart(2, '0');
            const hours = String(tomorrow.getHours()).padStart(2, '0');
            const minutes = String(tomorrow.getMinutes()).padStart(2, '0');
            
            const defaultDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            $('#expiresAt').val(defaultDate);
            
            // Reset button state when opening modal
            const submitBtn = $('#submitBtn');
            const cancelBtn = $('#cancelBtn');
            const btnText = submitBtn.find('.btn-text');
            const btnLoading = submitBtn.find('.btn-loading');
            
            submitBtn.prop('disabled', false);
            cancelBtn.prop('disabled', false);
            btnText.show();
            btnLoading.hide();
            
            modal.show();
        }

        function createInviteLink() {
            const expiresAt = $('#expiresAt').val();
            const submitBtn = $('#submitBtn');
            const cancelBtn = $('#cancelBtn');
            const btnText = submitBtn.find('.btn-text');
            const btnLoading = submitBtn.find('.btn-loading');
            
            // Show loading state
            submitBtn.prop('disabled', true);
            cancelBtn.prop('disabled', true);
            btnText.hide();
            btnLoading.show();
            
            $.ajax({
                url: '<?php echo base_url("createInviteLink"); ?>',
                type: 'POST',
                data: {
                    expires_at: expiresAt || null
                },
                dataType: 'json',
                success: function(response) {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    cancelBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Invite link created successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#createModal').modal('hide');
                        loadInviteLinks();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to create invite link'
                        });
                    }
                },
                error: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    cancelBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.'
                    });
                }
            });
        }

        function copyLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Invite link copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, function() {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Invite link copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        function deleteLink(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url("deleteInviteLink"); ?>',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'Invite link deleted successfully',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                loadInviteLinks();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to delete invite link'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.'
                            });
                        }
                    });
                }
            });
        }

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
    </script>
</body>
</html>
