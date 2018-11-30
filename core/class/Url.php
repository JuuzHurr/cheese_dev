<?php

/**
*
*
**/

class Url {

	public $url;
	public $path;
	public $params;
	public $lang_module;
	
	function __construct( $url=false ) {
		if( !empty($url) ){
			$this->set( $url );
		}else{
			$this->set( REQUEST_URI );
		}
		$this->parse();
	}

	public function set($url){
		if( !empty($url) ){
			$this->url = $url;
		}
	}

	public function get(){
		if( isset($this->url) ){
			return $this->url;
		}
	}

	public function parse(){
		if( isset($this->url) ){
			$this->url = Url_Handler::clean( $this->url );
			$this->path = Url_Handler::parsePath( $this->url );
			$this->params = Url_Handler::parseParams( $this->url );
			$this->lang_module = Url_Handler::parseLangModule( $this->url );

			$this->path = str_replace($this->lang_module.'/', '', $this->path);
		}
	}

	
}
?>