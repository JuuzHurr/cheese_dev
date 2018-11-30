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

	public static function getDefaultLanguage(){

		Db::sql('SELECT code FROM '.self::$table_language.' WHERE sys_default=1 LIMIT 1');

		if( $lang = Db::fetch() ){
			return $lang->code;
		}
	}
	
	public static function getLanguages(){

		Db::sql('SELECT * FROM '.self::$table_language);

		return Db::fetch();
	}

	public static function getActiveLanguages(){

		Db::sql('SELECT * FROM '.self::$table_language.' WHERE enabled=1');

		return Db::fetch();
	}

	public static function fetch( $lang_code='' ){
		if( !empty( $lang_code ) ){ 

			Db::sql('SELECT * FROM '.self::$table_language.' WHERE code="'.$lang_code.'"');

			return Db::fetch();

		} return false;
	}
}
?>