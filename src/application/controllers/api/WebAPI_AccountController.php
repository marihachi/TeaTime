<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_AccountController extends CI_Controller
{
	public function generate()
	{
		header("Content-Type: application/json; charset=utf-8");
		
		$info = array();
		$post = $this->input->post();
		if (array_key_exists('screen_name', $post) && array_key_exists('password', $post) && array_key_exists('name', $post) && array_key_exists('bio', $post))
		{
			$this->load->model('User_model', 'UserModel', TRUE);

			$screenName = urldecode($post['screen_name']);
			$password = urldecode($post['password']);
			$name = urldecode($post['name']);
			$bio = urldecode($post['bio']);

			if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1 && preg_match('/^[a-z0-9_-]+$/i', $password) === 1 && preg_match('/^[^\s　]+$/u', $name) === 1)
			{
				if ($resUser = $this->UserModel->Create($screenName, $password, $name, $bio))
				{
					unset($resUser->password_hash);
					$info['user'] = $resUser;
				}
				else
				{
					http_response_code(500);
					$info['error']['code'] = 103;
					$info['error']['message'] = 'Failed to execute.';
				}
			}
			else
			{
				http_response_code(400);
				$info['error']['code'] = 102;
				$info['error']['message'] = "Value given for one or more parameter is invalid.";
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 101;
			$info['error']['message'] = 'No value given for one or more required parameters.';
		}
		echo json_encode($info);
	}
	
	public function login()
	{
		header("Content-Type: application/json; charset=utf-8");
		
		$info = array();
		$post = $this->input->post();
		if (array_key_exists('screen_name', $post) && array_key_exists('password', $post))
		{
			$this->load->model('User_model', 'UserModel', TRUE);

			$screenName = urldecode($post['screen_name']);
			$password = urldecode($post['password']);

			if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
			{
				$isSuccess = false;
				if ($resUser = $this->UserModel->FindByScreenName($screenName))
				{
					if (password_verify($password, $resUser->password_hash))
					{
						$isSuccess = true;

						$data = array();
						$data['is_login'] = true;
						$data['screen_name'] = $screenName;
						$data['name'] = $resUser->name;
						$data['user_id'] = $resUser->id;
						$this->session->set_userdata($data);

						$info['message'] = "Login successful.";
					}
				}

				if (!$isSuccess)
				{
					http_response_code(400);
					$info['error']['code'] = 200;
					$info['error']['message'] = "screen_name or password is invalid.";
				}
			}
			else
			{
				http_response_code(400);
				$info['error']['code'] = 102;
				$info['error']['message'] = "Value given for one or more parameter is invalid.";
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 101;
			$info['error']['message'] = 'No value given for one or more required parameters.';
		}
		echo json_encode($info);
	}
	
	public function logout()
	{
		header("Content-Type: application/json; charset=utf-8");
		
		$info = array();
		
		if ($this->session->userdata('is_login'))
		{
			$this->session->sess_destroy();
			$info['message'] = "Logout successful.";
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 201;
			$info['error']['message'] = 'Not logged in.';
		}
		echo json_encode($info);
	}
}