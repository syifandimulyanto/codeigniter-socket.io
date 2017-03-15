<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Globalmodel extends CI_Model 
{
	public function get_list($table, $where = FALSE, $order = FALSE )
	{
		if ($where) {
			$this->db->where($where);
		}
		if ($order) {
			$this->db->order_by($order['key'], $order['val']);
		}
		return $this->db->get($table)->result();
	}	

	public function insert($table, $param)
	{
		$this->db->insert($table, $param);
		return $this->db->insert_id();
	}

	public function update($table, $set, $where)
	{
		$this->db->where($where);
		$this->db->update($table, $set);
		return $this->db->affected_rows();
	}

	public function delete($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}

	public function count($table, $where)
	{
		if ($where) {
			$this->db->where($where);
		}
		$this->db->from($table);
		return $this->db->count_all_results();
	}

}