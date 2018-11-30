<?php

/**
*	
*
**/

class Core {

	public static $language;
	public static $url;

	function __construct() {

	}

	public static function init(){
//print_r($_SERVER);
		// Load core classes
		self::loadCore();

		new Db();

		// Language
		self::$language = new Language();
		print_r('Default language : '.self::$language::$default );print('<br>');
		print_r('Current language : '.self::$language::$current );print('<br>');
		
		// Parse url
		self::$url = new Url();
		print_r(self::$url);print('<br>');
		
		// if url contains lang module and it's different than default/current, change current language
		if(isset(self::$url->lang_module)){
			if( self::$url->lang_module != self::$language::$current){
				self::$language::set( self::$url->lang_module );
			}
		}

		print_r('Current language : '.self::$language::$current );print('<br>');
		die(' << ');

		
		// --- parse request --- //
		$request_handler = new Request_Handler();
		
		if(is_array(self::$data->url->params) && count(self::$data->url->params)){
			$request_handler->parseUrlParams(self::$data->url->params);
		}

		self::$data->request = $request_handler->data;
		
		// --- parse action --- //
		$action_handler = new Action_Handler(self::$data->url->path);
		self::$data->action = $action_handler->getAction();
		$action_handler->runAction();

		print_r(self::$data);die();
	}

	private static function loadCore(){

		// nullify any existing autoloads - let's do this shit manually to keep control
		spl_autoload_register(null, false);

		// Db classes
		require(CORE_CLASS_PATH.'Db.php');
		require(CORE_CLASS_PATH.'Db'.DIRECTORY_SEPARATOR.'Row.php');

		// Url classes
		require(CORE_CLASS_PATH.'Url.php');
		require(CORE_CLASS_PATH.'Url'.DIRECTORY_SEPARATOR.'Handler.php');

		// Request classes
		require(CORE_CLASS_PATH.'Request'.DIRECTORY_SEPARATOR.'Handler.php');

		// Language classes
		require(CORE_CLASS_PATH.'Language.php');

		// Action classes
		require(CORE_CLASS_PATH.'Action'.DIRECTORY_SEPARATOR.'Handler.php');

		// Content classes
		require(CORE_CLASS_PATH.'Content'.DIRECTORY_SEPARATOR.'Tools.php');
	}

}
?>