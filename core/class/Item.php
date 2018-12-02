<?php
/** 
 *
 */
class Item {
	
	public static $data; // Db_Row object
    public static $db_table; // Db table : required
    public static $data_lang; // Db_Row object 
    public static $db_lang_table; // Db table for language : optional
    public static $table_language_join_key; // Key joining main table and language table : optional
    public static $lang; // required, if not set -> is set from default system language

    public $tools;

	function __construct($_id=null) {

        $this->tools = new Content_Tools();

        if(self::$lang){
            $this->setLanguage(self::$lang);
        }else{
            $this->setLanguage(Core::$language->current);
        }
        
        if(self::$db_table && self::$lang) {

            $this->data = new Db_Row(self::$db_table);

            if(intval($_id)) {

                $this->data->row = $this->data->fetch('id='.intval($_id));
                
                if($this->data->row->id){

                    // - handle language version
                    if(self::$db_lang_table && self::$table_language_join_key){

                        $this->data_lang = new Db_Row(self::$db_lang_table);

                        $this->data_lang->row = $this->data_lang->fetch(self::$table_language_join_key.'='.intval($_id).' AND language="'.$this->lang.'"');
                      
                        if(!$this->data_lang->row->id){
                            $this->data_lang->newRow();
                        }

                        $this->data->row->lang = $this->data_lang->row;
                    }

                }else{
                    $this->data->newRow();
                }

            } else {
                
                $this->data->newRow();

                // - handle language version
                if(self::$db_lang_table && self::$table_language_join_key){
                    $this->data_lang = new Db_Row(self::$db_lang_table);
                    $this->data_lang->newRow();
                }
            }
        }
	}

    function __clone() {
		$this->object1 = clone $this->object1;
    }

   
    public function setLanguage($lang){
        $this->lang = $lang;
    }

    public function getId() {
        return intval($this->data->row->id);
    }
   
    public function setId($data) {
        if(intval($data) || $data == 'new')
            $this->data->row->id = trim($data);
    }

    public function getData() {
        if($this->data->row->id) {
            return $this->data->row;
        }else{
            return false;
        }
    }

    public function getLangData($_data) {
         if($this->data_lang->row->id) {
            return $this->data_lang->row;
        }else{
            return false;
        }
    }

    public function setData($_data) {

        if($this->data->row->id)
            $temp_id = $this->data->row->id;

        $this->data->row = clone $this->content_tools->prepareFormData($_data);

        if($temp_id)
            $this->data->row->id = $temp_id;

        return $this->data->row;
    }

    public function setLangData($_data) {
        
        if($this->data_lang->row->id)
            $temp_id = $this->data_lang->row->id;

        $this->data_lang->row = clone $this->content_tools->prepareFormData($_data);

        if($temp_id)
            $this->data_lang->row->id = $temp_id;

        return $this->data_lang->row;
    }

    public function exists() {
    	if(intval($this->data->row->id))
    		return true;
    	else
    		return false;
    }

    public function save($_data=null) {
               
        if($this->data instanceof Db_Row) {

            if(isset($_data))
        		$this->setData($_data);
        
            $this->data->saveRow();

            // - handle language version
            if($this->data_lang instanceof Db_Row) {

                if(isset($_data) && isset($this->data->row->id)){
                    
                    $_data->{self::$table_language_join_key} = $this->data->row->id;

                    $this->setLangData($_data);
            
                    $this->data_lang->saveRow();

                }
            }

            return true;
        }

        return false;
    }

    public function delete() {

        if($this->exists()) {

            // - handle language version
            if($this->data_lang instanceof Db_Row) {
                $this->deleteLang();
            }

            $this->data->deleteRow();

            return true;
        }
        
        return false;
    }

    public function deleteLang($_language=false){

        if($this->exists()) {

            $_w_clause = '';

            if($_language){
                $_w_clause = ' AND language_code="'.$_language.'"';
            }

            if($this->data_lang instanceof Db_Row) {

                $result = $this->data_lang->fetch(self::$table_language_join_key.'='.$this->data->row->id.$_w_clause,'id');

                if(is_array($result) && count($result)){
                    foreach ($result as $key => $lang_row) {
                        $this->data_lang->row->id = $lang_row->id;
                        $this->data_lang->deleteRow();
                    }
                }elseif($result->id){
                    $this->data_lang->row->id = $result->id;
                    $this->data_lang->deleteRow();
                }
                
                return true;
            }
        }

        return false;
    }

}
?>