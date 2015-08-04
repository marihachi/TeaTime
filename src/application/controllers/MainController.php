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
			$data['is_login'] = $this->session->userdata('is_login');
			$data['screen_name'] = $this->session->userdata('screen_name');
			$data['name'] = $this->session->userdata('name');
			$data['user_id'] = $this->session->userdata('user_id');
			$this->load->view('home', $data);
		}
		else
		{
			$this->load->view('entrance');
		}
	}
	
	public function signup()
	{
		$isLogin = $this->session->userdata('is_login');
		
		if ($isLogin)
		{
			show_error('既にログイン済みです。', 403);
		}
		else
		{
			$this->load->view('signup');
		}
	}
}
