<?php

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

	private $RoutesList;

	// ルートを追加します。
	public function Add($route, $action)
	{
		$this->RoutesList[$route] = $action;
	}

	// ルーティングをします。
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

		if($this->RoutesList[$pathStr]){
			$this->RoutesList[$pathStr]();
		}
		else
		{
			echo "404 - Page Not Found.";
		}
	}
}