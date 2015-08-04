<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model
{
	public function Create($screen_name, $password, $name, $bio)
	{
		$data = array();
		$data["screen_name"] = $screen_name;
		$data["name"] = $name;
		$data["bio"] = $bio;
		$data["password_hash"] = password_hash($password, PASSWORD_BCRYPT);

		if(!$this->db->insert('tea_time_accounts', $data))
		{
			//$error = $this->db->error();
			return false;
		}
		$query = $this->db->get_where('tea_time_accounts', array('screen_name' => $screen_name), 1);
		return $query->result()[0];
	}

	public function Update($screen_name = null, $name = null, $bio = null, $password = null)
	{
		$data = array();
		if ($screen_name !== null)
			$data["screen_Name"] = $screen_name;
		if ($name !== null)
			$data["name"] = $name;
		if ($bio !== null)
			$data["bio"] = $bio;
		if ($password !== null)
			$data["password_hash"] = password_hash($password, PASSWORD_BCRYPT);

		$this->db->update('tea_time_accounts', $data);
	}

	public function FindByScreenName($screen_name)
	{
		$data = array();
		$data["screen_name"] = $screen_name;
		
		$query = $this->db->get_where('tea_time_accounts', $data, 1);
		if ($query->num_rows() > 0)
		{
			$user = $query->result()[0];
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
			$user = $query->result()[0];
			return $user;
		}
		else
		{
			return false;
		}
	}
}