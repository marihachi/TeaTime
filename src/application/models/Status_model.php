<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model
{
	public function GenerateStatusId()
	{
		$baseTime = 1448722800000;
		$nowTime = floor(microtime(true) * 1000);

		return $nowTime - $baseTime;
	}
	public function Build($status)
	{
		$this->load->model("Account_model", "AccountModel", TRUE);
		$status["text"] = html_escape($status["text"]);
		$user = $this->AccountModel->FindById($status["user_id"]);
		unset($user["password_hash"]);
		$status["user"] = $user;

		return $status;
	}
	public function Create($userId, $text, $imageCount, $replyToId = null)
	{
		$data = [];
		$data["id"] = $this->GenerateStatusId();
		$data["user_id"] = $userId;
		$data["text"] = $text;
		$data["image_count"] = $imageCount;
		if ($replyToId !== null)
			$data["reply_to_id"] = $replyToId;

		if ($this->db->insert('tea_time_statuses', $data))
			return $this->FindById($data["id"]);
		else
			return false;
	}
	public function Destroy($id)
	{
		$data = ["id" => $id];
		return !!$this->db->delete('tea_time_statuses', $data);
	}
	public function FindById($id)
	{
		$data = ["id" => $id];
		$query = $this->db->get_where('tea_time_statuses', $data, 1);
		if ($query->num_rows() > 0)
			return $this->Build($query->result_array()[0]);
		else
			return false;
	}
	public function Find($userIds, $limit = null, $sinceId = null, $untilId = null)
	{
		$where = [];

		$limit = ($limit === null) ? 20 : $limit;

		if ($sinceId !== null)
			if (!!$this->FindById($sinceId))
				$where["id >"] = $sinceId;

		else if ($untilId !== null)
			if (!!$this->FindById($untilId))
				$where["id <"] = $untilId;

		$this->db
			->from("tea_time_statuses")
			->where($where)
			->where_in("user_id", $userIds)
			->limit($limit)
			->order_by("id", "desc");

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return array_map(function($s) {
				return $this->Build($s);
			}, $query->result_array());
		}
		else
			return false;
	}
}