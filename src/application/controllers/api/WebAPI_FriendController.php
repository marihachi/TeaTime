<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_FriendController extends CI_Controller
{

	private function _followUnfollow($isFollow, $screenName)
	{
		header("Content-Type: application/json; charset=utf-8");

		$this->load->library('user_agent');
		$this->load->helper("MY_CheckReferer");

		if (!CheckReferer($this->agent))
			return;

		$s_isLogin = $this->session->userdata('is_login');
		$s_screenName = $this->session->userdata('me')['screen_name'];
		$s_userId = $this->session->userdata('me')['id'];

		$info = array();
		if ($s_isLogin)
		{
			$post = $this->input->post();
			if (array_key_exists('screen_name', $post))
			{
				$this->load->model('Account_model', 'AccountModel', TRUE);
				$this->load->model('Friend_model', 'FriendModel', TRUE);

				$screenName = urldecode($post['screen_name']);
				if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
				{
					if ($screenName !== $s_screenName)
					{
						if ($resUser = $this->AccountModel->FindByScreenName($screenName))
						{
							$srcId = $s_userId;
							$destId = $resUser['id'];

							if ($isFollow)
							{
								if ($this->FriendModel->Create($srcId, $destId))
								{
									$info['message'] = 'Follow was successful.';
								}
								else
								{
									http_response_code(500);
									$info['error']['code'] = 105;
									$info['error']['message'] = 'Failed to execute.';
								}
							}
							else
							{
								if ($this->FriendModel->Destroy($srcId, $destId))
								{
									$info['message'] = 'UnFollow was successful.';
								}
								else
								{
									http_response_code(500);
									$info['error']['code'] = 105;
									$info['error']['message'] = 'Failed to execute.';
								}
							}
						}
						else
						{
							http_response_code(400);
							$info['error']['code'] = 200;
							$info['error']['message'] = 'User not found.';
						}
					}
					else
					{
						http_response_code(400);
						$info['error']['code'] = 201;
						$info['error']['message'] = 'This user is you.';
					}
				}
				else
				{
					http_response_code(400);
					$info['error']['code'] = 102;
					$info['error']['message'] = "Some invalid parameters.";
				}
			}
			else
			{
				http_response_code(400);
				$info['error']['code'] = 101;
				$info['error']['message'] = 'Some required parameters.';
			}
		}
		else
		{
			http_response_code(400);
			$info['error']['code'] = 106;
			$info['error']['message'] = 'Please request with login.';
		}
		echo json_encode($info);
	}
	
	public function follow()
	{
		_followUnfollow(true);
	}
	
	public function unfollow()
	{
		_followUnfollow(false);
	}
}