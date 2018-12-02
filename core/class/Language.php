<?php

/**
*
*
**/

class Language {

	public static $default;
	public static $current;
	public static $table_language = DB_TABLE_PREFIX.'sys_language';

	function __construct(){
		self::$default = self::getDefaultLanguage();
		self::$current = self::$default;
	}

	public static function set( $lang_code='' ){
		if( !empty( $lang_code ) ){
			self::$current = $lang_code;
			setlocale( LC_ALL, strtolower($lang_code).'_'.strtoupper($lang_code).'.UTF8' );
		}
	}

	public static function setByUrl( $o_url=false ){

		if( is_object( $o_url ) ){

			// if url contains lang module and it's different than current language -> change current language
			if( isset( $o_url->lang_module ) ){
				if( $o_url->lang_module != self::$current){
					self::set( $o_url->lang_module );
				}
			}
			// if url contains language param -> change current language, this is for core actions, also can be used to force language
			if( is_array( $o_url->a_params ) ){
				if( array_key_exists('language', $o_url->a_params) ){
					if( self::fetch( $o_url->a_params['language'] ) ){
						self::set( $o_url->a_params['language'] );
					}
				}
			}
		}
	}

	public static function getDefaultLanguage(){

		Db::set_query('SELECT code FROM '.self::$table_language.' WHERE sys_default=1 LIMIT 1');

		if( $lang = Db::fetch_object() ){
			return $lang->code;
		}
	}
	
	public static function getLanguages(){
		return Db::fetch_object('SELECT * FROM '.self::$table_language);
	}

	public static function getActiveLanguages(){
		return Db::fetch_object('SELECT * FROM '.self::$table_language.' WHERE enabled=1');
	}

	public static function fetch( $lang_code='' ){
		if( !empty( $lang_code ) ){ 
			return Db::fetch_object('SELECT * FROM '.self::$table_language.' WHERE code="'.$lang_code.'"');
		} return false;
	}
}
?>