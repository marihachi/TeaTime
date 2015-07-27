<?php

error_reporting(-1);

// Includes
require_once("Core.php");
require_once("Router.php");

// Webのルータを生成
$webRouter = new Router();

// ルートを追加して使用するパラメータを編集
$webRouter->Add("/", "views/home.html", function($params) {
	return array();
});
$webRouter->Add("/user", "views/user.html", function($params) {
	return array();
});

// ルーティング
$webRouter->Routing();