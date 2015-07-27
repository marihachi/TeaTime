<?php

class Core
{
	public static function Instance()
	{
		if (!self::$instance) { self::$instance = new Core(); }
		return self::$instance;
	}
    private static $instance;
	final function __clone()
    {
        throw new \Exception('Clone is not allowed against' . get_class($this));
    }
	private function __construct()
	{
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