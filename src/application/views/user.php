<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<title><?php echo $user["name"];?>さんのページ - TeaTime | ティータイムにピッタリなSNS</title>
		<style>
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
			<img src="/teatime/image/icon/<?php echo $user["screenName"];?>">
			<p><?php echo $user["name"]."(@".$user["screenName"].")";?></p>
			<p>bio: <?php echo $user["bio"];?></p>
			<p>Lv: <?php echo $user["lv"];?></p>
			<p>Exp: <?php echo $user["exp"];?></p>
			<p><a href=/tea-time>ホームへ</a></p>
		</main>
	</body>
</html>