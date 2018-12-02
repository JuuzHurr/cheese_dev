<?php

/**
*
*
**/

class Url {

	public $url;
	public $a_path;

	public $url_params;
	public $a_params;
	
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
			$this->url_params = Url_Handler::parseUrlParams( $this->url );
			$this->url = Url_Handler::parseUrl( $this->url, $this->url_params );
			$this->a_path = Url_Handler::parsePath( $this->url );
			$this->a_params = Url_Handler::parseParams( $this->url_params );
			$this->lang_module = Url_Handler::parseLangModule( $this->url );

			//$this->a_path = str_replace($this->lang_module.'/', '', $this->path);
		}
	}

	
}
?>