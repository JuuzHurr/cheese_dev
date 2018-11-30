<?php
/** 
 *
 */
class Content extends Item {

	public static $table_key = 'ch_content';
	public static $table_language_key = 'ch_content_lang';
	public static $table_language_join_key = 'content_id';

	public function __construct($_id=null,$_lang=false) {
		
		if($_lang){
			parent::$lang_code=$_lang;
		}

        parent::$db_table = self::$table_key;
        parent::$db_lang_table = self::$table_language_key;
        parent::$table_language_join_key = self::$table_language_join_key;

        if(intval($_id)){
        	parent::__construct($_id);
        }
	}

	public static function getContentByUrl($_url=false,$_lang){
		
		if($_lang){
			parent::$lang_code=$_lang;
		}
		if(!isset(parent::$lang_code)){
			parent::$lang_code = Cheese::$data->language->current->code;
		}

		if(!empty($_url) && isset(parent::$lang_code)){

			$q = new Db();

			if($result = $q->sql('SELECT '.self::$table_language_join_key.' FROM '.self::$table_language_key.' WHERE language="'.parent::$lang_code.'" AND url="'.trim(stripslashes($_url)).'" LIMIT 1')){
				return new Content($result->{self::$table_language_join_key});;
			}
		}
		
		return false;
	}
	
}
?>