<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        
        // Check session for all methods EXCEPT those in the exclusion list
        $current_method = $this->router->method;
        $excluded_methods = [
            'checkLoginCredentials', 'index', 'admin', 'forms', 'logout', 'testEmail', 'info', 'setupAdmin',
            'getSampleImages', 'getChargerModels', 'addChargerModel', 'submitEstimate', 'getEstimates', 'getEstimateDetails'
        ]; // Add method names here to exclude from session check
        
        if (!in_array($current_method, $excluded_methods)) {
            $this->_checkSession(true);
        }
    }

    /**
     * Default index page
     */
    public function index()
    {
        // Redirect to admin/login page or show landing page
        // redirect(base_url('admin'));
        $this->load->view('main');
    }

    /**
     * Admin/Login page
     */
    public function admin()
    {
        if (!isset($_SESSION["currentUser"]) || empty($_SESSION["currentUser"])) {
            // User is not logged in, show login page
            // You can create a login view later
            $this->load->view('login');
        } else {
            // User is logged in, redirect to dashboard
            redirect(base_url('dashboard'));
        }
    }

    /**
     * Dashboard page
     */
    public function dashboard()
    {
        // Check if user is logged in
        if (!isset($_SESSION["currentUser"]) || empty($_SESSION["currentUser"])) {
            // User is not logged in, redirect to login
            redirect(base_url('admin'));
        } else {
            // User is logged in, show dashboard
            $data['title'] = 'Dashboard';
            $data['user'] = $_SESSION["currentUser"];
            $this->load->view('mainPages/dashboard', $data);
        }
    }

    /**
     * Logout function
     */
    public function logout()
    {
        $this->session->sess_destroy();
        session_destroy();
        redirect(base_url('admin'));
    }

    /**
     * Check login credentials (AJAX endpoint)
     */
    public function checkLoginCredentials()
    {
        header('Content-Type: application/json');
        
        $username = trim($this->input->post('username'));
        $userPassInput = $this->input->post('password');
        $userIP = $this->input->post('user_ip') ?? '';

        

        // Validate input
        if (empty($username) || empty($userPassInput)) {
            echo json_encode([
                "isProceed" => false,
                "msg" => "Please enter both username and password."
            ]);
            return;
        }

        try {
            // Get user from database
            $userRecord = $this->_getRecordsData(
                $data = array('id', 'username', 'password', 'email', 'full_name', 'is_active'),
                $tables = array('admin_users'),
                $fieldName = array('username', 'is_active'),
                $where = array($username, 1),
                $join = null,
                $joinType = null,
                $sortBy = null,
                $sortOrder = null,
                $limit = 1,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );

            // Check if user exists and is active
            if (empty($userRecord) || !isset($userRecord[0])) {
                echo json_encode([
                    "isProceed" => false,
                    "msg" => "Invalid username or password."
                ]);
                return;
            }

            $user = $userRecord[0];

            // Verify password
            $passwordVerified = password_verify($userPassInput, $user->password);
            
            // If password verification fails, check if we need to update the password hash
            if (!$passwordVerified) {
                // Check if it's the old hash format or if password needs to be rehashed
                // This helps if the user was created with an incorrect hash
                echo json_encode([
                    "isProceed" => false,
                    "msg" => "Invalid username or password."
                ]);
                return;
            }

            // Check if user is active
            if (!$user->is_active) {
                echo json_encode([
                    "isProceed" => false,
                    "msg" => "Your account has been deactivated. Please contact administrator."
                ]);
                return;
            }

            // Update last login
            $updateData = ['last_login' => date('Y-m-d H:i:s')];
            $this->_updateRecords('admin_users', array('id'), array($user->id), $updateData);

            // Set session data
            $_SESSION['currentUser'] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'full_name' => $user->full_name,
                'logged_in' => true,
                'login_time' => time()
            ];

            // Set CodeIgniter session as well
            $this->session->set_userdata('currentUser', $_SESSION['currentUser']);

            // Return success
            echo json_encode([
                "isProceed" => true,
                "msg" => "Login successful!",
                "user" => [
                    "username" => $user->username,
                    "full_name" => $user->full_name
                ]
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "isProceed" => false,
                "msg" => "An error occurred during login. Please try again later."
            ]);
        }
    }

    /**
     * Error page handler
     */
    public function error()
    {
        show_404();
    }

    /**
     * Test email function (for testing email configuration)
     */
    public function testEmail()
    {
        $testEmail = $this->input->get('email') ?? "test@example.com";
        
        $subject = "Test Email from Virtual Estimate Form";
        $message = "This is a test email to verify email configuration.";
        
        $result = $this->_sendMail($testEmail, $subject, $message);
        
        if ($result) {
            echo "Email sent successfully to: " . $testEmail;
        } else {
            echo "Failed to send email. Check logs for details.";
        }
    }

    /**
     * Forms page - Multi-step form
     */
    public function forms()
    {   
        // echo "forms";
        $this->load->view('forms');
    }

    /**
     * Info page
     */
    public function info()
    {
        phpinfo();
    }

    /**
     * Setup admin user - Helper method to create/update admin user
     * Run this once: /main/setupAdmin
     */
    public function setupAdmin()
    {
        header('Content-Type: application/json');
        
        try {
            // Check if admin user exists
            $existingUser = $this->_getRecordsData(
                $data = array('id', 'username'),
                $tables = array('admin_users'),
                $fieldName = array('username'),
                $where = array('admin'),
                $join = null,
                $joinType = null,
                $sortBy = null,
                $sortOrder = null,
                $limit = 1,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );

            $passwordHash = password_hash('test@123', PASSWORD_DEFAULT);
            
            if (!empty($existingUser)) {
                // Update existing admin user password
                $updateData = [
                    'password' => $passwordHash,
                    'email' => 'admin@example.com',
                    'full_name' => 'Administrator',
                    'is_active' => 1
                ];
                $this->_updateRecords('admin_users', array('username'), array('admin'), $updateData);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Admin user password updated successfully!',
                    'username' => 'admin',
                    'password' => 'test@123'
                ]);
            } else {
                // Create new admin user
                $insertData = [
                    'username' => 'admin',
                    'password' => $passwordHash,
                    'email' => 'admin@example.com',
                    'full_name' => 'Administrator',
                    'is_active' => 1
                ];
                $this->_insertRecords('admin_users', $insertData);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Admin user created successfully!',
                    'username' => 'admin',
                    'password' => 'admin123'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get sample images for form (AJAX endpoint)
     */
    public function getSampleImages()
    {
        try {
            // Fetch sample images from database using MY_Controller method
            $results = $this->_getRecordsData(
                $data = array('category', 'image_url'),
                $tables = array('sample_images'),
                $fieldName = array('is_active'),
                $where = array(1),
                $join = null,
                $joinType = null,
                $sortBy = array('category'),
                $sortOrder = array('ASC'),
                $limit = null,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );

            // Build images array from database results
            $images = [];
            if (!empty($results)) {
                foreach ($results as $row) {
                    // Map database category to response key format
                    $categoryKey = $row->category;
                    $imageUrl = $row->image_url;
                    
                    // If the URL is not a full URL (http/https), prepend base_url()
                    if (!preg_match('/^https?:\/\//', $imageUrl)) {
                        $imageUrl = base_url($imageUrl);
                    }
                    
                    $images[$categoryKey] = $imageUrl;
                }
            }

            // Ensure all required categories exist (fallback to defaults if missing)
            if (empty($images['electrical_panel'])) {
                $images['electrical_panel'] = base_url('assets/img/samples/electrical-panel-sample.jpg');
            }
            if (empty($images['installation_area'])) {
                $images['installation_area'] = base_url('assets/img/samples/installation-area-sample.jpg');
            }
            if (empty($images['charger_location'])) {
                $images['charger_location'] = base_url('assets/img/samples/charger-location-sample.jpg');
            }

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'images' => $images
            ]);
        } catch (Exception $e) {
            // Error handling - return fallback images with local paths
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to load images from database',
                'images' => [
                    'electrical_panel' => base_url('assets/img/samples/electrical-panel-sample.jpg'),
                    'installation_area' => base_url('assets/img/samples/installation-area-sample.jpg'),
                    'charger_location' => base_url('assets/img/samples/charger-location-sample.jpg')
                ]
            ]);
        }
    }

    /**
     * Get charger models (AJAX endpoint)
     */
    public function getChargerModels()
    {
        try {
            $search = $this->input->get('search') ?? '';
            
            // Fetch charger models from database using MY_Controller method
            $whereSpecial = null;
            if (!empty($search)) {
                $whereSpecial = array("(model_name LIKE '%" . $this->db->escape_like_str($search) . "%' OR brand LIKE '%" . $this->db->escape_like_str($search) . "%')");
            }
            
            $results = $this->_getRecordsData(
                $data = array('id', 'model_name', 'brand'),
                $tables = array('charger_models'),
                $fieldName = array('is_active'),
                $where = array(1),
                $join = null,
                $joinType = null,
                $sortBy = array('brand', 'model_name'),
                $sortOrder = array('ASC', 'ASC'),
                $limit = null,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial,
                $groupBy = null
            );

            $models = [];
            if (!empty($results)) {
                foreach ($results as $row) {
                    $displayName = $row->brand ? $row->brand . ' ' . $row->model_name : $row->model_name;
                    $models[] = [
                        'id' => $row->id,
                        'model_name' => $row->model_name,
                        'brand' => $row->brand,
                        'display_name' => $displayName
                    ];
                }
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'models' => $models
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to load charger models',
                'models' => []
            ]);
        }
    }

    /**
     * Add new charger model (AJAX endpoint)
     */
    public function addChargerModel()
    {
        try {
            $modelName = trim($this->input->post('model_name') ?? '');
            $brand = trim($this->input->post('brand') ?? '');

            if (empty($modelName)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Model name is required'
                ]);
                return;
            }

            // Check if model already exists
            $existing = $this->_getRecordsData(
                $data = array('id', 'model_name', 'brand'),
                $tables = array('charger_models'),
                $fieldName = array('model_name'),
                $where = array($modelName),
                $join = null,
                $joinType = null,
                $sortBy = null,
                $sortOrder = null,
                $limit = null,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );

            if (!empty($existing)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Model already exists',
                    'model' => [
                        'id' => $existing[0]->id,
                        'model_name' => $existing[0]->model_name,
                        'brand' => $existing[0]->brand,
                        'display_name' => $existing[0]->brand ? $existing[0]->brand . ' ' . $existing[0]->model_name : $existing[0]->model_name
                    ]
                ]);
                return;
            }

            // Insert new model
            $data = [
                'model_name' => $modelName,
                'brand' => !empty($brand) ? $brand : null,
                'is_active' => 1
            ];

            $insertedData = $this->_insertRecordsRetData('charger_models', $data, 'id');

            if ($insertedData) {
                $displayName = $insertedData['brand'] ? $insertedData['brand'] . ' ' . $insertedData['model_name'] : $insertedData['model_name'];
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Charger model added successfully',
                    'model' => [
                        'id' => $insertedData['id'],
                        'model_name' => $insertedData['model_name'],
                        'brand' => $insertedData['brand'],
                        'display_name' => $displayName
                    ]
                ]);
            } else {
                throw new Exception('Failed to insert charger model');
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add charger model: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Submit estimate form (AJAX endpoint)
     */
    public function submitEstimate()
    {
        try {
            // Generate unique estimate number
            $estimateNumber = 'EST-' . strtoupper(uniqid()) . '-' . strtoupper(substr(md5(time()), 0, 6));
            
            // Get form data
            $firstName = trim($this->input->post('firstName') ?? '');
            $lastName = trim($this->input->post('lastName') ?? '');
            $email = trim($this->input->post('email') ?? '');
            $phone = trim($this->input->post('phone') ?? '');
            $company = trim($this->input->post('company') ?? '');
            $address = trim($this->input->post('address') ?? '');
            $projectType = trim($this->input->post('projectType') ?? '');
            $projectDescription = trim($this->input->post('projectDescription') ?? '');
            $timeline = trim($this->input->post('timeline') ?? '');
            $additionalRequirements = trim($this->input->post('additionalRequirements') ?? '');
            $chargerModelId = intval($this->input->post('chargerModelId') ?? 0);
            $dukeRebate = $this->input->post('dukeRebate') ?? null;
            $rentingHome = $this->input->post('rentingHome') ?? null;
            $dukeCustomer = $this->input->post('dukeCustomer') ?? null;
            $evRegistered = $this->input->post('evRegistered') ?? null;

            // Validation
            if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($address) || empty($projectType)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all required fields'
                ]);
                return;
            }

            // Get charger model name if ID is provided
            $chargerModelName = null;
            if ($chargerModelId > 0) {
                $chargerModel = $this->_getRecordsData(
                    $data = array('model_name', 'brand'),
                    $tables = array('charger_models'),
                    $fieldName = array('id'),
                    $where = array($chargerModelId),
                    $join = null,
                    $joinType = null,
                    $sortBy = null,
                    $sortOrder = null,
                    $limit = null,
                    $fieldNameLike = null,
                    $like = null,
                    $whereSpecial = null,
                    $groupBy = null
                );
                if (!empty($chargerModel)) {
                    $chargerModelName = $chargerModel[0]->brand ? $chargerModel[0]->brand . ' ' . $chargerModel[0]->model_name : $chargerModel[0]->model_name;
                }
            }

            // Prepare estimate data
            $estimateData = [
                'estimate_number' => $estimateNumber,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'company' => !empty($company) ? $company : null,
                'address' => $address,
                'project_type' => $projectType,
                'project_description' => !empty($projectDescription) ? $projectDescription : null,
                'timeline' => !empty($timeline) ? $timeline : null,
                'additional_requirements' => !empty($additionalRequirements) ? $additionalRequirements : null,
                'charger_model_id' => $chargerModelId > 0 ? $chargerModelId : null,
                'charger_model_name' => $chargerModelName,
                'duke_rebate' => $dukeRebate,
                'renting_home' => $rentingHome,
                'duke_customer' => $dukeCustomer,
                'ev_registered' => $evRegistered,
                'status' => 'pending'
            ];

            // Insert estimate
            $insertedEstimate = $this->_insertRecordsRetData('estimates', $estimateData, 'id');

            if (!$insertedEstimate || !isset($insertedEstimate['id'])) {
                throw new Exception('Failed to save estimate');
            }

            $estimateId = $insertedEstimate['id'];

            // Handle file uploads
            $uploadedFiles = [];
            $uploadPath = './uploads/estimates/' . $estimateId . '/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $categories = ['electrical-panel', 'installation-area', 'charger-location'];
            
            foreach ($categories as $category) {
                if (isset($_FILES[$category]) && is_array($_FILES[$category]['name'])) {
                    $files = $_FILES[$category];
                    $fileCount = count($files['name']);
                    
                    for ($i = 0; $i < $fileCount; $i++) {
                        if ($files['error'][$i] === UPLOAD_ERR_OK) {
                            $fileName = $files['name'][$i];
                            $fileTmpName = $files['tmp_name'][$i];
                            $fileSize = $files['size'][$i];
                            $fileType = $files['type'][$i];
                            
                            // Generate unique filename
                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
                            $filePath = $uploadPath . $uniqueFileName;
                            
                            // Move uploaded file
                            if (move_uploaded_file($fileTmpName, $filePath)) {
                                // Save to database
                                $attachmentData = [
                                    'estimate_id' => $estimateId,
                                    'category' => $category,
                                    'file_name' => $fileName,
                                    'file_path' => 'uploads/estimates/' . $estimateId . '/' . $uniqueFileName,
                                    'file_size' => $fileSize,
                                    'file_type' => $fileType
                                ];
                                
                                $this->_insertRecords('estimate_attachments', $attachmentData);
                                $uploadedFiles[] = $fileName;
                            }
                        }
                    }
                }
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Estimate submitted successfully',
                'estimate_number' => $estimateNumber,
                'estimate_id' => $estimateId,
                'files_uploaded' => count($uploadedFiles)
            ]);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to submit estimate: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Submitted Forms page
     */
    public function submittedForms()
    {
        // Check if user is logged in
        if (!isset($_SESSION["currentUser"]) || empty($_SESSION["currentUser"])) {
            redirect(base_url('admin'));
        } else {
            $data['title'] = 'Submitted Forms';
            $data['user'] = $_SESSION["currentUser"];
            $this->load->view('mainPages/submitted_forms', $data);
        }
    }

    /**
     * Get estimates with pagination, search, and sorting (AJAX endpoint)
     */
    public function getEstimates()
    {
        header('Content-Type: application/json');
        
        try {
            $page = intval($this->input->get('page') ?? 1);
            $limit = intval($this->input->get('limit') ?? 10);
            $search = trim($this->input->get('search') ?? '');
            $sortBy = trim($this->input->get('sort_by') ?? 'created_at');
            $sortOrder = strtoupper(trim($this->input->get('sort_order') ?? 'DESC'));
            
            // Validate sort order
            if (!in_array($sortOrder, ['ASC', 'DESC'])) {
                $sortOrder = 'DESC';
            }
            
            // Validate sort column
            $allowedSortColumns = ['id', 'estimate_number', 'first_name', 'last_name', 'email', 'phone', 'company', 'project_type', 'status', 'created_at'];
            if (!in_array($sortBy, $allowedSortColumns)) {
                $sortBy = 'created_at';
            }
            
            $offset = ($page - 1) * $limit;
            
            // Save original limit value before it gets overwritten
            $perPage = $limit;
            
            // Build search condition
            $whereSpecial = null;
            if (!empty($search)) {
                $searchEscaped = $this->db->escape_like_str($search);
                $whereSpecial = array(
                    "(estimate_number LIKE '%" . $searchEscaped . "%' OR " .
                    "first_name LIKE '%" . $searchEscaped . "%' OR " .
                    "last_name LIKE '%" . $searchEscaped . "%' OR " .
                    "email LIKE '%" . $searchEscaped . "%' OR " .
                    "phone LIKE '%" . $searchEscaped . "%' OR " .
                    "company LIKE '%" . $searchEscaped . "%' OR " .
                    "project_type LIKE '%" . $searchEscaped . "%' OR " .
                    "status LIKE '%" . $searchEscaped . "%' OR " .
                    "charger_model_name LIKE '%" . $searchEscaped . "%')"
                );
            }
            
            // Get total count for pagination
            $countResults = $this->_getRecordsData(
                $data = array('COUNT(*) as total'),
                $tables = array('estimates'),
                $fieldName = null,
                $where = null,
                $join = null,
                $joinType = null,
                $sortBy = null,
                $sortOrder = null,
                $limit = null,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial,
                $groupBy = null
            );
            $totalRecords = !empty($countResults) ? intval($countResults[0]->total) : 0;
            
            // Get estimates - use array for limit parameter
            $limitArray = array($limit, $offset);
            $estimates = $this->_getRecordsData(
                $data = array('id', 'estimate_number', 'first_name', 'last_name', 'email', 'phone', 'company', 'project_type', 'status', 'charger_model_name', 'created_at'),
                $tables = array('estimates'),
                $fieldName = null,
                $where = null,
                $join = null,
                $joinType = null,
                $sortBy = array($sortBy),
                $sortOrder = array($sortOrder),
                $limit = $limitArray,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial,
                $groupBy = null
            );
            
            // Format data
            $formattedEstimates = [];
            if (!empty($estimates)) {
                foreach ($estimates as $estimate) {
                    $formattedEstimates[] = [
                        'id' => $estimate->id,
                        'estimate_number' => $estimate->estimate_number,
                        'name' => trim($estimate->first_name . ' ' . $estimate->last_name),
                        'email' => $estimate->email,
                        'phone' => $estimate->phone,
                        'company' => $estimate->company ?? '-',
                        'project_type' => $estimate->project_type,
                        'charger_model' => $estimate->charger_model_name ?? '-',
                        'status' => $estimate->status,
                        'created_at' => $estimate->created_at,
                        'created_at_formatted' => date('M d, Y H:i', strtotime($estimate->created_at))
                    ];
                }
            }
            
            // Calculate total pages using the saved perPage value
            $totalPages = $perPage > 0 ? ceil($totalRecords / $perPage) : 0;
            
            echo json_encode([
                'success' => true,
                'data' => $formattedEstimates,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_records' => $totalRecords,
                    'total_pages' => $totalPages
                ]
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => [],
                'pagination' => [
                    'current_page' => 1,
                    'per_page' => 10,
                    'total_records' => 0,
                    'total_pages' => 0
                ]
            ]);
        }
    }

    /**
     * Get single estimate with attachments (AJAX endpoint)
     */
    public function getEstimateDetails()
    {
        header('Content-Type: application/json');
        
        try {
            $estimateId = intval($this->input->get('id') ?? 0);
            
            if ($estimateId <= 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid estimate ID'
                ]);
                return;
            }
            
            // Get estimate details
            $estimate = $this->_getRecordsData(
                $data = array('*'),
                $tables = array('estimates'),
                $fieldName = array('id'),
                $where = array($estimateId),
                $join = null,
                $joinType = null,
                $sortBy = null,
                $sortOrder = null,
                $limit = 1,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );
            
            if (empty($estimate) || !isset($estimate[0])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Estimate not found'
                ]);
                return;
            }
            
            $estimateData = $estimate[0];
            
            // Get attachments
            $attachments = $this->_getRecordsData(
                $data = array('*'),
                $tables = array('estimate_attachments'),
                $fieldName = array('estimate_id'),
                $where = array($estimateId),
                $join = null,
                $joinType = null,
                $sortBy = array('category', 'uploaded_at'),
                $sortOrder = array('ASC', 'ASC'),
                $limit = null,
                $fieldNameLike = null,
                $like = null,
                $whereSpecial = null,
                $groupBy = null
            );
            
            // Format attachments by category
            $attachmentsByCategory = [
                'electrical-panel' => [],
                'installation-area' => [],
                'charger-location' => []
            ];
            
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $category = $attachment->category;
                    if (isset($attachmentsByCategory[$category])) {
                        $attachmentsByCategory[$category][] = [
                            'id' => $attachment->id,
                            'file_name' => $attachment->file_name,
                            'file_path' => base_url($attachment->file_path),
                            'file_size' => $attachment->file_size,
                            'file_type' => $attachment->file_type,
                            'uploaded_at' => $attachment->uploaded_at
                        ];
                    }
                }
            }
            
            // Format estimate data
            $formattedEstimate = [
                'id' => $estimateData->id,
                'estimate_number' => $estimateData->estimate_number,
                'first_name' => $estimateData->first_name,
                'last_name' => $estimateData->last_name,
                'email' => $estimateData->email,
                'phone' => $estimateData->phone,
                'company' => $estimateData->company,
                'address' => $estimateData->address,
                'project_type' => $estimateData->project_type,
                'project_description' => $estimateData->project_description,
                'timeline' => $estimateData->timeline,
                'additional_requirements' => $estimateData->additional_requirements,
                'charger_model_name' => $estimateData->charger_model_name,
                'duke_rebate' => $estimateData->duke_rebate,
                'renting_home' => $estimateData->renting_home,
                'duke_customer' => $estimateData->duke_customer,
                'ev_registered' => $estimateData->ev_registered,
                'status' => $estimateData->status,
                'created_at' => $estimateData->created_at,
                'created_at_formatted' => date('F d, Y \a\t h:i A', strtotime($estimateData->created_at)),
                'updated_at' => $estimateData->updated_at,
                'attachments' => $attachmentsByCategory
            ];
            
            echo json_encode([
                'success' => true,
                'data' => $formattedEstimate
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

