<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_StatusController extends CI_Controller
{
	public function show()
	{
		if (!CheckReferer($this->agent))
			return;

		$get = $this->input->get();
		$isLogin = $this->session->userdata('is_login');

		if ($isLogin)
		{
			$this->load->library("CoreAPI_Status");
			$res = $this->CoreAPI_Status->show($get);
		}
		else
			$res = BuildErrorResponse(400, 106, 'Please request with login.');
	}

	public function update()
	{
		if (!CheckReferer($this->agent))
			return;

		$post = $this->input->post();
		$isLogin = $this->session->userdata('is_login');

		if ($isLogin)
		{
			$meUserId = $this->session->userdata('me')['id'];

			$this->load->library("CoreAPI_Status");
			$res = $this->CoreAPI_Status->update($meUserId, $post);
		}
		else
			$res = BuildErrorResponse(400, 106, 'Please request with login.');

		echo $res;
	}
}