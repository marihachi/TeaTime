<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function Insert($screenName, $name, $bio)
	{
		$date = array();
		$date["screenName"] = $screenName;
		$date["name"] = $name;
		$date["bio"] = $bio;
		
		$this->db->insert('tea_time_users', $date);
	}

	public function Update($screenName = null, $name = null, $bio = null)
	{
		$date = array();
		if ($screenName !== null)
			$date["screenName"] = $screenName;
		if ($name !== null)
			$date["name"] = $name;
		if ($bio !== null)
			$date["bio"] = $bio;
		
		$this->db->update('tea_time_users', $date);
	}

	public function FindByScreenName($screenName)
	{
		$query = $this->db->get_where('tea_time_users', array('screenName' => $screenName), 1);
		if ($query->num_rows() > 0)
		{
			return $query->result()[0];
		}
		else
		{
			return null;
		}
	}

	public function FindById($id)
	{
		$query = $this->db->get_where('tea_time_users', array('id' => $id), 1);
		if ($query->num_rows() > 0)
		{
			$user = $query->result()[0];
			return $user;
		}
		else
		{
			return null;
		}
	}
}