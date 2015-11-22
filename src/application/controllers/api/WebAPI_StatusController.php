<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_StatusController extends CI_Controller
{
	public function update()
	{
		header("Content-Type: application/json; charset=utf-8");

		$this->load->library('user_agent');
		$this->load->helper("MY_CheckReferer");

		if (!CheckReferer($this->agent))
			return;

		$info = array();
		$post = $this->input->post();
		if (array_key_exists('text', $post) )
		{
			$this->load->model('Status_model', 'StatusModel', TRUE);

			if ($this->session->userdata('is_login'))
			{
				$me = $this->session->userdata('me');

				$text = urldecode($post['text']);

				if ($status = $this->StatusModel->Create($me['id'], $text, 0))
				{
					$info['status'] = $status;
				}
				else
				{
					http_response_code(500);
					$info['error']['code'] = 105;
					$info['error']['message'] = 'Failed to execute.';
				}
			}
			else
			{
				http_response_code(400);
				$info['error']['code'] = 106;
				$info['error']['message'] = 'Please request with login.';
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 101;
			$info['error']['message'] = 'Some required parameters.';
		}
		echo json_encode($info);
	}
}