<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class UserController extends CI_Controller
{
	public function index($screenName)
	{
		$this->load->model("Account_model", "AccountModel", TRUE);
		$this->load->model("Coreapi_user", "CoreAPI_User", true);

		$isVisibleFollowButton = true;
		$followState = "不明";
		$isFollowing = false;
		$isFollower = false;

		if ($target = $this->AccountModel->FindByScreenName($screenName))
		{
			$me = $this->session->userdata("me");
			$res = $this->CoreAPI_User->friendstatus($me["screen_name"], $me["id"], ["screen_name" => $target["screen_name"]]);
			$resArray = json_decode($res, true);
			if (IsSuccessResponse($res))
			{
				$isFollowing = $resArray["is_following"];
				$isFollower = $resArray["is_follower"];
				if ($isFollower)
					$followState = "フォローされています。";
				else
					$followState = "フォローされていません。";	
			}
			else
			{
				switch($resArray["error"]["code"])
				{
					case 106:
						$followState = "あなたです。";
						$isVisibleFollowButton = false;
						break;
					case 201:
						$followState = "";
						$isVisibleFollowButton = false;
						break;
					default:
						break;
				}
			}
			
			$this->load->view("user", [
				"followState" => $followState,
				"isFollowing" => $isFollowing,
				"isFollower" => $isFollower,
				"isFollowing" => $isFollowing,
				"isVisibleFollowButton" => $isVisibleFollowButton,
				"target" => $target
			]);
		}
		else
		{
			show_error("User Not Found", 404);
		}
	}
}
