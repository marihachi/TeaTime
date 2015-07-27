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
	}
    
    // ルーティングをします。
    public function Routing()
    {
        echo "This is Router";
    }
}