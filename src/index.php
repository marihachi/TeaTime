<?php
//session_start();

header('X-FRAME-OPTIONS:DENY');

// Includes
require_once("module/Config.php");
require_once("module/QueryManager.php");
require_once("module/Router.php");

set_error_handler(function ($errno, $errstr, $errfile, $errline ) {
   	$ex = new ErrorException($errstr, 0, $errno, $errfile, $errline);
	Router::Instance()->ErrorHandle($ex);
});

//
// ルータを取得
//
$router = Router::Instance();

//
// クエリマネージャを取得
//
$queryManager = QueryManager::Instance();

//
// ルート追加
//
$router->Add("get", "/", function($routeParams) {
	$skinny = new Skinny();
	if($params["login"] == "true")
		$skinny->SkinnyDisplay("views/home.html", null);
	else
		$skinny->SkinnyDisplay("views/entrance.html", null);
});

$router->Add("get", "/:screenName", function($routeParams) {
	$p = array();
	$p["userId"] = $routeParams["screenName"];
	$skinny = new Skinny();
	$skinny->SkinnyDisplay("views/user.html", $p);
});

//
// ルーティング
//
$router->Routing();