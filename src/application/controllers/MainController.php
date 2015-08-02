<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller
{
	public function index()
	{
		$this->load->view('entrance');
		//$this->load->view('home');
	}
	
	public function newAccount()
	{
		$this->load->view('new-account');
	}
}
