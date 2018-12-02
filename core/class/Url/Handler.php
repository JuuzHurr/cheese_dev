<?php

/**
*
*
**/

class Url_Handler {

	public static $delimiter = "-";
	public static $param_splitter = "/-/";
	
	public static function parseUrl( $url='', $url_params='' ){
		
		if( !empty($url) ){
			if( strstr( $url, CORE_DASHBOARD_URL ) ){
				$a_url =  explode( '/', rtrim($url,'/') );

				// if url contains only the dashboard url -> is index
				if( count($a_url) == 1 ){
					$url = str_replace( CORE_DASHBOARD_URL, CORE_ACTION_URL_PATH.'dashboard/index', $url );
				}else{
					$url = str_replace( CORE_DASHBOARD_URL, CORE_ACTION_URL_PATH.'dashboard', $url );
				}
			}
			if( !empty($url_params) ){
				$a_url =  explode( self::$param_splitter, $url );
				if( is_array($a_url) ){
					$url = $a_url[0];
				}
			}
		}

		return $url;

	}

	public static function parseUrlParams( $url='' ){

		if( !empty($url) ){
			$a_splitted_url = explode( self::$param_splitter, $url );
			
			if( is_array($a_splitted_url) && count($a_splitted_url) > 1){
				$url_params = $a_splitted_url[1];
				return $url_params;
			}

		} return false;
	}

	public static function parseParams( $url_params='' ){

		if( !empty($url_params) ){

			$a_params = explode('/', $url_params );

			if( is_array($a_params) && count($a_params) > 1 ){

				$a_params = array_chunk($a_params, 2);
				$a_assoc_params = array();

				foreach ($a_params as $key => $param) {
					if( count($param) > 1 ){
						if( !empty($param[0]) && !empty($param[1]) ){
							$key = $param[0];
							$a_assoc_params[$key] = $param[1];
						}
					}
				}

				$a_params = $a_assoc_params;
				
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

			// strip last slash
			$url = rtrim($url,'/');

			$url = str_replace( PUBLIC_PATH, '', $url );

			// lower all
			$url = strtolower($url);

			return $url;

		}
	}

}
?>