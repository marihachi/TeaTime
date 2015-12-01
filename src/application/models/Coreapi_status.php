<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coreapi_status extends CI_Model
{
	// 指定されたステータスを返します。
	public function show($get)
	{
		$this->load->model('Status_model', 'StatusModel', TRUE);

		if (!ApiParamValidate($get, ['status_id']))
			return;

		$statusId = $get["status_id"];

		if ($status = $this->StatusModel->FindById($statusId))
			$res = BuildSuccessResponse([
				"message" => "successful.",
				"status" => $status
			]);
		else
			$res = BuildErrorResponse(500, 105, 'Failed to execute.');

		return $res;
	}
	// ステータスを投稿します。
	public function update($meUserId, $post)
	{
		$this->load->model('Status_model', 'StatusModel', TRUE);

		if (!ApiParamValidate($post, ['text']))
			return;

		$text = urldecode($post["text"]);

		if (strlen($text) <= 400)
		{
			if ($status = $this->StatusModel->Create($meUserId, $text, 0))
				$res = BuildSuccessResponse([
					"message" => "successful.",
					'status' => $status
				]);
			else
				$res = BuildErrorResponse(500, 105, 'Failed to execute.');
		}
		else
			$res = BuildErrorResponse(400, 100, 'text is too long.');

		return $res;
	}
	// ホームタイムラインを返します
	public function timeline($meUserId, $get)
	{
		$this->load->model('Status_model', 'StatusModel', TRUE);
		$this->load->model('Friend_model', 'FriendModel', TRUE);

		$limit = array_key_exists('limit', $get) ? ($get['limit'] <= 30 ? $get['limit'] : 30) : 20;
		$sinceId = array_key_exists('since_id', $get) ? $get['since_id'] : null;
		$untilId = array_key_exists('until_id', $get) ? $get['until_id'] : null;

		$timelineUsers = $this->FriendModel->GetFollowings($meUserId);
		$timelineUsers[] = $meUserId;

		$statuses = $this->StatusModel->Find($timelineUsers, $limit, $sinceId, $untilId);

		$res = BuildSuccessResponse([
			"message" => "successful.",
			'statuses' => !$statuses ? [] : $statuses
		]);

		return $res;
	}
}