<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebAPI_FriendController extends CI_Controller
{
	public function follow()
	{
		header("Content-Type: application/json; charset=utf-8");

		$this->load->library('user_agent');
		$this->load->helper("MY_CheckReferer");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata('is_login');
		$meScreenName = $this->session->userdata('me')['screen_name'];
		$meUserId = $this->session->userdata('me')['id'];

		$info = array();
		if ($isLogin)
		{
			$post = $this->input->post();
			if (array_key_exists('screen_name', $post))
			{
				$this->load->model('Account_model', 'AccountModel', TRUE);
				$this->load->model('Friend_model', 'FriendModel', TRUE);

				$screenName = urldecode($post['screen_name']);
				if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
				{
					if ($screenName !== $meScreenName)
					{
						if ($destUser = $this->AccountModel->FindByScreenName($screenName))
						{
							$srcId = $meUserId;
							$destId = $destUser['id'];

							if ($this->FriendModel->Find($srcId, $destId) === false)
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
								http_response_code(400);
								$info['error']['code'] = 203;
								$info['error']['message'] = 'Follow was failed.';
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
	
	public function unfollow()
	{
		header("Content-Type: application/json; charset=utf-8");

		$this->load->library('user_agent');
		$this->load->helper("MY_CheckReferer");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata('is_login');
		$meScreenName = $this->session->userdata('me')['screen_name'];
		$meUserId = $this->session->userdata('me')['id'];

		$info = array();
		if ($isLogin)
		{
			$post = $this->input->post();
			if (array_key_exists('screen_name', $post))
			{
				$this->load->model('Account_model', 'AccountModel', TRUE);
				$this->load->model('Friend_model', 'FriendModel', TRUE);

				$screenName = urldecode($post['screen_name']);
				if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
				{
					if ($screenName !== $meScreenName)
					{
						if ($destUser = $this->AccountModel->FindByScreenName($screenName))
						{
							$srcId = $meUserId;
							$destId = $destUser['id'];

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
	
	// フォロー関係を返します
	public function show()
	{
		header("Content-Type: application/json; charset=utf-8");

		$this->load->library('user_agent');
		$this->load->helper("MY_CheckReferer");

		if (!CheckReferer($this->agent))
			return;
			
		$isLogin = $this->session->userdata('is_login');
		$meScreenName = $this->session->userdata('me')['screen_name'];
		$meUserId = $this->session->userdata('me')['id'];

		$info = array();
		if ($isLogin)
		{
			$get = $this->input->get();
			if (array_key_exists('screen_name', $get))
			{
				$this->load->model('Account_model', 'AccountModel', TRUE);
				$this->load->model('Friend_model', 'FriendModel', TRUE);

				$screenName = urldecode($get['screen_name']);
				if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
				{
					if ($screenName !== $meScreenName)
					{
						if ($user = $this->AccountModel->FindByScreenName($screenName))
						{
							$isFollower = !!$this->FriendModel->Find($user['id'], $meUserId);
							$isFollowing = !!$this->FriendModel->Find($meUserId, $user['id']);
							$info['is_follower'] = $isFollower;
							$info['is_following'] = $isFollowing;
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
}