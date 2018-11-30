<?php

/**
*
*
**/

class Url_Handler {

	public static $delimiter = "-";
	public static $param_splitter = "/-/";
	
	public static function parseParams( $url='' ){

		if( !empty($url) ){
			$a_splitted_url = explode( self::$param_splitter, $url );
			
			if( is_array($a_splitted_url) && count($a_splitted_url) > 1){
				$url_params = $a_splitted_url[1];
				$a_params = explode('/', $url_params );
				$a_params = array_chunk($a_params, 2);
				return $a_params;
			}
		} return false;
	}

	public static function parsePath( $url='' ){
		if( !empty($url) ){
			return explode( '/', $url );
		}
	}

	public static function parseLangModule( $url='' ){

		if( !empty($url) ){

			$_url = explode('/', $url);

			if(!empty($_url[0])){

				if( $language = Language::fetch( $_url[0] ) ){
					return $language->code;
				}
			}
			
		} return false;
	}

	public static function clean( $url='' ){

		if( !empty($url) ){
			
			// strip first slash
			$url = ltrim($url,'/');

			$url = str_replace( PUBLIC_PATH, '', $url );

			// lower all
			$url = strtolower($url);

			return $url;

		}
	}

}
?>