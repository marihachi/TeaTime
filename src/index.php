<?php

// Includes
require_once("Core.php");
require_once("Router.php");

$router = Router::Instance();

// ルートを追加
$router->Add("/", function() {
	echo "This is TopPage.";
});

$router->Add("/abc", function() {
	echo "This is ABC.";
});

// ルーティング
$router->Routing();