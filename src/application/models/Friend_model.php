<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friend_model extends CI_Model
{
	// フォロー関係を作成
	public function Create($srcAccountId, $destAccountId)
	{
		$data = array();
		$data["src_account_id"] = $srcAccountId;
		$data["dest_account_id"] = $destAccountId;

		if($this->db->insert('tea_time_friends', $data))
			return $data;
		else
			return false;
	}

	// フォロー関係を破棄
	public function Destroy($srcAccountId, $destAccountId)
	{
		$data = array();
		$data["src_account_id"] = $srcAccountId;
		$data["dest_account_id"] = $destAccountId;

		return !!$this->db->delete('tea_time_friends', $data);
	}

	// 対象をフォローしているユーザーの一覧を取得
	public function GetFollowers($targetAccountId)
	{
		$data = array();
		$data["dest_account_id"] = $targetAccountId;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
			return (array)$query->result();
		else
			return false;
	}

	// 対象がフォローしているユーザーの一覧を取得
	public function GetFollowings($targetAccountId)
	{
		$data = array();
		$data["src_account_id"] = $targetAccountId;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
			return (array)$query->result();
		else
			return false;
	}
}