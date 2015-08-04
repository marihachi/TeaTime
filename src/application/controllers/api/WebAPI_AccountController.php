<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_AccountController extends CI_Controller
{
	private function _checkReferer()
	{
		$this->load->library('user_agent');

		if ($this->agent->is_referral() || $this->agent->referrer() === "")
		{
			http_response_code(403);
			$info['error']['code'] = 300;
			$info['error']['message'] = "Invalid referer.";
			echo json_encode($info);
			return false;
		}
		return true;
	}
	
	public function generate()
	{
		$invalidSN = array();
		$invalidSN[] = 'signup';
		$invalidSN[] = 'home';
		$invalidSN[] = 'tos';

		header("Content-Type: application/json; charset=utf-8");

		if (!$this->_checkReferer())
			return;
		
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
				$isValidScreenName = false;
				if (preg_match('/^[0-9]+$/i', $screenName) === 0)
				{
					if (strlen($screenName) >= 3 && strlen($screenName) <= 15)
					{
						if (array_search($screenName, $invalidSN) === false)
						{
							if ($resUser = $this->UserModel->Create($screenName, $password, $name, $bio))
							{
								$isValidScreenName = true;

								unset($resUser->password_hash);
								$info['user'] = $resUser;

								$data = array();
								$data['is_login'] = true;
								$data['screen_name'] = $screenName;
								$data['name'] = $resUser->name;
								$data['user_id'] = $resUser->id;

								$this->session->set_userdata($data);
							}
							else
							{
								http_response_code(500);
								$info['error']['code'] = 200;
								$info['error']['message'] = 'Failed to execute.';
							}
						}
					}
				}
				
				if (!$isValidScreenName)
				{
					// Invalid Screen Name
					http_response_code(400);
					$info['error']['code'] = 103;
					$info['error']['message'] = "Invalid parameter.";
					$info['error']['parameter'] = "screen_name";
				}
			}
			else
			{
				http_response_code(400);
				$info['error']['code'] = 101;
				$info['error']['message'] = "Some invalid parameters.";
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 100;
			$info['error']['message'] = 'Some required parameters.';
		}
		echo json_encode($info);
	}
	
	public function login()
	{
		header("Content-Type: application/json; charset=utf-8");
		
		if (!$this->_checkReferer())
			return;
		
		$info = array();
		$post = $this->input->post();
		if (array_key_exists('screen_name', $post) && array_key_exists('password', $post))
		{
			$this->load->model('User_model', 'UserModel', TRUE);

			$screenName = urldecode($post['screen_name']);
			$password = urldecode($post['password']);

			$isSuccess = false;
			if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
			{
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
			}

			if (!$isSuccess)
			{
				http_response_code(400);
				$info['error']['code'] = 101;
				$info['error']['message'] = "Some invalid parameters.";
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 100;
			$info['error']['message'] = 'Some required parameters.';
		}
		echo json_encode($info);
	}
	
	public function logout()
	{
		header("Content-Type: application/json; charset=utf-8");
		
		if (!$this->_checkReferer())
			return;
		
		$info = array();
		
		if ($this->session->userdata('is_login'))
		{
			$this->session->sess_destroy();
			$info['message'] = "Logout successful.";
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 200;
			$info['error']['message'] = 'Failed to execute.';
		}
		echo json_encode($info);
	}
}