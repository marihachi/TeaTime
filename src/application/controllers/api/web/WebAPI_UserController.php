<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_UserController extends CI_Controller
{
	public function follow()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata('is_login');

		if ($isLogin)
		{
			$meScreenName = $this->session->userdata('me')['screen_name'];
			$meUserId = $this->session->userdata('me')['id'];
			$post = $this->input->post();

			$this->load->model("Coreapi_user", "CoreAPI_User");
			$res = $this->CoreAPI_User->follow($meScreenName, $meUserId, $post);
		}
		else
			$res = BuildErrorResponse(400, 106, 'Please request with login.');

		echo $res;
	}

	public function unfollow()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata('is_login');

		if ($isLogin)
		{
			$meScreenName = $this->session->userdata('me')['screen_name'];
			$meUserId = $this->session->userdata('me')['id'];
			$post = $this->input->post();

			$this->load->model("Coreapi_user", "CoreAPI_User");
			$res = $this->CoreAPI_User->unfollow($meScreenName, $meUserId, $post);
		}
		else
			$res = BuildErrorResponse(400, 106, 'Please request with login.');

		echo $res;
	}

	public function friendstatus()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata('is_login');

		if ($isLogin)
		{
			$meScreenName = $this->session->userdata('me')['screen_name'];
			$meUserId = $this->session->userdata('me')['id'];
			$get = $this->input->get();
			
			$this->load->model("Coreapi_user", "CoreAPI_User");
			$res = $this->CoreAPI_User->friendstatus($meScreenName, $meUserId, $get);
		}
		else
			$res = BuildErrorResponse(400, 106, 'Please request with login.');

		echo $res;
	}
}