<?php

class Core {

	public static $db;
	public static $language;
	public static $url;
	public static $action;
	public static $request;

	function __construct() {

	}

	public static function init(){

		self::loadClasses();
		self::$db = new Db();
		self::$language = new Language();
		self::$url = new Url();
		self::$language::setByUrl( self::$url ); // Set current language by url
		self::$request = new Request();
		self::$action = new Action( self::$url );
		
		if( self::$action->type == 'content' ){
			die(' TODO :: continue from here ');
		}

	}

	private static function loadClasses(){

		// nullify any existing autoloads - let's not be lazy and do this shit manually to keep control
		spl_autoload_register(null, false);

		// Db classes
		require(CORE_CLASS_DIR_ABSPATH.'Db.php');
		require(CORE_CLASS_DIR_ABSPATH.'Db'.DIRECTORY_SEPARATOR.'Row.php');

		// Url classes
		require(CORE_CLASS_DIR_ABSPATH.'Url.php');
		require(CORE_CLASS_DIR_ABSPATH.'Url'.DIRECTORY_SEPARATOR.'Handler.php');

		// Request classes
		require(CORE_CLASS_DIR_ABSPATH.'Request.php');
		require(CORE_CLASS_DIR_ABSPATH.'Request'.DIRECTORY_SEPARATOR.'Handler.php');

		// Language classes
		require(CORE_CLASS_DIR_ABSPATH.'Language.php');

		// Action classes
		require(CORE_CLASS_DIR_ABSPATH.'Action.php');
		require(CORE_CLASS_DIR_ABSPATH.'Action'.DIRECTORY_SEPARATOR.'Handler.php');

		// Content classes
		require(CORE_CLASS_DIR_ABSPATH.'Item.php');

		// Content classes
		require(CORE_CLASS_DIR_ABSPATH.'Content.php');
		require(CORE_CLASS_DIR_ABSPATH.'Content'.DIRECTORY_SEPARATOR.'Tools.php');
	}

}
?>