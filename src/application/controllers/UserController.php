<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function index($screenName)
	{
		$this->load->model('Account_model', 'AccountModel', TRUE);

		if ($account = $this->AccountModel->FindByScreenName($screenName))
		{
			$data = array();
			$data['screenName'] = $account->screen_name;
			$data['name'] = $account->name;
			$data['bio'] = $account->bio;
			$data['lv'] = $account->lv;
			$data['exp'] = $account->exp;

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
