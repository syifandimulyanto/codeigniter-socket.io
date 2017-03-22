<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Custommodel extends CI_Model 
{
	public function get_chats($group)
	{
		$this->db->select('chats.content, chats.create_at, chats.users_id');
		$this->db->select('users.first_name, users.last_name, users.avatar');
		$this->db->from('chats');
		$this->db->join('users', 'chats.users_id = users.id', 'LEFT');
		$this->db->where('chats.group', $group);
		$this->db->order_by('chats.create_at', 'ASC');
		return $this->db->get()->result();
	}	

}