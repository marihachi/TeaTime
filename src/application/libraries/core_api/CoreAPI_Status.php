<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreAPI_Status
{
	public function show($get)
	{
		header("Content-Type: application/json; charset=utf-8");
		$res = "";

		if (array_key_exists('status_id', $get))
		{
			$statusId = $get["status_id"];

			$this->load->model('Status_model', 'StatusModel', TRUE);

			if ($status = $this->StatusModel->FindById($statusId))
				$res = BuildSuccessResponse([
					"message" => "successful.",
					"status" => $status
				]);
			else
				$res = BuildErrorResponse(500, 105, 'Failed to execute.');
		}
		else
			$res = BuildErrorResponse(400, 101, 'Some required parameters.');

		return $res;
	}

	public function update($meUserId, $post)
	{
		header("Content-Type: application/json; charset=utf-8");
		$res = "";

		if (array_key_exists('text', $post))
		{
			$text = urldecode($post["text"]);
			
			$this->load->model('Status_model', 'StatusModel', TRUE);

			if ($status = $this->StatusModel->Create($meUserId, $text, 0))
				$res = BuildSuccessResponse([
					"message" => "successful.",
					'status' => $status
				]);
			else
				$res = BuildErrorResponse(500, 105, 'Failed to execute.');
		}
		else
			$res = BuildErrorResponse(400, 101, 'Some required parameters.');

		return $res;
	}
}