<? defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?=$target['name']?>さんのページ - TeaTime</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			$(function() {
				var follow = function() {
					$("#follow-button").unbind("click", follow);
					$.ajax("<?=$this->config->base_url();?>api/web/user/follow", {
						type: "post",
						dataType: "json",
						data: {"screen_name": '<?=$target['screen_name']?>'}
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
					$.ajax("<?=$this->config->base_url();?>api/web/user/unfollow", {
						type: "post",
						dataType: "json",
						data: {"screen_name": "<?=$target['screen_name']?>"}
					}).done(function() {
						$("#follow-button")
							.text("フォロー")
							.bind("click", follow);
					}).fail(function() {
						$("#follow-button").bind("click", unfollow)
						alert("アンフォローに失敗しました");
					});
				}
				<?
				echo !$isVisibleFollowButton ? '$("#follow-button").css({display: "none"});' : '';
				echo $isFollowing
					? '$("#follow-button").text("フォロー中").click(unfollow);'
					: '$("#follow-button").text("フォロー").click(follow);';
				?>

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
					<img id="profile-icon" src="<?=$this->config->base_url();?>icon_test.jpg"><!-- "<?=$this->config->base_url();?>image/icon/<?=$target["screen_name"]?>" -->
					<h1><?=$target["name"]." (@".$target["screen_name"].")"?></h1>
					<button class="btn btn-defalut" id="follow-button">フォロー</button>
					<div>
						<p id="friend-status"><?=$followState?></p>
					</div>
					<div>
						<p>bio: <?=$target["bio"]?></p>
					</div>
					<div>
						<p>Lv: <?=$target["lv"]?></p>
					</div>
					<div>
						<p>Exp: <?=$target["exp"]?></p>
					</div>
				</div>
			</div>
		</main>
		<footer>
			<p><a href="<?=$this->config->base_url();?>">ホームへ</a></p>
		</footer>
	</body>
</html>