<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friend_model extends CI_Model
{
	public function Create($src_account_id, $dest_account_id)
	{
		$data = array();
		$data["src_account_id"] = $src_account_id;
		$data["dest_account_id"] = $dest_account_id;

		if(!$this->db->insert('tea_time_friends', $data))
			return false;

		return $data;
	}

	public function Destroy($src_account_id, $dest_account_id)
	{
		$data = array();
		$data["src_account_id"] = $src_account_id;
		$data["dest_account_id"] = $dest_account_id;

		if(!$this->db->delete('tea_time_friends', $data))
			return false;

		return true;
	}

	public function GetFollowee($target_account_id)
	{
		$data = array();
		$data["src_account_id"] = $target_account_id;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
		{
			$ids = (array)$query->result();
			return $ids;
		}
		else
		{
			return false;
		}
	}

	public function GetFollower($target_account_id)
	{
		$data = array();
		$data["dest_account_id"] = $target_account_id;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
		{
			$ids = (array)$query->result();
			return $ids;
		}
		else
		{
			return false;
		}
	}
}