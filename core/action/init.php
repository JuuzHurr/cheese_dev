<?php

	//#### Core settings
	require_once('../core/settings.php');
		
	//#### Service settings - developer can overwrite core settings?
	require_once('../config/settings.php');
		
	//#### Core Init
	require_once(CORE_CLASS_DIR_ABSPATH.'Core.php');

	Core::init();

?>