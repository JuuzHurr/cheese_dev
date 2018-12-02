<?php
/**
 * 
 */

class Content_Tools {

	public static function prepareFormData($obj){
		
		$ret = new stdClass;
	
		foreach ($obj as $key => $value) {
				
			$key = str_replace("'","",$key);

			if(is_array($value) || is_object($value)) {
				sort($value);
				$ret->{$key} = $value;
			} else {
				$ret->{$key} = strip_tags(stripslashes(trim($value)));
			}
		}
		
		return $ret;
	}

}
?>