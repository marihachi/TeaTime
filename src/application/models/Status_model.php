<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model
{
	public function Create($userId, $text, $replyToId, $imageCount)
	{
		$data = array();
		$data["id"] = uniqid(rand(10000, 19999));
		$data["userId"] = $userId;
		$data["text"] = $text;
		$data["replyToId"] = $replyToId;
		$data["imageCount"] = $imageCount;
		
		$this->db->insert('tea_time_statuses', $data);
		
		return $data["id"];
	}

	public function Remove($id)
	{
		$data = array();
		$data["id"] = $id;
		
		$this->db->delete('tea_time_statuses', $data);
	}

	public function FindById($id)
	{
		$data = array();
		$data["id"] = $id;
		
		$query = $this->db->get_where('tea_time_statuses', $data, 1);
		if ($query->num_rows() > 0)
		{
			return $query->result()[0];
		}
		else
		{
			return null;
		}
	}
}