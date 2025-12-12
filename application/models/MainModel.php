<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mainModel extends CI_Model
{

	function getRecords($tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial)
	{
		$q = $this->db->select('*')
			->distinct()
			->from($tables[0]);

		//JOIN---------------------------------------
		if (!empty($join)) {
			for ($i = 0; $i < count($join); $i++) {
				$q->join($tables[$i + 1], $join[$i], $joinType[$i]);
			}
		}

		//WHERE--------------------------------------
		if (!empty($where)) {
			for ($i = 0; $i < count($where); $i++) {
				$q->where($fieldName[$i], $where[$i]);
			}
		}

		//WHERE SPECIAL--------------------------------------
		if (!empty($whereSpecial)) {
			for ($i = 0; $i < count($whereSpecial); $i++) {
				$q->where($whereSpecial[$i]);
			}
		}


		//LIKE--------------------------------------
		if (!empty($like)) {
			for ($i = 0; $i < count($like); $i++) {
				$q->like($fieldNameLike[$i], $like[$i]);
			}
		}


		//ORDER BY----------------------------------
		if (!empty($sortBy)) {
			for ($i = 0; $i < count($sortBy); $i++) {
				$q->order_by($sortBy[$i], $sortOrder[$i]);
			}
		}
		//LIMIT----------------------------------
		if (!empty($limit)) {
			$q->limit($limit[0], $limit[1]);
		}

		$data = $q->get()->result();
		return $data;
	}

	function getRecordsData($data, $tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial, $groupBy)
	{

		//DATA--------------------------------------
		$dataSelect = null;
		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if ($i == 0) {
					$dataSelect = $dataSelect . $data[$i];
				} else {
					$dataSelect = $dataSelect . ", " . $data[$i];
				}
			}
		}

		$q = $this->db->select($dataSelect)
			->distinct()
			->from($tables[0]);

		//JOIN---------------------------------------
		if (!empty($join)) {
			for ($i = 0; $i < count($join); $i++) {
				$q->join($tables[$i + 1], $join[$i], $joinType[$i]);
			}
		}

		//WHERE--------------------------------------
		if (!empty($where)) {
			for ($i = 0; $i < count($where); $i++) {
				$q->where($fieldName[$i], $where[$i]);
			}
		}

		//WHERE SPECIAL--------------------------------------
		if (!empty($whereSpecial)) {
			for ($i = 0; $i < count($whereSpecial); $i++) {
				$q->where($whereSpecial[$i]);
			}
		}


		//LIKE--------------------------------------
		if (!empty($like)) {
			for ($i = 0; $i < count($like); $i++) {
				$q->like($fieldNameLike[$i], $like[$i]);
			}
		}


		//ORDER BY----------------------------------
		if (!empty($sortBy)) {
			for ($i = 0; $i < count($sortBy); $i++) {
				$q->order_by($sortBy[$i], $sortOrder[$i]);
			}
		}
		//LIMIT----------------------------------
		if (!empty($limit)) {
			$q->limit($limit[0], $limit[1]);
		}
		//GROUP BY----------------------------------
		if (!empty($groupBy)) {
			for ($i = 0; $i < count($groupBy); $i++) {
				$q->group_by($groupBy[$i]);
			}
		}

		$data = $q->get()->result();
		return $data;
	}

	function updateRecords($tableName, $fieldName, $where, $data)
	{
		//WHERE--------------------------------------
		if (!empty($where)) {
			for ($i = 0; $i < count($where); $i++) {
				$this->db->where($fieldName[$i], $where[$i]);
			}
		}
		$this->db->update($tableName, $data);

		return 1;
	}

	function insertRecords($tableName, $data)
	{
		return $this->db->insert($tableName, $data);
	}

	public function insertRecordsRetData($tableName, $data, $primaryKey = 'id')
	{
		$inserted = $this->db->insert($tableName, $data);

		if ($inserted) {
			$insert_id = $this->db->insert_id();

			if ($primaryKey) {
				$this->db->where($primaryKey, $insert_id);
				return $this->db->get($tableName)->row_array();
			}

			// fallback if no primary key is given
			return $data;
		}

		return false;
	}

	function insertRecordsRetID($tableName, $data, $primaryKey = 'id')
	{
		$inserted = $this->db->insert($tableName, $data);

		if ($inserted) {
			return $this->db->insert_id(); // This assumes the primary key is AUTO_INCREMENT
		} else {
			return false;
		}
	}


	function insertRecordsBatch($tableName, $data)
	{
		return $this->db->insert_batch($tableName, $data);
	}

	function updateRecordsBatch($tableName, $data, $whereKey)
	{
		return $this->db->update_batch($tableName, $data, $whereKey);
	}

	function deleteRecords($tableName, $fieldName, $where)
	{
		if (!empty($where)) {
			for ($i = 0; $i < count($where); $i++) {
				$this->db->where($fieldName[$i], $where[$i]);
			}
		}
		$this->db->delete($tableName);

		return 1;
	}
}
