<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreAPI_User
{
	public function follow($meScreenName, $meUserId, $post)
	{
		header("Content-Type: application/json; charset=utf-8");
		$this->load->model('Account_model', 'AccountModel', TRUE);
		$this->load->model('Friend_model', 'FriendModel', TRUE);
		$res = "";

		if (!ApiParamValidate($post, ['screen_name']))
			return;

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
							$res = BuildSuccessResponse("successful.");
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

		return $res;
	}

	public function unfollow($meScreenName, $meUserId, $post)
	{
		header("Content-Type: application/json; charset=utf-8");
		$this->load->model('Account_model', 'AccountModel', TRUE);
		$this->load->model('Friend_model', 'FriendModel', TRUE);
		$res = "";

		if (!ApiParamValidate($post, ['screen_name']))
			return;

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
							$res = BuildSuccessResponse('successful.');
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

		return $res;
	}

	public function friendstatus($meScreenName, $meUserId, $get)
	{
		header("Content-Type: application/json; charset=utf-8");
		$this->load->model('Account_model', 'AccountModel', TRUE);
		$this->load->model('Friend_model', 'FriendModel', TRUE);

		if (!ApiParamValidate($get, ['screen_name']))
			return;

		$screenName = urldecode($get['screen_name']);

		if (preg_match('/^[a-z0-9_]+$/i', $screenName) === 1)
		{
			if ($screenName !== $meScreenName)
			{
				if ($user = $this->AccountModel->FindByScreenName($screenName))
				{
					$isFollower = !!$this->FriendModel->Find($user['id'], $meUserId);
					$isFollowing = !!$this->FriendModel->Find($meUserId, $user['id']);

					$res = BuildErrorResponse([
						"message" => "successful.",
						"is_follower" => $isFollower, 
						"is_following" => $isFollowing
					]);
				}
				else
					$res = BuildErrorResponse(400, 200, 'User not found.');
			}
			else
				$res = BuildErrorResponse(400, 201, 'This user is you.');
		}
		else
			$res = BuildErrorResponse(400, 102, "Some invalid parameters.");

		return $res;
	}
}
