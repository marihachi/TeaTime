<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPage extends CI_Controller
{
	public function index()
	{
		$screenName = $this->uri->segment(1);
		
		$this->load->model('User_model', 'UserModel', TRUE);
		$resUser = $this->UserModel->FindByScreenName($screenName);

		if ($resUser !== null)
		{
			$data = array();
			$data['screenName'] = $resUser->screenName;
			$data['name'] = $resUser->name;
			$data['bio'] = $resUser->bio;
			$data['lv'] = $resUser->lv;
			$data['exp'] = $resUser->exp;
			$data['headerUrl'] = '';
			$data['iconUrl'] = '';

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
