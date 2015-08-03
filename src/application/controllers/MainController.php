<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller
{
	public function index()
	{
		$isLogin = $this->session->userdata('is_login');
		
		if ($isLogin)
		{
			$data = array();
			$data['user_id'] = $this->session->userdata('user_id');
			$this->load->view('home', $data);
		}
		else
		{
			$this->load->view('entrance');
		}
	}
	
	public function newAccount()
	{
		$this->load->view('new-account');
	}
}
