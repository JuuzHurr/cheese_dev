<?php
/** 
 *
 */
class Content {

	public function __construct() {
		
	}

	// public static function getContentByUrl($url=false,$lang=false){
		
	// 	if($lang){
	// 		parent::$lang=$lang;
	// 	}
	// 	if(!isset(parent::$lang)){
	// 		parent::$lang = Core::$language::$current;
	// 	}

	// 	if(!empty($url) && isset(parent::$lang)){

	// 		if($result = Db::fetch_object('SELECT '.self::$table_language_join_key.' FROM '.self::$table_language_key.' WHERE language="'.parent::$lang.'" AND url="'.trim(stripslashes($url)).'" LIMIT 1')){
	// 			return new Self( $result->{self::$table_language_join_key} );
	// 		}
	// 	}
		
	// 	return false;
	// }
	
}
?>