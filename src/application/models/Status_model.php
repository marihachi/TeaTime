<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model
{
	public function Create($accountId, $text, $imageCount, $replyToId = null)
	{
		$data = array();
		$data["id"] = uniqid(rand(10000, 19999));
		$data["accountId"] = $accountId;
		$data["text"] = $text;
		$data["imageCount"] = $imageCount;
		if ($replyToId !== null)
			$data["replyToId"] = $replyToId;
		
		if (!$this->db->insert('tea_time_statuses', $data))
			return false;
		
		return $this->FindById($id);
	}

	public function Destroy($id)
	{
		$data = array();
		$data["id"] = $id;
		
		if (!$this->db->delete('tea_time_statuses', $data)
			return false;
			
		return true;
	}

	public function FindById($id)
	{
		$data = array();
		$data["id"] = $id;
		
		$query = $this->db->get_where('tea_time_statuses', $data, 1);
		if ($query->num_rows() > 0)
		{
			$status = (array)$query->result()[0];
			return $status;
		}
		else
		{
			return false;
		}
	}
}