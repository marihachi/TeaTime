<?php

class QueryManager
{
	public static function Instance()
	{
		if (!self::$instance) { self::$instance = new QueryManager(); }
		return self::$instance;
	}
	private static $instance;
	final function __clone()
	{
		throw new \Exception('Clone is not allowed against' . get_class($this));
	}
	private function __construct()
	{
		$config = Config::Instance();
		try
		{
			$this->DBHandle = new PDO('mysql:host='.$config->DbHost.';dbname='.$config->DbName.";charset=utf8", $config->DbUserName, $config->DbPassword);
		}
		catch (PDOException $e)
		{
			$ex = new \ErrorException("Failed to DB connection", 1);
			Router::Instance()->ErrorHandle($ex);
			die;
		}
	}
	private function __destruct()
	{
		$this->DBHandle = null;
	}

	// データベースのハンドル
	private $DBHandle;
	
	// クエリのステートメント
	private $Statement;

	// クエリを生成します
	public function CreateQuery($queryText)
	{
		$this->Statement = $this->DBHandle->prepare($queryText);
		$this->Statement->setFetchMode(PDO::FETCH_ASSOC);		
	}

	// クエリにパラメータを紐付けます
	public function BindParam($name, $value, $dataType = PDO::PARAM_STR)
	{
		if (!$this->Statement)
			$this->Statement->bindParam($name, $value, $dataType);
	}
	
	// クエリを実行します
	public function Execute()
	{
		if (!$this->Statement)
			$this->Statement->execute();
	}
	
	// クエリの実行結果を配列として取得します
	public function Fetch()
	{
		if (!$this->Statement)
			return $this->Statement->fetch();
	}
	
	// クエリを開放します
	public function DisposeQuery()
	{
		if (!$this->Statement)
			$this->Statement = null;
	}
}