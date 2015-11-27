<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class WebAPI_AccountController extends CI_Controller
{
	public function create()
	{
		if (!CheckReferer($this->agent))
			return;

		$post = $this->input->post();
		
		$this->load->library("CoreAPI_Account");
		$this->CoreAPI_Account->create($post);
	}

	public function login()
	{
		if (!CheckReferer($this->agent))
			return;
		
		$post = $this->input->post();
		
		$this->load->library("CoreAPI_Account");
		$this->CoreAPI_Account->login($post);
	}

	public function logout()
	{
		if (!CheckReferer($this->agent))
			return;
			
		$this->load->library("CoreAPI_Account");
		$this->CoreAPI_Account->logout();
	}
}