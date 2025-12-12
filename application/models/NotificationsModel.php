<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificationsModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_unread_for_user($userId, $limit = 10)
	{
		$this->db->from('notifications_tbl');
		$this->db->group_start()
			->where('user_id', $userId)
			->or_where('user_id IS NULL', null, false) // global notifications
		->group_end();
		$this->db->where('is_read', 0);
		$this->db->order_by('created_at', 'DESC');
		if ($limit) {
			$this->db->limit($limit);
		}
		return $this->db->get()->result_array();
	}

	public function count_unread_for_user($userId)
	{
		$this->db->from('notifications_tbl');
		$this->db->group_start()
			->where('user_id', $userId)
			->or_where('user_id IS NULL', null, false)
		->group_end();
		$this->db->where('is_read', 0);
		return (int) $this->db->count_all_results();
	}

	public function mark_read($id, $userId)
	{
		$this->db->where('id', $id);
		$this->db->group_start()
			->where('user_id', $userId)
			->or_where('user_id IS NULL', null, false)
		->group_end();
		return $this->db->update('notifications_tbl', [
			'is_read' => 1,
			'read_at' => date('Y-m-d H:i:s')
		]);
	}

	public function mark_all_read($userId)
	{
		$this->db->group_start()
			->where('user_id', $userId)
			->or_where('user_id IS NULL', null, false)
		->group_end();
		$this->db->where('is_read', 0);
		return $this->db->update('notifications_tbl', [
			'is_read' => 1,
			'read_at' => date('Y-m-d H:i:s')
		]);
	}

	public function create($data)
	{
		$insert = [
			'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
			'title' => $data['title'],
			'body' => isset($data['body']) ? $data['body'] : null,
			'icon' => isset($data['icon']) ? $data['icon'] : null,
			'url' => isset($data['url']) ? $data['url'] : null,
			'is_read' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'meta' => isset($data['meta']) ? json_encode($data['meta']) : null,
		];

		$this->db->insert('notifications_tbl', $insert);
		if ($this->db->affected_rows() > 0) {
			$insert['id'] = $this->db->insert_id();
			return $insert;
		}
		return false;
	}

	public function getUserIdsByRole($roleId)
	{
		$this->db->select('id');
		$this->db->from('user_tbl');
		$this->db->where('role_id', $roleId);
		$this->db->where('is_active', 1);
		$result = $this->db->get()->result_array();
		return array_column($result, 'id');
	}

	public function getUserIdsByBranch($branchId)
	{
		$this->db->distinct();
		$this->db->select('user_tbl.id');
		$this->db->from('user_tbl');
		$this->db->join('employee_tbl', 'employee_tbl.user_id = user_tbl.id', 'left');
		$this->db->join('branch_employee_tbl', 'branch_employee_tbl.employee_id = employee_tbl.employee_id', 'left');
		$this->db->join('branch_tbl', 'branch_tbl.branch_admin_id = user_tbl.id', 'left');
		$this->db->where('user_tbl.is_active', 1);
		$this->db->group_start()
			->where('branch_employee_tbl.branch_id', $branchId)
			->or_where('branch_tbl.branch_id', $branchId)
		->group_end();
		$result = $this->db->get()->result_array();
		return array_column($result, 'id');
	}

	public function getBranchAdminUserId($branchId)
	{
		if (!$branchId) return null;
		
		$this->db->select('branch_admin_id');
		$this->db->from('branch_tbl');
		$this->db->where('branch_id', $branchId);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->row()->branch_admin_id;
		}
		return null;
	}

	public function getSuperAdminUserIds()
	{
		$this->db->select('id');
		$this->db->from('user_tbl');
		$this->db->where_in('role_id', [1, 6]); // role_id 1 = super admin, role_id 6 = inventory master
		$this->db->where('is_active', 1);
		
		$result = $this->db->get();
		$userIds = [];
		foreach ($result->result() as $row) {
			$userIds[] = $row->id;
		}
		return $userIds;
	}

	public function getUserIdsByIsAdmin($isAdminValue)
	{
		$this->db->select('user_tbl.id');
		$this->db->from('user_tbl');
		$this->db->join('roles_tbl', 'roles_tbl.role_id = user_tbl.role_id', 'inner');
		$this->db->where('roles_tbl.is_admin', $isAdminValue);
		$this->db->where('user_tbl.is_active', 1);
		$result = $this->db->get()->result_array();
		return array_column($result, 'id');
	}
}


