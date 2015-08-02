<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function index($screenName)
	{
		$this->load->model('User_model', 'UserModel', TRUE);

		if ($resUser = $this->UserModel->FindByScreenName($screenName))
		{
			$data = array();
			$data['screenName'] = $resUser->screen_name;
			$data['name'] = $resUser->name;
			$data['bio'] = $resUser->bio;
			$data['lv'] = $resUser->lv;
			$data['exp'] = $resUser->exp;

			$user = array();
			$user['user'] = $data;
			$this->load->view('user', $user);
		}
		else
		{
			$this->load->view('errors/html/error_404', array("heading" => "404 User Not Found", "message" => "Does not exist is ScreenName"));
		}
	}
}
