<?php

/**
*
*
**/

class Request_Handler {

	public $data;

	public function __construct(){
		$this->parseFileRequest();
	}

	/**
	 * 
	 * @param 
	 * @return 
	 * @author CheeseMaster
	 * @since 2015-01-27
	 */
	public function parseUrlParams($_params){
		if(is_array($_params) && count($_params) > 0){
			foreach ($_params as $key => $param) {
				if(isset($param[0]) && isset($param[1])){
					$this->data->url->{$param[0]} = $param[1];
				}
			}
		}
	}


	/**
	 * 
	 * @param 
	 * @return 
	 * @author CheeseMaster
	 * @since 2015-01-27
	 */
	public function parseFileRequest(){
		if ($_FILES) {
			
			while (list($key, $value) = each($_FILES)) {

				$this->data->{$key} = new StdClass();

				while (list($key2, $value2) = each($value)) {
					$this->data->{$key}->{$key2} = $value2;
				}
			}
		}
	}

}
?>