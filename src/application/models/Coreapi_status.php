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

		if ($status = $this->StatusModel->Create($meUserId, $text, 0))
			$res = BuildSuccessResponse([
				"message" => "successful.",
				'status' => $status
			]);
		else
			$res = BuildErrorResponse(500, 105, 'Failed to execute.');

		return $res;
	}
	// タイムラインを返します
	public function timeline($meUserId, $get)
	{
		$this->load->model('Status_model', 'StatusModel', TRUE);

		$sinceCursor = array_key_exists('since_cursor', $get) ? $get['since_cursor'] : null;
		$untilCursor = array_key_exists('until_cursor', $get) ? $get['until_cursor'] : null;

		if ($statuses = $this->StatusModel->Find($meUserId, 20, $sinceCursor, $untilCursor))
			$res = BuildSuccessResponse([
				"message" => "successful.",
				'statuses' => $statuses
			]);
		else
			$res = BuildErrorResponse(500, 105, 'Failed to execute.');
	}
}