<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friend_model extends CI_Model
{
	// フォロー関係を作成
	public function Create($srcUserId, $destUserId)
	{
		$data = array();
		$data["src_user_id"] = $srcUserId;
		$data["dest_user_id"] = $destUserId;

		if($this->db->insert('tea_time_friends', $data))
			return $data;
		else
			return false;
	}
	// フォロー関係を破棄
	public function Destroy($srcUserId, $destUserId)
	{
		$data = [
			"src_user_id" => $srcUserId,
			"dest_user_id" => $destUserId
		];
		return !!$this->db->delete('tea_time_friends', $data);
	}
	// フォロー関係が存在するかどうかを取得します
	public function IsExist($srcUserId, $destUserId)
	{
		$data = [
			"src_user_id" => $srcUserId,
			"dest_user_id" => $destUserId
		];
		$query = $this->db->get_where('tea_time_friends', $data);
		return !!$query->num_rows() > 0;
	}

	// 対象をフォローしているユーザーの一覧を取得
	public function GetFollowers($targetUserId)
	{
		$data = array();
		$data["dest_user_id"] = $targetUserId;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return array_map(function($r)
			{
				return $r["src_user_id"];
			}, $result);
		}
		else
			return false;
	}

	// 対象がフォローしているユーザーの一覧を取得
	public function GetFollowings($targetUserId)
	{
		$data = array();
		$data["src_user_id"] = $targetUserId;

		$query = $this->db->get_where('tea_time_friends', $data);
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return array_map(function($r)
			{
				return $r["dest_user_id"];
			}, $result);
		}
		else
			return false;
	}
}