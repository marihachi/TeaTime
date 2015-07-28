<?php

include_once("Skinny.php");

class Router
{
	public static function Instance()
	{
		if (!self::$instance) { self::$instance = new Router(); }
		return self::$instance;
	}
	private static $instance;
	final function __clone()
	{
		throw new \Exception('Clone is not allowed against' . get_class($this));
	}
	private function __construct()
	{
		$this->RoutesList = array();
	}

	// 正規表現を含むルート情報のリスト
	private $RouteList;

	// ルートを追加します。
	public function Add($method, $route, $action)
	{		
		$this->RouteActionList[$route]["action"] = $action;
		$this->RouteActionList[$route]["method"] = $method;
	}

	// ルーティングと表示処理をします。
	public function Routing()
	{
		$pathArray = explode("/", Core::Instance()->GetPathInfo());

		// 最後の要素が空要素なら削除
		$lastItem = count($pathArray) - 1;

		if($pathArray[$lastItem] === "")
			unset($pathArray[$lastItem]);

		$pathStr = join("/", $pathArray);

		if ($pathStr === "")
			$pathStr ="/";

		if($this->RouteActionList[$pathStr])
		{
			switch ($this->RouteActionList[$pathStr]["method"])
			{
				case "get":
					$getParam = $_GET;
					break;
				case "post":
					$getParam = $_POST;
					break;
				default:
					throw new \Exception('Unknown method type');
			}
			$skinny = new Skinny();
			$this->RouteActionList[$pathStr]["action"]($skinny, $getParam);
		}
		else
		{
			$skinny = new Skinny();
			$skinny->SkinnyDisplay("views/404.html");
		}
	}
}