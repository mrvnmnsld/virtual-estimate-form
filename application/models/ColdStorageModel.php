<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ColdStorageModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new temperature record
     */
    public function create($data)
    {
        $insertData = [
            'user_id' => $data['user_id'],
            'branch_id' => $data['branch_id'] ?? $_SESSION['currentUser']['branch_id'],
            'temperature' => $data['temperature'],
            'recorded_at' => $data['recorded_at'] ?? date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $inserted = $this->db->insert('cold_storage_temps', $insertData);
        
        if ($inserted) {
            return $this->db->insert_id();
        }
        
        return false;
    }

    /**
     * Get temperature records for DataTable - following existing patterns
     */
    public function getTemps($searchValue = '', $columnMap = [], $orderBy = 'cold_storage_temps.id', $orderDir = 'DESC', $limit = 10, $offset = 0)
    {
        // Base query following existing patterns with proper branch handling
        $this->db->select('
            cold_storage_temps.id,
            cold_storage_temps.temperature,
            cold_storage_temps.recorded_at,
            cold_storage_temps.created_at,
            cold_storage_temps.branch_id,
            user_tbl.first_name,
            user_tbl.last_name,
            roles_tbl.desc as user_role,
            branch_tbl.branch_name
        ');
        
        $this->db->from('cold_storage_temps');
        $this->db->join('user_tbl', 'user_tbl.id = cold_storage_temps.user_id', 'left');
        $this->db->join('roles_tbl', 'roles_tbl.role_id = user_tbl.role_id', 'left');
        $this->db->join('branch_tbl', 'branch_tbl.branch_id = cold_storage_temps.branch_id', 'left');
        
        // Apply branch filtering if applicable - following existing patterns
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->where('cold_storage_temps.branch_id', $_SESSION['currentUser']['branch_id']);
        }
        
        // Search functionality
        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('cold_storage_temps.temperature', $searchValue);
            $this->db->or_like('user_tbl.first_name', $searchValue);
            $this->db->or_like('user_tbl.last_name', $searchValue);
            $this->db->or_like('roles_tbl.desc', $searchValue);
            $this->db->group_end();
        }
        
        // Ordering and pagination
        $this->db->order_by($orderBy, $orderDir);
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get total count for DataTable
     */
    public function getTotalCount($searchValue = '')
    {
        $this->db->from('cold_storage_temps');
        $this->db->join('user_tbl', 'user_tbl.id = cold_storage_temps.user_id', 'left');
        $this->db->join('roles_tbl', 'roles_tbl.role_id = user_tbl.role_id', 'left');
        $this->db->join('branch_tbl', 'branch_tbl.branch_id = cold_storage_temps.branch_id', 'left');
        
        // Apply branch filtering if applicable
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->where('cold_storage_temps.branch_id', $_SESSION['currentUser']['branch_id']);
        }
        
        // Search functionality
        if (!empty($searchValue)) {
            $this->db->group_start();
            $this->db->like('cold_storage_temps.temperature', $searchValue);
            $this->db->or_like('user_tbl.first_name', $searchValue);
            $this->db->or_like('user_tbl.last_name', $searchValue);
            $this->db->or_like('roles_tbl.desc', $searchValue);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Get filtered count for DataTable
     */
    public function getFilteredCount($searchValue = '')
    {
        return $this->getTotalCount($searchValue);
    }

    /**
     * Get chart data based on period - returns individual data points
     */
    public function getChartData($period = '7day')
    {
        $whereClause = '';
        
        // Use current date as reference for date calculations
        $referenceDate = date('Y-m-d');
        
        switch ($period) {
            case '7day':
                $whereClause = "recorded_at >= DATE_SUB('$referenceDate', INTERVAL 7 DAY)";
                break;
            case '1month':
                $whereClause = "recorded_at >= DATE_SUB('$referenceDate', INTERVAL 1 MONTH)";
                break;
            case 'ytd':
                $whereClause = "recorded_at >= DATE_FORMAT('$referenceDate', '%Y-01-01')";
                break;
            default:
                $whereClause = "recorded_at >= DATE_SUB('$referenceDate', INTERVAL 7 DAY)";
        }

        $this->db->select('
            recorded_at,
            temperature
        ');
        
        $this->db->from('cold_storage_temps');
        
        // Apply branch filtering if applicable
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->where('cold_storage_temps.branch_id', $_SESSION['currentUser']['branch_id']);
        }
        
        $this->db->where($whereClause);
        $this->db->order_by('recorded_at', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get latest temperature record
     */
    public function getLatestTemp()
    {
        $this->db->select('
            cold_storage_temps.temperature,
            cold_storage_temps.recorded_at,
            user_tbl.first_name,
            user_tbl.last_name
        ');
        
        $this->db->from('cold_storage_temps');
        $this->db->join('user_tbl', 'user_tbl.id = cold_storage_temps.user_id', 'left');
        
        // Apply branch filtering if applicable
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->join('employee_tbl', 'employee_tbl.user_id = user_tbl.id', 'left');
            $this->db->join('branch_employee_tbl', 'branch_employee_tbl.employee_id = employee_tbl.employee_id', 'left');
            $this->db->join('branch_tbl', 'branch_tbl.branch_admin_id = user_tbl.id', 'left');
            $this->db->where('COALESCE(branch_tbl.branch_id, branch_employee_tbl.branch_id) =', $_SESSION['currentUser']['branch_id']);
        }
        
        $this->db->order_by('cold_storage_temps.created_at', 'DESC');
        $this->db->limit(1);
        
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Get temperature statistics
     */
    public function getTempStats()
    {
        $this->db->select('
            COUNT(*) as total_readings,
            AVG(temperature) as avg_temp,
            MIN(temperature) as min_temp,
            MAX(temperature) as max_temp
        ');
        
        $this->db->from('cold_storage_temps');
        
        // Apply branch filtering if applicable
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->where('cold_storage_temps.branch_id', $_SESSION['currentUser']['branch_id']);
        }
        
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Get single temperature record by ID
     */
    public function getTempById($id)
    {
        $this->db->select('
            cold_storage_temps.*,
            user_tbl.first_name,
            user_tbl.last_name,
            roles_tbl.desc as user_role
        ');
        
        $this->db->from('cold_storage_temps');
        $this->db->join('user_tbl', 'user_tbl.id = cold_storage_temps.user_id', 'left');
        $this->db->join('roles_tbl', 'roles_tbl.role_id = user_tbl.role_id', 'left');
        $this->db->where('cold_storage_temps.id', $id);
        
        // Apply branch filtering if applicable
        if (isset($_SESSION['currentUser']['role_id']) && $_SESSION['currentUser']['role_id'] != 1) {
            $this->db->join('employee_tbl', 'employee_tbl.user_id = user_tbl.id', 'left');
            $this->db->join('branch_employee_tbl', 'branch_employee_tbl.employee_id = employee_tbl.employee_id', 'left');
            $this->db->join('branch_tbl', 'branch_tbl.branch_admin_id = user_tbl.id', 'left');
            $this->db->where('COALESCE(branch_tbl.branch_id, branch_employee_tbl.branch_id) =', $_SESSION['currentUser']['branch_id']);
        }
        
        $query = $this->db->get();
        return $query->row();
    }
}
