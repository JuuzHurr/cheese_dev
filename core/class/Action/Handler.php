<?php

/**
*
*
**/

class Action_Handler {

	public $path;
	public $type;

	function __construct($path=false) {
		$this->setAction($path);
	}

	public function setAction($_path=false){
		if(!empty($_path)){

			// if core action
			if(file_exists(CORE_ACTION_PATH.$_path.'.php')) {
				$this->type = 'core';
			// else if app action
			}elseif(file_exists(APP_ACTION_PATH.$_path.'.php')) {
				$this->type = 'app';
			// else action is content view
			}else{
				$this->type = 'content';
				$this->path = 'content/view';
			}

			if($this->type != "content"){
				// action must be registered
				if($this->isActionRegistered($_path,$this->type)){
					$this->path = $_path;
				}
			}

			if(!isset($this->path)){
				// erorr rororor
			}
		}
	}

	public function getAction(){
		return $this;
	}

	public function runAction(){
		if(isset($this->path) && isset($this->type)){
			if($this->type == "app"){
				if(file_exists(APP_ACTION_PATH.$this->path.'.php')) {
					include(APP_ACTION_PATH.$this->path.'.php');
				}
			}else{
				if(file_exists(CORE_ACTION_PATH.$this->path.'.php')) {
					include(CORE_ACTION_PATH.$this->path.'.php');
				}
			}
		}
	}

	public function registerAction($_path=false,$_type=false){
		if(!empty($_path) && !empty($_type)){
			// are you admin?
			// action db 
			// user permissions
		}
	}

	public function isActionRegistered($_path=false,$_type=false){
		if(!empty($_path) && !empty($_type)){
			// todo: db check?
			return true;
		}

		return false;
	}
}
?>