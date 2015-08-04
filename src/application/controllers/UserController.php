<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function index($screenName)
	{
		$this->load->model('Account_model', 'AccountModel', TRUE);

		if ($account = $this->AccountModel->FindByScreenName($screenName))
		{
			$user = array();
			$user['user'] = $account;
			$this->load->view('user', $user);
		}
		else
		{
			show_error("User Not Found", 404);
		}
	}
}
