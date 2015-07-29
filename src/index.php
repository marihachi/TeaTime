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
$router->Add("get", "/", function($render, $routeParams) {
	if($params["login"] == "true")
		$render->SkinnyDisplay("views/home.html", null);
	else
		$render->SkinnyDisplay("views/entrance.html", null);
});

$router->Add("get", "/:screenName", function($render, $routeParams) {
	$p = array();
	$p["userId"] = $routeParams["screenName"];
	$render->SkinnyDisplay("views/user.html", $p);
});

// ルーティング
$router->Routing();