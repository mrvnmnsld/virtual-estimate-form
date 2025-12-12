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
        $excluded_methods = ['checkLoginCredentials', 'index', 'admin', 'forms', 'logout', 'testEmail', 'info']; // Add method names here to exclude from session check
        
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
            // You can create a dashboard view later
            $data['title'] = 'Dashboard';
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
        $username = $this->input->post('username');
        $userPassInput = $this->input->post('password');
        $userIP = $this->input->post('user_ip') ?? '';

        // TODO: Implement your login logic here
        // This is a placeholder - you'll need to implement based on your database structure
        
        echo json_encode([
            "isProceed" => false,
            "msg" => "Login functionality not yet implemented",
            "desc" => "Please implement checkLoginCredentials method"
        ]);
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
}

