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
			$data['is_login'] = $isLogin;
			$data['me'] = $this->session->userdata('me');
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