<?php

include_once("Skinny.php");

class Router
{
	public function __construct()
	{
		$this->RoutesList = array();
	}

	private $RoutesList;
	private $FileNameList;

	// ルートを追加します。
	public function Add($route, $fileName, $action)
	{
		$this->RoutesList[$route] = $action;
		$this->FileNameList[$route] = $fileName;
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
		
		if($this->RoutesList[$pathStr])
		{
			$getParam = $_GET;
			$res = $this->RoutesList[$pathStr]($getParam);
			$skinny = new Skinny();
			$skinny->SkinnyDisplay($this->FileNameList[$pathStr], $res);
		}
		else
		{
			$skinny = new Skinny();
			$skinny->SkinnyDisplay("views/404.html");
		}
	}
}