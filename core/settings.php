<?php

	//#### Define global variables
	define("REQUEST_URI",stripslashes($_SERVER["REQUEST_URI"]));

	// core paths
	define("CORE_PATH",__DIR__.DIRECTORY_SEPARATOR );

	define("CORE_ACTION_PATH",CORE_PATH."action".DIRECTORY_SEPARATOR );
	define("CORE_CLASS_PATH",CORE_PATH."class".DIRECTORY_SEPARATOR );

	// app paths
	define("APP_PATH","..".DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR );
	define("APP_ACTION_PATH",APP_PATH."action".DIRECTORY_SEPARATOR );
	define("APP_CLASS_PATH",APP_PATH."class".DIRECTORY_SEPARATOR );

	// theme paths
	define("THEMES_PATH","..".DIRECTORY_SEPARATOR."themes".DIRECTORY_SEPARATOR );

?>