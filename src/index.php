<?php
//session_start();
//
//if (!isset($_SESSION['AccessToken'])) {
//  $_SESSION['AccessToken'] = 0;
//}

header('X-FRAME-OPTIONS:DENY');

// Includes
require_once("module/Config.php");
require_once("module/Core.php");
require_once("module/Router.php");

// ルータを取得
$router = Router::Instance();

// ルート追加 & パラメータ編集
$router->Add("get", "/", function($render, $params) {
	if($params["login"] == "true")
		$render->SkinnyDisplay("views/home.html", null);
	else
		$render->SkinnyDisplay("views/entrance.html", null);
});

$router->Add("get", "/user", function($render, $params) {
	$p = array();
	$p["userId"] = array_key_exists("id", $params)
		? ($params["id"]+0 >= 1)
			? ($params["id"]+0)
			: -1
		: -1;
	$render->SkinnyDisplay("views/user.html", $p);
});

// ルーティング
$router->Routing();