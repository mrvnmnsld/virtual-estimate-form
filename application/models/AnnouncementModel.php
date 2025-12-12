<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AnnouncementModel extends CI_Model
{
    private $table = 'announcements_tbl';
    private $rolesTable = 'announcements_roles_tbl';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all announcements with pagination, filtering, and sorting
     */
    public function getAnnouncements($limit = null, $offset = null, $search = null, $active_only = false, $orderBy = 'a.created_at', $orderDir = 'DESC')
    {
        $this->db->select('a.*, CONCAT(u.first_name," ",u.last_name) as created_by_name, GROUP_CONCAT(r.role SEPARATOR ", ") as role_names')
                 ->from($this->table . ' a')
                 ->join('user_tbl u', 'a.created_by = u.id', 'left')
                 ->join($this->rolesTable . ' ar', 'a.id = ar.announcement_id', 'left')
                 ->join('roles_tbl r', 'ar.role_id = r.role_id', 'left');

        if ($active_only) {
            $this->db->where('a.is_active', 1);
            $this->db->where('a.start_date <=', date('Y-m-d H:i:s'));
            $this->db->group_start();
            $this->db->where('a.end_date IS NULL');
            $this->db->or_where('a.end_date >=', date('Y-m-d H:i:s'));
            $this->db->group_end();
        }

        if ($search) {
            $this->db->group_start();
            $this->db->like('a.title', $search);
            $this->db->or_like('a.content', $search);
            $this->db->group_end();
        }

        $this->db->group_by('a.id');

        // Sorting - allow ordering by selected alias or column
        if (!empty($orderBy)) {
            $this->db->order_by($orderBy, (strtoupper($orderDir) === 'ASC' ? 'ASC' : 'DESC'));
        } else {
            $this->db->order_by('a.created_at', 'DESC');
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Get announcements for specific user roles
     */
    public function getAnnouncementsForUser($userRoles, $limit = null)
    {
        $this->db->select('a.*, CONCAT(u.first_name," ",u.last_name) as created_by_name, GROUP_CONCAT(r.role SEPARATOR ", ") as role_names')
                 ->from($this->table . ' a')
                 ->join('user_tbl u', 'a.created_by = u.id', 'left')
                 ->join($this->rolesTable . ' ar', 'a.id = ar.announcement_id', 'inner')
                 ->join('roles_tbl r', 'ar.role_id = r.role_id', 'left')
                 ->where('a.is_active', 1)
                 ->where('a.start_date <=', date('Y-m-d H:i:s'));

        $this->db->group_start();
        $this->db->where('a.end_date IS NULL');
        $this->db->or_where('a.end_date >=', date('Y-m-d H:i:s'));
        $this->db->group_end();

        // Filter by user roles - much cleaner with normalized structure
        if (!empty($userRoles)) {
            $this->db->where_in('ar.role_id', $userRoles);
        }

        $this->db->group_by('a.id');
        $this->db->order_by('a.created_at', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Get single announcement by ID
     */
    public function getAnnouncement($id)
    {
        $this->db->select('a.*, CONCAT(u.first_name," ",u.last_name) as created_by_name')
                 ->from($this->table . ' a')
                 ->join('user_tbl u', 'a.created_by = u.id', 'left')
                 ->where('a.id', $id);

        $announcement = $this->db->get()->row_array();
        
        if ($announcement) {
            // Get associated roles
            $roles = $this->db->select('ar.role_id, r.role')
                             ->from($this->rolesTable . ' ar')
                             ->join('roles_tbl r', 'ar.role_id = r.role_id', 'left')
                             ->where('ar.announcement_id', $id)
                             ->get()
                             ->result_array();
            
            $announcement['roles'] = $roles;
            $announcement['role_ids'] = array_column($roles, 'role_id');
            $announcement['role_names'] = array_column($roles, 'role');
        }

        return $announcement;
    }

    /**
     * Create new announcement
     */
    public function createAnnouncement($data, $roles = [])
    {
        $this->db->trans_start();
        
        // Insert announcement
        $announcementData = [
            'title' => $data['title'],
            'content' => $data['content'],
            'start_date' => $data['start_date'] ?? date('Y-m-d H:i:s'),
            'end_date' => $data['end_date'] ?? null,
            'is_active' => $data['is_active'] ?? 1,
            'created_by' => $data['created_by'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert($this->table, $announcementData);
        $announcementId = $this->db->insert_id();
        
        // Insert roles
        if (!empty($roles) && $announcementId) {
            $roleData = [];
            foreach ($roles as $roleId) {
                $roleData[] = [
                    'announcement_id' => $announcementId,
                    'role_id' => $roleId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            $this->db->insert_batch($this->rolesTable, $roleData);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $announcementId;
    }

    /**
     * Update announcement
     */
    public function updateAnnouncement($id, $data, $roles = [])
    {
        $this->db->trans_start();
        
        // Update announcement
        $announcementData = [
            'title' => $data['title'],
            'content' => $data['content'],
            'end_date' => $data['end_date'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        $this->db->update($this->table, $announcementData);
        
        // Update roles - delete existing and insert new ones
        if (!empty($roles)) {
            // Delete existing roles
            $this->db->where('announcement_id', $id);
            $this->db->delete($this->rolesTable);
            
            // Insert new roles
            $roleData = [];
            foreach ($roles as $roleId) {
                $roleData[] = [
                    'announcement_id' => $id,
                    'role_id' => $roleId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            $this->db->insert_batch($this->rolesTable, $roleData);
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Delete announcement
     */
    public function deleteAnnouncement($id)
    {
        $this->db->trans_start();
        
        // Delete roles first (foreign key constraint)
        $this->db->where('announcement_id', $id);
        $this->db->delete($this->rolesTable);
        
        // Delete announcement
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Toggle announcement status
     */
    public function toggleStatus($id, $status)
    {
        $data = [
            'is_active' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Get total count for pagination
     */
    public function getAnnouncementsCount($search = null, $active_only = false)
    {
        $this->db->from($this->table);

        if ($active_only) {
            $this->db->where('is_active', 1);
            $this->db->where('start_date <=', date('Y-m-d H:i:s'));
            $this->db->group_start();
            $this->db->where('end_date IS NULL');
            $this->db->or_where('end_date >=', date('Y-m-d H:i:s'));
            $this->db->group_end();
        }

        if ($search) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Disable expired announcements (for cron job)
     */
    public function disableExpiredAnnouncements()
    {
        $this->db->where('is_active', 1);
        $this->db->where('end_date IS NOT NULL');
        $this->db->where('end_date <', date('Y-m-d H:i:s'));
        
        return $this->db->update($this->table, [
            'is_active' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
