<?php

require_once("Skinny.php");

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
		// 正規表現のメタ文字をエスケープ
		$route = str_replace("\\", "\\\\", $route);
		$route = str_replace("^", "\^", $route);
		$route = str_replace(".", "\.", $route);
		$route = str_replace("$", "\$", $route);
		$route = str_replace("*", "\*", $route);
		$route = str_replace("?", "\?", $route);
		$route = str_replace("+", "\+", $route);
		$route = str_replace("/", "\/", $route);
		$route = str_replace("(", "\(", $route);
		$route = str_replace(")", "\)", $route);
		$route = str_replace("[", "\[", $route);
		$route = str_replace("]", "\]", $route);
		$route = str_replace("{", "\{", $route);
		$route = str_replace("}", "\}", $route);

		// ルートパラメータを正規表現に置換
		$regexRoute = preg_replace("/\/:[^\/:]+/", "/([^\\/]+)", $route);

		// ルートパラメータの名前を抽出して配列を構築
		preg_match_all("/\/:([^\/:]+)/", $route, $matchResult, PREG_SET_ORDER);
		$params = array();
		foreach($matchResult as $item)
			$params[] = $item[1];

		// ルート情報の配列を構築
		$routeInfo = array();
		$routeInfo["regexRoute"] = "/^".$regexRoute."$/";
		$routeInfo["params"] = $params;
		$routeInfo["action"] = $action;
		$routeInfo["method"] = strtoupper($method);

		// ルートリストに追加
		$this->RouteList[] = $routeInfo;
	}

	// ルーティングと表示処理をします。
	public function Routing()
	{
		// パスの階層を配列に変換
		$pathArray = explode("/", strtolower($this->GetPathInfo()));

		// 最後の要素が空要素なら削除
		$lastItem = count($pathArray) - 1;
		if($pathArray[$lastItem] === "")
			unset($pathArray[$lastItem]);

		// スラッシュでパスを再構成
		$pathStr = join("/", $pathArray);

		if ($pathStr === "")
			$pathStr ="/";

		foreach($this->RouteList as $routeInfo)
		{
			if (preg_match($routeInfo["regexRoute"], $pathStr) == 1 && $routeInfo["method"] == $_SERVER['REQUEST_METHOD'])
			{
				preg_match_all($routeInfo["regexRoute"], $pathStr, $matchResult);

				$params = array();
				if ($matchResult[1] !== NULL)
				{
					$i = 0;
					foreach($matchResult[1] as $item)
					{
						$params[$routeInfo["params"][$i+0]] = $item;
						$i++;
					}
				}
				$routeInfo["action"](count($params) != 0 ? $params : null);
				return;
			}
		}
		$skinny = new Skinny();
		$skinny->SkinnyDisplay("views/404.html");
	}

	public function ErrorHandle($exception)
	{
		$param = array(
			"errorCode" => $exception->getCode(),
			"message" => $exception->getMessage(),
			"trace" => $exception->getTrace(),
			"place" => $exception->getFile()." : ".$exception->getLine());

		$skinny = new Skinny();
		$skinny->SkinnyDisplay("views/error.html", $param);
	}

	// 現在のURLから基となるURLを取得します。
	public function GetBaseUrl()
	{
		$scriptName = $_SERVER['SCRIPT_NAME'];
		$requestUri = $_SERVER['REQUEST_URI'];

		if(0 === strpos($requestUri, $scriptName))
			return $scriptName;
		else if(0 === strpos($requestUri, dirname($scriptName)))
			return rtrim(dirname($scriptName), '/');

		return '';
	}

	// 現在のURLからパス情報を取得します。
	public function GetPathInfo()
	{
		$baseUrl = $this->GetBaseUrl();
		$requestUri = $_SERVER['REQUEST_URI'];

		// クエリを取り除く
		if(false !== ($pos = strpos($requestUri, '?')))
			$requestUri = substr($requestUri, 0, $pos);

		// ベースURLを取り除く
		$pathInfo = (string)substr($requestUri, strlen($baseUrl));

		return $pathInfo;
	}
}