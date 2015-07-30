<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $heading; ?></title>
	<style type="text/css">
		body {
			background: #D59B6D;
			color: #fff;
		}
		main {
			margin: auto;
			position: absolute;
			top: 0px;
			right: 0px;
			bottom: 0px;
			left: 0px;
			height: 14em;
			text-align: center;
		}
	</style>
</head>
<body>
	<main>
		<h1><?php echo $heading; ?></h1>
		<p><?php echo $message; ?></p>
		<p><a href=/tea-time>ホームへ</a></p>
	</main>
</body>
</html>