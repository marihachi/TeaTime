<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class WebAPI_AccountController extends CI_Controller
{
	public function create()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$this->load->model("Account_model", "AccountModel", true);

		$invalidSN = array(
			"signup",
			"home",
			"tos"
		);

		$post = $this->input->post();

		if (!ApiParamValidate($post, ['screen_name', 'password', 'name', 'bio']))
			return;

		$screenName = urldecode($post["screen_name"]);
		$password = urldecode($post["password"]);
		$name = urldecode($post["name"]);
		$bio = urldecode($post["bio"]);

		if (preg_match("/^[a-z0-9_]+$/i", $screenName) === 1 && preg_match("/^[a-z0-9_-]+$/i", $password) === 1 && preg_match("/^[^\s　]+$/u", $name) === 1)
		{
			$isValidScreenName = false;
			if (preg_match("/^[0-9]+$/i", $screenName) === 0)
			{
				if (strlen($screenName) >= 3 && strlen($screenName) <= 15)
				{
					if (array_search($screenName, $invalidSN) === false)
					{
						if ($resUser = $this->AccountModel->Create($screenName, $password, $name, $bio))
						{
							$isValidScreenName = true;

							unset($resUser["password_hash"]);
							$res = BuildSuccessResponse([
								"message" => "successful.",
								"user" => $resUser
							]);

							$data = array();
							$data["is_login"] = true;
							$data["me"] = $resUser;
							$this->session->set_userdata($data);

							$this->load->model("Coreapi_user", "CoreAPI_User");
							$res = $this->CoreAPI_User->follow("mrhc", 1, ["screen_name" => $resUser["screen_name"]]);
						}
						else
							$res = BuildErrorResponse(500, 105, "Failed to execute.");
					}
				}
			}
			if (!$isValidScreenName)
			{
				$res = BuildErrorResponse(400, 104, [
					"message" => "Invalid parameter.",
					"parameter" => "screen_name"
				]);
			}
		}
		else
			$res = BuildErrorResponse(400, 102, "Some invalid parameters.");

		echo $res;
	}

	public function login()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$this->load->model("Account_model", "AccountModel", true);

		$post = $this->input->post();

		if (!ApiParamValidate($post, ['screen_name', 'password']))
			return;

		$screenName = urldecode($post["screen_name"]);
		$password = urldecode($post["password"]);

		$isSuccess = false;
		if (preg_match("/^[a-z0-9_]+$/i", $screenName) === 1)
		{
			if ($resUser = $this->AccountModel->FindByScreenName($screenName))
			{
				if (password_verify($password, $resUser["password_hash"]))
				{
					$isSuccess = true;
					$res = BuildSuccessResponse("successful.");

					$data = [
						"is_login" => true,
						"me" => $resUser
					];

					$this->session->set_userdata($data);
				}
			}
		}
		if (!$isSuccess)
			$res = BuildErrorResponse(400, 102, "Some invalid parameters.");

		echo $res;
	}

	public function logout()
	{
		header("Content-Type: application/json; charset=utf-8");

		if (!CheckReferer($this->agent))
			return;

		$isLogin = $this->session->userdata("is_login");

		if ($isLogin)
		{
			$this->session->sess_destroy();
			$res = BuildSuccessResponse("successful.");
		}
		else
			$res = BuildErrorResponse(400, 106, "Please request with login.");

		echo $res;
	}
}
