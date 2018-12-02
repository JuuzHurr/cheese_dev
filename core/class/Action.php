<?php

class Action {

	public $type = 'content';
	public $action = false;

	public $a_forbidden_app_actions = FORBIDDEN_APP_ACTIONS;

	function __construct( $o_url=false ) {
		$this->runCoreAction($o_url);
		$this->runAppAction($o_url);
	}

	public function set( $action=false ){
		if(!empty($action)){
			$this->action = $action;
		}
	}

	public function get(){
		return $this->action;
	}

	public function set_type( $type=false ){
		if(!empty($type)){
			$this->type = $type;
		}
	}

	public function get_type(){
		return $this->type;
	}

	private function runCoreAction( $o_url='' ){
		
		if( is_object($o_url) ){

			if( is_string($o_url->url) && is_array($o_url->a_path) ){

				if( !empty($o_url->url) && count($o_url->a_path) > 0 ){

					// core action (url contains core action url path)
					if(strstr($o_url->url, CORE_ACTION_URL_PATH)){
						
						$this->type = 'core';
						$o_url->url = str_replace( CORE_ACTION_URL_PATH, '', $o_url->url ); // remove core action url path from url
						$file_path = str_replace('/', DIRECTORY_SEPARATOR, rtrim($o_url->url,'/')); // convert url to file path

						// if core file exists and isn't forbidded, run it
						if(file_exists(CORE_ACTION_DIR_ABSPATH.$file_path.'.php')) {
							if( !in_array( end($o_url->a_path), FORBIDDEN_CORE_ACTIONS ) ){
								$this->action = $file_path;
								$this->run();
							}
						}else{
							$this->action = 'error/404';
							$this->run();
						}
					}
				}
			}
		}
	}

	private function runAppAction( $o_url='' ){
		
		if( is_object($o_url) ){

			if( is_string($o_url->url) && is_array($o_url->a_path) ){

				if( !empty($o_url->url) && count($o_url->a_path) > 0 ){

					// core action (url contains core action url path)
					if(strstr($o_url->url, APP_ACTION_URL_PATH)){
						
						$o_url->url = str_replace( APP_ACTION_URL_PATH, '', $o_url->url ); // remove core action url path from url
						$file_path = str_replace('/', DIRECTORY_SEPARATOR, rtrim($o_url->url,'/')); // convert url to file path

						// if core file exists and isn't forbidded, run it
						if(file_exists(APP_ACTION_DIR_ABSPATH.$file_path.'.php')) {
							if( !in_array( end($o_url->a_path), FORBIDDEN_APP_ACTIONS ) ){
								$this->action = $file_path;
								$this->type = 'app';
								$this->run();
							}
						}else{
							die('Action Class Error - App action file not found : '.$file_path);
						}
					}
				}
			}
		}
	}

	private function run(){
		if(isset($this->action) && isset($this->type)){
			if($this->type == "app"){
				if(file_exists(APP_ACTION_DIR_ABSPATH.$this->action.'.php')) {
					include(APP_ACTION_DIR_ABSPATH.$this->action.'.php'); exit();
				}
			}elseif($this->type == "core"){
				if(file_exists(CORE_ACTION_DIR_ABSPATH.$this->action.'.php')) {
					include(CORE_ACTION_DIR_ABSPATH.$this->action.'.php'); exit();
				}
			}else{
				// can any other action type be runnable?
			}
		}
	}
}
?>