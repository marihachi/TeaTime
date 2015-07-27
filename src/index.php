<?php

// Includes
require_once("module/Config.php");
require_once("module/Core.php");
require_once("module/Router.php");

// Webのルータを生成
$router = new Router();

// ルート追加 & パラメータ編集
$router->Add("/", "views/home.html", function($params) {
	return null;
});

$router->Add("/user", "views/user.html", function($params) {
	$p = array();
	$p["userId"] = array_key_exists("id", $params)
		? ($params["id"]+0 >= 1)
			? ($params["id"]+0)
			: -1
		: -1;
	return $p;
});

// ルーティング
$router->Routing();