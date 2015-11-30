<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model
{
	public function Create($screenName, $password, $name, $bio)
	{
		$data = [];
		$data["screen_name"] = $screenName;
		$data["name"] = $name;
		$data["bio"] = $bio;
		$data["password_hash"] = password_hash($password, PASSWORD_BCRYPT);

		if(!$this->db->insert('tea_time_accounts', $data))
		{
			//$error = $this->db->error();
			return false;
		}
		$query = $this->db->get_where('tea_time_accounts', array('screen_name' => $screenName), 1);
		return $query->result_array()[0];
	}

	public function Update($screenName = null, $name = null, $bio = null, $password = null)
	{
		$data = [];
		if ($screenName !== null)
			$data["screen_Name"] = $screenName;
		if ($name !== null)
			$data["name"] = $name;
		if ($bio !== null)
			$data["bio"] = $bio;
		if ($password !== null)
			$data["password_hash"] = password_hash($password, PASSWORD_BCRYPT);

		return !!$this->db->update('tea_time_accounts', $data);
	}

	public function FindByScreenName($screenName)
	{
		$data = [];
		$data["screen_name"] = $screenName;
		
		$query = $this->db->get_where('tea_time_accounts', $data, 1);
		if ($query->num_rows() > 0)
		{
			$user = $query->result_array()[0];
			return $user;
		}
		else
		{
			return false;
		}
	}

	public function FindById($id)
	{
		$query = $this->db->get_where('tea_time_accounts', array('id' => $id), 1);
		if ($query->num_rows() > 0)
		{
			$user = $query->result_array()[0];
			return $user;
		}
		else
		{
			return false;
		}
	}
}