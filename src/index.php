<?php

// Includes
require_once("module/Core.php");
require_once("module/Router.php");

// Webのルータを生成
$webRouter = new Router();

// ルートを追加して使用するパラメータを編集
$webRouter->Add("/", "views/home.html", function($params) {
	return null;
});
$webRouter->Add("/user", "views/user.html", function($params) {
	$p = array();
	$p["userId"] = array_key_exists("id", $params)
		? ($params["id"]+0 >= 1)
			? ($params["id"]+0)
			: -1
		: -1;
	return $p;
});

// ルーティング
$webRouter->Routing();