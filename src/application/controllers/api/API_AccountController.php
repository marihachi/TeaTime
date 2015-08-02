<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_AccountController extends CI_Controller
{
	public function generate($extention)
	{
		$info = array();

		if (preg_match('/^(json)$/i', $extention) === 1)
		{
			header("Content-Type: application/json; charset=utf-8");
			
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
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 100;
			$info['error']['message'] = 'Unknown file type.';
		}
		echo json_encode($info);
	}
}