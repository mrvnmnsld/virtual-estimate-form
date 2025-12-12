<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    /**
     * Mailer enabled flag - set to false to disable email sending
     * When disabled, all mailer methods will return true without actually sending emails
     * @var bool
     */
    protected $mailer_enabled = false;

    function __construct()
    {
        parent::__construct();
        $this->load->model('mainModel');
        $this->load->library('encryption');
        $this->load->helper('file');
		$this->load->model('NotificationsModel', 'notifications');
    }

    /**
     * Check if user session is valid
     * @param bool $returnJson - If true, returns JSON response for AJAX calls
     * @return bool|void
     */
    protected function _checkSession($returnJson = false)
    {
        if (!isset($_SESSION['currentUser']) || empty($_SESSION['currentUser'])) {
            if ($returnJson) {
                // For AJAX calls, return JSON with 401 status
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'error' => 'Session expired',
                    'message' => 'Please login again',
                    'redirect' => base_url('admin')
                ]);
                exit;
            } else {
                // For regular page requests, redirect to admin
                redirect(base_url('admin'));
            }
        }
        return true;
    }

    function _getRecords($tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial)
    {
        $rows = $this->mainModel->getRecords($tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial);
        return $rows;
    }

    function _getRecordsData($data, $tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial, $groupBy)
    {
        $rows = $this->mainModel->getRecordsData($data, $tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial, $groupBy);
        return $rows;
    }

    function _updateRecords($tableName, $fieldName, $where, $data)
    {
        $rows = $this->mainModel->updateRecords($tableName, $fieldName, $where, $data);
        return $rows;
    }

    function _insertRecords($tableName, $data)
    {
        $rows = $this->mainModel->insertRecords($tableName, $data);
        return $rows;
    }

    function _insertRecordsRetData($tableName, $data, $primaryKey = "id")
    {
        $insertedData = $this->mainModel->insertRecordsRetData($tableName, $data, $primaryKey);
        return $insertedData;
    }

    function _insertRecordsRetID($tableName, $data, $primaryKey = "id")
    {
        $insertedData = $this->mainModel->insertRecordsRetID($tableName, $data, $primaryKey);
        return $insertedData;
    }


    function _insertRecordsBatch($tableName, $data)
    {
        $noOfInsertedRecords = $this->mainModel->insertRecordsBatch($tableName, $data);
        return $noOfInsertedRecords;
    }

    function _updateRecordsBatch($tableName, $data, $whereKey)
    {
        $noOfUpdatedRecords = $this->mainModel->updateRecordsBatch($tableName, $data, $whereKey);
        return $noOfUpdatedRecords;
    }

    function _deleteRecords($tableName, $fieldName, $where)
    {
        $rows = $this->mainModel->deleteRecords($tableName, $fieldName, $where);
        return $rows;
    }

    public function _getUserPrivileges($userName, $dataElementIDType)
    {

        $recSQL = "sISPrivilege.orgCode, sISPrivilege.branchOfficeCode, sISPrivilege.categorySystemID, ";
        $recSQL = $recSQL . "sISPrivilege.groupSystemID, sISPrivilege.sourceSystemID, sISPrivilege.dataElementID, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription";

        $results = $this->_getRecordsData(
            $rec = array($recSQL),
            $tables = array('sISPrivilegeUser', 'sISPrivilege'),
            $fieldName = array('sISPrivilegeUser.userNumber'),
            $where = array($userName),
            $join = array('sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID'),
            $joinType = array('inner'),
            $sortBy = array('sISPrivilege.sequenceOrder'),
            $sortOrder = array('asc'),
            $limit = null,
            $fieldNameLike = null,
            $like = null,
            $whereSpecial = array("sISPrivilegeUser.dataElementID LIKE '%" . $dataElementIDType . "'"),
            $groupBy = null
        );

        return $results;
    }

    public function _getUserPrivilegesCategory($userName, $dataElementIDType)
    {

        $recSQL = "sISPrivilege.orgCode, sISPrivilege.branchOfficeCode, sISPrivilege.categorySystemID as categ, ";
        $recSQL = $recSQL . "sISPrivilege.groupSystemID, sISPrivilege.sourceSystemID, sISPrivilege.dataElementID, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription, ";
        $recSQL = $recSQL . "(SELECT count(sISPrivilege.elementValueID) FROM sISPrivilegeUser ";
        $recSQL = $recSQL . "INNER JOIN sISPrivilege ON sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID ";
        $recSQL = $recSQL . "WHERE  sISPrivilegeUser.userNumber = '" . $userName . "' AND ";
        $recSQL = $recSQL . "sISPrivilegeUser.dataElementID LIKE '%-GRP' AND ";
        $recSQL = $recSQL . "categ = sISPrivilegeUser.categorySystemID) as grpcount";


        $results = $this->_getRecordsData(
            $rec = array($recSQL),
            $tables = array('sISPrivilegeUser', 'sISPrivilege'),
            $fieldName = array('sISPrivilegeUser.userNumber'),
            $where = array($userName),
            $join = array('sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID'),
            $joinType = array('inner'),
            $sortBy = array('sISPrivilege.sequenceOrder'),
            $sortOrder = array('asc'),
            $limit = null,
            $fieldNameLike = null,
            $like = null,
            $whereSpecial = array("sISPrivilegeUser.dataElementID LIKE '%" . $dataElementIDType . "'"),
            $groupBy = null
        );

        return $results;
    }

    public function _getUserPrivilegesCategorySet($userName, $dataElementIDType)
    {

        $recSQL = "sISPrivilege.orgCode, sISPrivilege.branchOfficeCode, sISPrivilege.categorySystemID as categ, ";
        $recSQL = $recSQL . "sISPrivilege.groupSystemID, sISPrivilege.sourceSystemID, sISPrivilege.dataElementID, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription, ";
        $recSQL = $recSQL . "(SELECT count(sISPrivilege.elementValueID) FROM sISPrivilegeUser ";
        $recSQL = $recSQL . "INNER JOIN sISPrivilege ON sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID ";
        $recSQL = $recSQL . "WHERE  sISPrivilegeUser.userNumber = '" . $userName . "' AND ";
        $recSQL = $recSQL . "sISPrivilegeUser.dataElementID LIKE '%-GRPSET' AND ";
        $recSQL = $recSQL . "categ = sISPrivilegeUser.categorySystemID) as grpcount";


        $results = $this->_getRecordsData(
            $rec = array($recSQL),
            $tables = array('sISPrivilegeUser', 'sISPrivilege'),
            $fieldName = array('sISPrivilegeUser.userNumber'),
            $where = array($userName),
            $join = array('sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID'),
            $joinType = array('inner'),
            $sortBy = array('sISPrivilege.sequenceOrder'),
            $sortOrder = array('asc'),
            $limit = null,
            $fieldNameLike = null,
            $like = null,
            $whereSpecial = array("sISPrivilegeUser.dataElementID LIKE '%" . $dataElementIDType . "'"),
            $groupBy = null
        );

        return $results;
    }

    public function _getUserPrivilegesDetails($userName, $dataElementIDType, $groupSystemID)
    {

        $recSQL = "sISPrivilege.orgCode, sISPrivilege.branchOfficeCode, sISPrivilege.categorySystemID, ";
        $recSQL = $recSQL . "sISPrivilege.groupSystemID, sISPrivilege.sourceSystemID, sISPrivilege.dataElementID, ";
        $recSQL = $recSQL . "sISPrivilege.elementValueID, sISPrivilege.elementValueDescription, sISPrivilege.param, sISPrivilege.sequenceOrder";

        $results = $this->_getRecordsData(
            $rec = array($recSQL),
            $tables = array('sISPrivilegeUser', 'sISPrivilege'),
            $fieldName = array('sISPrivilegeUser.userNumber', 'sISPrivilegeUser.groupSystemID'),
            $where = array($userName, $groupSystemID),
            $join = array('sISPrivilegeUser.orgCode = sISPrivilege.orgCode AND sISPrivilegeUser.branchOfficeCode = sISPrivilege.branchOfficeCode AND sISPrivilegeUser.categorySystemID = sISPrivilege.categorySystemID AND sISPrivilegeUser.groupSystemID = sISPrivilege.groupSystemID AND sISPrivilegeUser.sourceSystemID = sISPrivilege.sourceSystemID AND sISPrivilegeUser.dataElementID = sISPrivilege.dataElementID AND sISPrivilegeUser.elementValueID = sISPrivilege.elementValueID'),
            $joinType = array('inner'),
            $sortBy = array('sISPrivilege.sequenceOrder'),
            $sortOrder = array('asc'),
            $limit = null,
            $fieldNameLike = null,
            $like = null,
            $whereSpecial = array("sISPrivilegeUser.dataElementID LIKE '%" . $dataElementIDType . "'"),
            $groupBy = null
        );

        return $results;
    }

    function _getCurrentDate()
    {
        $currentDate = date('Y-m-d');
        return $currentDate;
    }

    function _getTimeStamp()
    {
        $timeStamp = date('Y-m-d h:i:s');
        return $timeStamp;
    }

    function _getUserName($userType)
    {
        $userName = null;
        if ($userType == 0) {
            $userName = "SYSGEN";
        } else {
            $userName = $this->session->userdata('userName'); //should be actual user id
        }
        return $userName;
    }

    function _getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } //check ip from share internet
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }  //to check ip is pass from proxy
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function _getMarqueeMessage()
    {
        $results = $this->_getRecordsData(
            $data = array('*'),
            $tables = array('sISMarquee'),
            $fieldName = array('active'),
            $where = array(1),
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

        return $results;
    }

    public function _getRequestStatus($requestStatusDescription, $application)
    {
        $results = $this->_getRecordsData(
            $data = array('requestStatusCode'),
            $tables = array('triune_request_status_reference'),
            $fieldName = array('requestStatusDescription', 'application'),
            $where = array($requestStatusDescription, $application),
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

        return $results[0]->requestStatusCode;
    }

    public function _getRequestStatusDescription($requestStatusCode, $application)
    {
        $results = $this->_getRecordsData(
            $data = array('*'),
            $tables = array('triune_request_status_reference'),
            $fieldName = array('requestStatusCode', 'application'),
            $where = array($requestStatusCode, $application),
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

        return $results[0]->requestStatusDescription;
    }

    public function _base64urlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function _base64urlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function _isTokenValid($token)
    {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);


        $result = $userRecord = $this->_getRecordsData(
            $data = array('*'),
            $tables = array('sISToken'),
            $fieldName = array('token', 'userID'),
            $where = array($tkn, $uid),
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


        if ($result) {
            $created = $result[0]->timeStamp;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $userInfo = $this->_getRecordsData(
                $data = array('*'),
                $tables = array('sISUsers'),
                $fieldName = array('ID'),
                $where = array($result[0]->userID),
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
            return $userInfo;
        } else {
            return false;
        }
    }

    public function _sendMail($toEmail, $subject, $message)
    {
        // Check if mailer is disabled
        if (!$this->mailer_enabled) {
            log_message('info', 'Email sending disabled - would have sent to: ' . $toEmail . ' | Subject: ' . $subject);
            return true; // Return true to maintain compatibility with existing code
        }

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'itjgmd@gmail.com',
            'smtp_pass' => 'vfuu pdag tgwi irlf',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto' => 'tls',
            'smtp_timeout' => 30, // Increased timeout for production environments
            'smtp_keepalive' => FALSE,
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->clear(TRUE);

        $fromEmail = "it.noreply@jgmd.ph";
        $fromName = "JGMD COMS";

        $this->email->from($fromEmail, $fromName);
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            // Log the error instead of displaying it
            $error = $this->email->print_debugger();
            log_message('error', 'Email sending failed: ' . $error);
            return false;
        }
    }

    public function _sendMailHTML($toEmail, $subject, $htmlContent, $plainTextContent = null)
    {
        // Check if mailer is disabled
        if (!$this->mailer_enabled) {
            log_message('info', 'Email sending disabled - would have sent HTML email to: ' . $toEmail . ' | Subject: ' . $subject);
            return true; // Return true to maintain compatibility with existing code
        }

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'itjgmd@gmail.com',
            'smtp_pass' => 'dvth thiq icqt trar',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto' => 'tls',
            'smtp_timeout' => 10, // SMTP connection timeout
            'smtp_keepalive' => FALSE,
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->clear(TRUE);

        $fromEmail = "it.noreply@jgmd.ph";
        $fromName = "JGMD COMS";

        $this->email->from($fromEmail, $fromName);
        $this->email->to($toEmail);
        $this->email->subject($subject);
        
        // Set HTML content
        $this->email->message($htmlContent);
        
        // Add plain text alternative if provided
        if ($plainTextContent) {
            $this->email->set_alt_message($plainTextContent);
        }

        if ($this->email->send()) {
            return true;
        } else {
            // Log the error instead of displaying it
            $error = $this->email->print_debugger();
            log_message('error', 'Email sending failed: ' . $error);
            return false;
        }
    }

    /**
     * Create a beautiful HTML email template with CSS styling
     * 
     * @param string $title - Email title/heading
     * @param string $content - Main content of the email
     * @param string $footer - Footer content (optional)
     * @param string $buttonText - Text for call-to-action button (optional)
     * @param string $buttonLink - Link for call-to-action button (optional)
     * @return string - Complete HTML email template
     */
    public function _createEmailTemplate($title, $content, $footer = '', $buttonText = '', $buttonLink = '')
    {
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>JGMD COMS Notification</title>
            <style>
                /* Reset styles */
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    background-color: #f4f4f4;
                }
                
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                
                .email-header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 30px 20px;
                    text-align: center;
                }
                
                .email-header .logo {
                    max-width: 120px;
                    height: auto;
                    margin-bottom: 15px;
                    border-radius: 8px;
                }
                
                .email-header h1 {
                    font-size: 28px;
                    font-weight: 300;
                    margin-bottom: 10px;
                }
                
                .email-header p {
                    font-size: 16px;
                    opacity: 0.9;
                }
                
                .email-body {
                    padding: 40px 30px;
                }
                
                .email-body h2 {
                    color: #2c3e50;
                    font-size: 24px;
                    margin-bottom: 20px;
                    font-weight: 400;
                }
                
                .email-body p {
                    font-size: 16px;
                    margin-bottom: 20px;
                    color: #555;
                }
                
                .email-body ul {
                    margin: 20px 0;
                    padding-left: 20px;
                }
                
                .email-body li {
                    margin-bottom: 8px;
                    color: #555;
                }
                
                .cta-button {
                    display: inline-block;
                    background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
                    color: white;
                    padding: 15px 30px;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: 500;
                    margin: 20px 0;
                    transition: transform 0.2s ease;
                    box-shadow: 0 2px 4px rgba(33, 150, 243, 0.3);
                }
                
                .cta-button:hover {
                    transform: translateY(-2px);
                }
                
                .email-footer {
                    background-color: #f8f9fa;
                    padding: 30px;
                    text-align: center;
                    border-top: 1px solid #e9ecef;
                }
                
                .email-footer p {
                    color: #6c757d;
                    font-size: 14px;
                    margin-bottom: 10px;
                }
                
                .email-footer .company-info {
                    font-size: 12px;
                    color: #adb5bd;
                }
                
                .highlight-box {
                    background-color: #e3f2fd;
                    border-left: 4px solid #2196f3;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 0 5px 5px 0;
                }
                
                .success-box {
                    background-color: #e8f5e8;
                    border-left: 4px solid #4caf50;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 0 5px 5px 0;
                }
                
                .warning-box {
                    background-color: #fff3cd;
                    border-left: 4px solid #ffc107;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 0 5px 5px 0;
                }
                
                .error-box {
                    background-color: #f8d7da;
                    border-left: 4px solid #dc3545;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 0 5px 5px 0;
                }
                
                /* Responsive design */
                @media only screen and (max-width: 600px) {
                    .email-container {
                        margin: 0;
                        border-radius: 0;
                    }
                    
                    .email-header, .email-body, .email-footer {
                        padding: 20px;
                    }
                    
                    .email-header h1 {
                        font-size: 24px;
                    }
                    
                    .email-body h2 {
                        font-size: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <img src="' . base_url('assets/img/jgmd_logo.png') . '" alt="JGMD Logo" class="logo">
                    <h1>JGMD COMS</h1>
                </div>
                
                <div class="email-body">
                    <h2>' . htmlspecialchars($title) . '</h2>
                    <div>' . $content . '</div>';
        
        // Add call-to-action button if provided
        if (!empty($buttonText) && !empty($buttonLink)) {
            $html .= '<div style="text-align: center; margin: 30px 0;">
                        <a href="' . htmlspecialchars($buttonLink) . '" class="cta-button">' . htmlspecialchars($buttonText) . '</a>
                      </div>';
        }
        
        $html .= '</div>';
        
        // Add footer if provided
        if (!empty($footer)) {
            $html .= '<div class="email-footer">
                        <div>' . $footer . '</div>
                        <div class="company-info">
                            <p>This is an automated message from JGMD COMS System</p>
                            <p>Please do not reply to this email</p>
                        </div>
                      </div>';
        } else {
            $html .= '<div class="email-footer">
                        <div class="company-info">
                            <p>This is an automated message from JGMD COMS System</p>
                            <p>Please do not reply to this email</p>
                        </div>
                      </div>';
        }
        
        $html .= '</div>
        </body>
        </html>';
        
        return $html;
    }

    public function _sendMailWithAttachment($toEmail, $subject, $message, $attachmentPath)
    {
        // Check if mailer is disabled
        if (!$this->mailer_enabled) {
            log_message('info', 'Email sending disabled - would have sent email with attachment to: ' . $toEmail . ' | Subject: ' . $subject);
            $this->session->set_flashdata("email_sent", "Email sent successfully."); // Maintain compatibility
            return true; // Return true to maintain compatibility with existing code
        }

        $base64 = $this->input->post('base64');

        $base64 = str_replace('data:application/pdf;base64,', '', $base64);
        $base64 = str_replace(' ', '+', $base64);

        $data = base64_decode($base64);

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => 'trinityemailer@gmail.com',
            'smtp_pass' => 'tr1n1ty@1963',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE,
            'starttls' => TRUE,
            'wordwrap' => TRUE

        );
        $this->load->library('email', $config);
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');

        $fromEmail = "trinityemailer@gmail.com";


        $this->email->from($fromEmail, 'Trinity Emailer');
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($message);
        //$attachment_tmp_path = $_FILES['resume']['tmp_name'].'/'.$_FILES['resume']['name'];
        $this->email->attach($data, $attachmentPath, 'application/pdf');
        //$this->email->attach($attachmentPath);
        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata("email_sent", "Email sent successfully.");
            return true;
        } else {
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
            return false;
            //var_dump($this->email->send());
        }
    }

    public function _insertToken($id)
    {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');


        $triune_token = null;
        $triune_token = array(
            'token' => $token,
            'userID' => $id,
            'timeStamp' => $date,
        );
        $this->_insertRecords($tableName = 'sISToken', $triune_token);
        $token = $token . $id;
        $qstring = $this->_base64urlEncode($token);
        return $qstring;
    }

    // public function _sendSMS()
    // {
    //     $NEXMO_API_KEY = '72d97f08';
    //     $NEXMO_API_SECRET = 'd3d4ea727e3ba4ca';
    //     $basic = new \Nexmo\Client\Credentials\Basic($NEXMO_API_KEY, $NEXMO_API_SECRET);
    //     $client = new \Nexmo\Client($basic);

    //     $TO_NUMBER = '639175787809';
    //     $message = $client->message()->send([
    //         'to' => $TO_NUMBER,
    //         'from' => 'WebApp',
    //         'text' => 'You are now registered'
    //     ]);
    // }
    //
    function _insertAuditTrail($actionName, $systemForAuditName, $moduleName, $for, $oldValue, $newValue, $userType)
    {

        //SET AND INSERT AUDIT TRAIL RECORD
        //SETUP AUDIT TRAIL DATA AND INSERT AUDIT TRAIL
        $action = $actionName;
        $systemForAudit = $systemForAuditName;
        $module = $moduleName;
        $auditTrailData = array(
            'userName' => $this->_getUserName($userType),
            'timeStamp' => $this->_getTimeStamp(),
            'dateCreated' => $this->_getCurrentDate(),
            'workstationID' => $this->_getIPAddress(),
            'system' => $systemForAudit,
            'module' => $module,
            'action' => $action,
            'oldValue' => serialize($oldValue),
            'newValue' => serialize($newValue),
            'for' => $for,
        );
        //var_dump($auditTrailData);
        $this->_insertRecords($tableName = 'sISAuditTrail', $auditTrailData);
        //SET AND INSERT AUDIT TRAIL RECORD

    }

    public function _transactionFailed()
    {
        $error = $this->db->error();
        $this->session->set_flashdata('Error', $error["message"]);
    }

    public function _insertTextLog($fileName, $text, $folder)
    {

        if (!write_file('./assets/logs/' . $folder . '/' . $fileName, $text . PHP_EOL, 'a+')) {
            $this->_transactionFailed();
        } else {
            return true;
        }
    }

    public function _getTransactionDetails($ID, $from)
    {
        $results = $this->_getRecordsData(
            $rec = array('*'),
            $tables = array($from),
            $fieldName = array('ID'),
            $where = array($ID),
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

        return $results;
    }

    public function _getWorkingDays($startDate, $endDate)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if ($startDate <= $endDate) {
            $datediff = $endDate - $startDate;
            return floor($datediff / (60 * 60 * 24));
        }
        return false;
    }

    public function _getYearsMonthsDays($startDate)
    {

        $date1 = new DateTime($startDate);
        $date2 = new DateTime($this->_getCurrentDate());

        if ($date1 <= $date2) {
            $diff = $date2->diff($date1);
            return $diff;
        }
        return false;
    }

    public function _getSemesterDesc($sem)
    {
        $semDesc = '';
        if ($sem == 'A') {
            $semDesc = 'First Semester';
        } elseif ($sem == 'B') {
            $semDesc = 'Second Semester';
        } elseif ($sem == 'C') {
            $semDesc = 'Summer';
        }

        return $semDesc;
    }

    function _generateNumberFiveDigit($number)
    {

        if ($number < 10) {
            $number = '0000' . $number;
        } elseif ($number >= 10 and $number < 100) {
            $number = '000' . $number;
        } elseif ($number >= 100 and $number < 1000) {
            $number = '00' . $number;
        } elseif ($number >= 1000 and $number < 10000) {
            $number = '0' . $number;
        } elseif ($number >= 10000) {
            $number = $number;
        }
        return $number;
    }

    function _generateNumberFourDigit($number)
    {

        if ($number < 10) {
            $number = '000' . $number;
        } elseif ($number >= 10 and $number < 100) {
            $number = '00' . $number;
        } elseif ($number >= 100 and $number < 1000) {
            $number = '0' . $number;
        } elseif ($number >= 1000) {
            $number = $number;
        }
        return $number;
    }

    function _getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? $this->_gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->_gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->_gps2Num($exifCoord[2]) : 0;
        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    function _gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    function _getOverlappedDates()
    {
        // Get the current date
        $currentDate = new DateTime();

        // Get the first day of the month
        $firstDayOfMonth = new DateTime($currentDate->format('Y-m-01'));

        // Get the last day of the month
        $lastDayOfMonth = new DateTime($currentDate->format('Y-m-t'));

        return [
            'start' => $firstDayOfMonth,
            'end' => $lastDayOfMonth
        ];
    }

    function _getOverlappedDatesNextMonth()
    {
        // Get the current date
        $currentDate = new DateTime();

        // Extract the current year and month as integers
        $year = (int) $currentDate->format('Y');
        $month = (int) $currentDate->format('m');

        // Increment the month by 1
        $nextMonth = $month + 1;

        // Handle the year rollover if the current month is December
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $year += 1;
        }

        // Convert the month back to a 2-digit string
        $nextMonth = str_pad($nextMonth, 2, '0', STR_PAD_LEFT);

        // Create the first and last day of the next month
        $firstDayOfNextMonth = new DateTime("$year-$nextMonth-01");
        $lastDayOfNextMonth = new DateTime("$year-$nextMonth-" . $firstDayOfNextMonth->format('t'));

        return [
            'start' => $firstDayOfNextMonth,
            'end' => $lastDayOfNextMonth
        ];
    }

    function validateSpecialization($specialization)
    {
        // List of valid specializations
        $validData = [
            "ALLERGOLOGIST",
            "ANESTHESIOLOGIST",
            "CARDIOLOGIST",
            "DIABETOLOGIST",
            "ENT",
            "EMERGENCY MEDICINE",
            "ENDOCRINOLOGIST",
            "FAMILY MEDICINE",
            "GASTROENTEROLOGIST",
            "GENERAL PHYSICIAN",
            "GENERAL SURGEON",
            "GERIATRICS",
            "OB-GYNECOLOGIST",
            "HEMATOLOGIST",
            "INFECTIOUS DISEASE SPECIALIST",
            "INTERNAL MEDICINE",
            "NEPHROLOGIST",
            "NEUROLOGIST",
            "ONCOLOGIST",
            "ORTHOPEDIST",
            "PEDIATRICIAN",
            "PULMONOLOGIST",
            "REHABILITATION MEDICINE",
            "RHEUMATOLOGIST",
            "UROLOGIST",
            "OCCUPATIONAL MEDICINE",
            "RESIDENT - FAMILY MEDICINE",
            "RESIDENT - INTERNAL MEDICINE",
            "RESIDENT - PEDIATRICS"
        ];

        // Return true if specialization is in the array, false otherwise
        return in_array(trim($specialization), $validData);
    }

    function validateSpecializationResident($specialization)
    {
        // List of valid specializations
        $validData = [
            "ALLERGOLOGIST",
            "ANESTHESIOLOGIST",
            "CARDIOLOGIST",
            "DIABETOLOGIST",
            "ENT",
            "EMERGENCY MEDICINE",
            "ENDOCRINOLOGIST",
            "GASTROENTEROLOGIST",
            "GENERAL PHYSICIAN",
            "GENERAL SURGEON",
            "GERIATRICS",
            "OB-GYNECOLOGIST",
            "HEMATOLOGIST",
            "INFECTIOUS DISEASE SPECIALIST",
            "NEPHROLOGIST",
            "NEUROLOGIST",
            "ONCOLOGIST",
            "ORTHOPEDIST",
            "PULMONOLOGIST",
            "REHABILITATION MEDICINE",
            "RHEUMATOLOGIST",
            "UROLOGIST",
            "OCCUPATIONAL MEDICINE",
            "RESIDENT - FAMILY MEDICINE",
            "RESIDENT - INTERNAL MEDICINE",
            "RESIDENT - PEDIATRICS"
        ];

        // Return true if specialization is in the array, false otherwise
        return in_array(trim($specialization), $validData);
    }

    function validateSpecializationConsultant($specialization)
    {
        // List of valid specializations
        $validData = [
            "ALLERGOLOGIST",
            "ANESTHESIOLOGIST",
            "CARDIOLOGIST",
            "DIABETOLOGIST",
            "ENT",
            "EMERGENCY MEDICINE",
            "ENDOCRINOLOGIST",
            "FAMILY MEDICINE",
            "GASTROENTEROLOGIST",
            "GENERAL PHYSICIAN",
            "GENERAL SURGEON",
            "GERIATRICS",
            "OB-GYNECOLOGIST",
            "HEMATOLOGIST",
            "INFECTIOUS DISEASE SPECIALIST",
            "INTERNAL MEDICINE",
            "NEPHROLOGIST",
            "NEUROLOGIST",
            "ONCOLOGIST",
            "ORTHOPEDIST",
            "PEDIATRICIAN",
            "PULMONOLOGIST",
            "REHABILITATION MEDICINE",
            "RHEUMATOLOGIST",
            "UROLOGIST",
            "OCCUPATIONAL MEDICINE"
        ];

        // Return true if specialization is in the array, false otherwise
        return in_array(trim($specialization), $validData);
    }

    function validateConsultantResident($consultantResident)
    {
        $validData = ["CONSULTANT", "RESIDENT"];

        return in_array(trim($consultantResident), $validData);
    }

    function validateClassification($classification)
    {
        $validData = ["A", "B", "C"];
        return in_array(trim($classification), $validData);
    }

    function validateDispensingPrescribing($dispensingPrescribing)
    {
        $validData = ["DISPENSING", "PRESCRIBING"];
        return in_array(trim($dispensingPrescribing), $validData);
    }

    function validateTerritoryName($territoryName, $validData)
    {
        return in_array(trim($territoryName), $validData);
    }

    function validateDivision($division)
    {
        $validData = ["1", "2", "3"];
        return in_array(trim($division), $validData);
    }

    function validateWeek($week)
    {
        $validData = ["1", "2", "3", "4"];
        return in_array(trim($week), $validData);
    }

    function validateDay($day)
    {
        $validData = ["1", "2", "3", "4", "5"];
        return in_array(trim($day), $validData);
    }

    function getColumnName($index) {
        $columns = [
            16 => '1st Visit Week',
            17 => '1st Visit Day',
            18 => '2nd Visit Week',
            19 => '2nd Visit Day',
            20 => '3rd Visit Week',
            21 => '3rd Visit Day',
            22 => '4th Visit Week',
            23 => '4th Visit Day'
        ];
        return isset($columns[$index]) ? $columns[$index] : 'Unknown Column';
    }
}
