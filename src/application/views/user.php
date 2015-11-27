<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$followState = "不明";
$isVisibleFollowButton = true;
$this->load->library("CoreAPI_User");
$res = $this->CoreAPI_User->friendstatus($meScreenName, $meUserId, $get);
if (IsSuccessResponse($res))
{
	
}
else
{
	$resArray = json_decode($res, true);
	
	switch($resArray['error']['code']) {
		case 106:
			$followState = "あなたです。";
			$isVisibleFollowButton = false;
			break;
		case 201:
			$followState = "";
			$isVisibleFollowButton = false;
			break;
		default:
			break;
	}
}
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset=UTF-8>
		<meta http-equiv=X-UA-Compatible content="IE=edge" />
		<meta name=viewport content="width=device-width, initial-scale=1" />
		<title><?=$user['name']?>さんのページ - TeaTime | ティータイムにピッタリなSNS</title>
		<script src=//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js></script>
		<script>
			$(function() {
				<?php
				if (!$isVisibleFollowButton) echo '$("#follow-button").css({display: "none"});';
				?>
				var follow = function() {
					$("#follow-button").unbind("click", follow);
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/user/follow", {
						type: "post",
						dataType: "json",
						data: {"screen_name": '<?=$user['screen_name']?>'}
					}).done(function() {
						$("#follow-button")
							.text("フォロー中")
							.bind("click", unfollow);
					}).fail(function(data) {
						$("#follow-button").bind("click", follow)
						alert("フォローに失敗しました (" + data.responseJSON.error.message + ")");
					});
				};
				var unfollow = function() {
					$("#follow-button").unbind("click", unfollow);
					$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/user/unfollow", {
						type: "post",
						dataType: "json",
						data: {"screen_name": "<?=$user['screen_name']?>"}
					}).done(function() {
						$("#follow-button")
							.text("フォロー")
							.bind("click", follow);
					}).fail(function() {
						$("#follow-button").bind("click", unfollow)
						alert("アンフォローに失敗しました");
					});
				}
				$.ajax("http://marihachi.php.xdomain.jp/tea-time/api/web/friend/show", {
					type: "get",
					dataType: "json",
					data: {"screen_name": "<?=$user['screen_name']?>"}
				}).done(function(data) {
					if (data.is_following) {
						$("#follow-button")
							.text("フォロー中")
							.click(unfollow);
					} else {
						$("#follow-button")
							.text("フォロー")
							.click(follow);
					}
					if (data.is_follower) {
						$("#friend-status").text("フォローされています。");
					} else {
						$("#friend-status").text("フォローされていません。");
					}
				}).fail(function(data) {
					switch(data.responseJSON.error.code) {
						case 106:
							$("#friend-status").text("あなたです。");
							$("#follow-button").css({display: "none"});
							break;
						case 201:
							$("#follow-button").css({display: "none"});
							break;
						default:
							alert("ページの読み込みに失敗しました。再読み込みしてください。");
							break;
					}
				});
			});
		</script>
		<style>
			body {
				background-color: rgba(213, 155, 109, .8);
			}
			#profile-area {
				display: flex;
				justify-content: center;
				padding: 10px;
				margin: 0 auto;
				width: 300px;
				box-sizing: border-box;
				background-color: rgba(255, 255, 255, .62);
			}
			#profile-area-inner {
				color: rgba(0, 0, 0, .7);
			}
			#profile-icon {
				height: 150px;
				width: 150px;
				border: 1px solid rgba(255, 255, 255, .5);
				border-radius: 75px;
				box-sizing: border-box;
			}
			footer {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<main>
			<div id="profile-area">
				<div id="profile-area-inner">
					<img id="profile-icon" src="//marihachi.php.xdomain.jp/tea-time/icon_test.jpg"><!-- "//marihachi.php.xdomain.jp/tea-time/image/icon/<?=$user["screen_name"]?>" -->
					<h1><?=$user["name"]." (@".$user["screen_name"].")"?></h1>
					<button class="btn btn-defalut" id="follow-button">フォロー</button>
					<div>
						<p id="friend-status">
							<?=$followState?>
						</p>
					</div>
					<div>
						<p>bio: <?=$user["bio"]?></p>
					</div>
					<div>
						<p>Lv: <?=$user["lv"]?></p>
					</div>
					<div>
						<p>Exp: <?=$user["exp"]?></p>
					</div>
				</div>
			</div>
		</main>
		<footer>
			<p><a href=/tea-time>ホームへ</a></p>
		</footer>
	</body>
</html>