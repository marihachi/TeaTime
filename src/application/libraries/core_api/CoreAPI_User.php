<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreAPI_User
{
	public function follow($meScreenName, $meUserId, $post)
	{
		header("Content-Type: application/json; charset=utf-8");
		$res = "";
		$this->load->helper("Helper_ApiResponseBuilder");

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
								$res = BuildSuccessResponse('Follow was successful.');
							else
								$res = BuildErrorResponse(500, 105, 'Failed to execute.');
						}
						else
							$res = BuildErrorResponse(400, 203, 'Follow was failed.');
					}
					else
						$res = BuildErrorResponse(400, 200, 'User not found.');
				}
				else
					$res = BuildErrorResponse(400, 201, 'This user is you.');
			}
			else
				$res = BuildErrorResponse(400, 102, "Some invalid parameters.");
		}
		else
			$res = BuildErrorResponse(400, 101, 'Some required parameters.');

		return $res;
	}

	public function unfollow($meScreenName, $meUserId, $post)
	{
		header("Content-Type: application/json; charset=utf-8");

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
							if ($this->FriendModel->Destroy($srcId, $destId))
								$res = BuildSuccessResponse('Unfollow was successful.');
							else
								$res = BuildErrorResponse(500, 105, 'Failed to execute.');
						}
						else
							$res = BuildErrorResponse(400, 204, 'Unfollow was failed.');
					}
					else
						$res = BuildErrorResponse(400, 200, 'User not found.');
				}
				else
					$res = BuildErrorResponse(400, 201, 'This user is you.');
			}
			else
				$res = BuildErrorResponse(400, 102, "Some invalid parameters.");
		}
		else
			$res = BuildErrorResponse(400, 101, 'Some required parameters.');

	return $res;
	}
	
	public function friendstatus($meScreenName, $meUserId, $get)
	{
		header("Content-Type: application/json; charset=utf-8");
		
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
						$res = BuildErrorResponse(400, 200, 'User not found.');
				}
				else
					$res = BuildErrorResponse(400, 201, 'This user is you.');
			}
			else
				$res = BuildErrorResponse(400, 102, "Some invalid parameters.");
		}
		else
			$res = BuildErrorResponse(400, 101, 'Some required parameters.');

		return $res;
	}
}