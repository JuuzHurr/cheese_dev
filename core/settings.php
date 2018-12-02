<?php

	define("SERVER_ROOT_ABSPATH", 
		substr(
			str_replace(
				basename($_SERVER['SCRIPT_FILENAME']), 
				'', 
				$_SERVER['SCRIPT_FILENAME']
			), 
			0, 
			strrpos(
				str_replace(
					'/' . basename($_SERVER['SCRIPT_FILENAME']), 
					'', 
					$_SERVER['SCRIPT_FILENAME']
				), 
				'/'
			)+1
		)
	);

	define("REQUEST_URI",stripslashes($_SERVER["REQUEST_URI"]));

	// core 
	define("CORE_DIR_ABSPATH",__DIR__.DIRECTORY_SEPARATOR );
	define("CORE_ACTION_DIR_ABSPATH",CORE_DIR_ABSPATH."action".DIRECTORY_SEPARATOR );
	define("CORE_CLASS_DIR_ABSPATH",CORE_DIR_ABSPATH."class".DIRECTORY_SEPARATOR );

	define("CORE_URL_PATH", "core/" );
	define("CORE_ACTION_URL_PATH",CORE_URL_PATH."action/" );
	define("CORE_CLASS_URL_PATH",CORE_URL_PATH."class/" );

	define("CORE_DASHBOARD_URL",'site-dashboard');

	define("FORBIDDEN_CORE_ACTIONS", array( 'init' ) );

	// apps
	define("APP_DIR_ABSPATH", SERVER_ROOT_ABSPATH."apps".DIRECTORY_SEPARATOR );
	define("APP_ACTION_DIR_ABSPATH",APP_DIR_ABSPATH."action".DIRECTORY_SEPARATOR );
	define("APP_CLASS_DIR_ABSPATH",APP_DIR_ABSPATH."class".DIRECTORY_SEPARATOR );

	define("APP_URL_PATH", "apps/" );
	define("APP_ACTION_URL_PATH",APP_URL_PATH."action/" );
	define("APP_CLASS_URL_PATH",APP_URL_PATH."class/" );

	// themes
	define("THEMES_PATH", SERVER_ROOT_ABSPATH."themes".DIRECTORY_SEPARATOR );

?>