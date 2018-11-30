<?php

class Db_Row {

	private $_table;
	private $_table_columns;
	public $row;

	function __construct($_table=false){

		$this->db = new Db();
		$this->row = new StdClass();

		$this->_table = $_table;

	}

	public function getRow(){
		return $this->row;
	}

	public function setRow($row){
		$this->row = $row;
	}

	public function newRow(){
		$this->row->id = null;
	}

	public function saveRow(){

		if(intval($this->row->id)){
			$this->_update();
		}else{
			$this->_insert();
		}
	}

	public function deleteRow(){

		if(intval($this->row->id)){
			$this->_delete();
		}
	}

	public function fetch($where_clause='',$return_columns='',$limit='',$order_by=''){

		if(isset($this->_table)){

			$s_clause = '';

			if (!empty($return_columns)) {
				$columns = $return_columns;
			}else{
				$columns = '*';
			}

			if (!empty($where_clause)) {
				$s_clause .= ' WHERE '.stripslashes($where_clause);
			}

			if (!empty($order_by)) {
				$s_clause .= ' ORDER BY '.stripslashes($order_by);
			}

			if (intval($limit)) {
				$s_clause .= ' LIMIT '.intval($limit);
			}

			$this->row = $this->db->sql('SELECT '.$columns.' FROM '.$this->_table.$s_clause);

			return $this->row;
		}
	}

	private function _update(){
		
		if(isset($this->_table) && isset($this->row->id)){

			$set_clause = '';

			$row_vars = get_object_vars($this->row);

			if(is_array($row_vars) && count($row_vars) > 0){

				if(!isset($this->_table_columns)){
					$this->_table_columns = $this->db->getTableColumns($this->_table);
				}

				foreach ($row_vars as $key => $value) {

					if($key != "id"){

						if(in_array($key, $this->_table_columns)){

							if(gettype($value) == 'string' || gettype($value) == 'blob' || gettype($value) == 'datetime') {

								$set_clause .= $key.' = "'.addslashes($value).'", ';

							}elseif(gettype($value) == 'integer') {

								$value = intval($value);
								$set_clause .= $key.' = '.$value.', ';

							}elseif(gettype($value) == 'double' || gettype($value) == 'real') {

								$value = str_replace(',', '.', floatval($value));
								$set_clause .= $key.' = '.$value.', ';
							}
						}else{
							trigger_error("Db_Row : _insertRow : column ".$key." wasn't not found in table ".$this->_table." and didn't save.");
						}
					}
				}
			}
			
			$set_clause = trim($set_clause);
			$set_clause = substr($set_clause,0,strlen($set_clause)-1);
			
			if(!empty($set_clause)){
				return $this->db->sql('UPDATE '.$this->_table.' SET '.$set_clause.' WHERE id = '.$this->row->id);
			}

		}

		return false;
	}

	private function _insert(){
		
		if(isset($this->_table)){

			$col_clause = '';
			$value_clause = '';

			$row_vars = get_object_vars($this->row);

			if(is_array($row_vars) && count($row_vars) > 0){

				if(!isset($this->_table_columns)){
					$this->_table_columns = $this->db->getTableColumns($this->_table);
				}

				foreach ($row_vars as $key => $value) {

					if(in_array($key, $this->_table_columns)){

						if($key == "id"){
							$col_clause .= $key.',';
							$value_clause .= 'NULL,';
						}else{

							if(gettype($value) == 'string' || gettype($value) == 'blob' || gettype($value) == 'datetime') {

								$col_clause .= $key.',';
								$value_clause .= '"'.addslashes($value).'",';

							}elseif(gettype($value) == 'integer') {

								$col_clause .= $key.',';
								$value = intval($value);
								$value_clause .= $value.',';

							}elseif(gettype($value) == 'double' || gettype($value) == 'real') {

								$col_clause .= $key.',';
								$value = str_replace(',', '.', floatval($value));
								$value_clause .= $value.',';
							}
						}
					}else{
						trigger_error("Db_Row : _insertRow : column ".$key." wasn't not found in table ".$this->_table." and didn't save.");
					}
				}
			}

			$col_clause = trim($col_clause);
			$col_clause = substr($col_clause,0,strlen($col_clause)-1);
			
			$value_clause = trim($value_clause);
			$value_clause = substr($value_clause,0,strlen($value_clause)-1);

			if(!empty($col_clause) && !empty($value_clause)){
				return $this->db->sql('INSERT INTO '.$this->_table.'('.$col_clause.') VALUES ('.$value_clause.')');
			}
		}

		return false;
	}

	private function _delete(){
		
		if(isset($this->_table) && intval($this->row->id)){
			return $this->db->sql('DELETE FROM '.$this->_table.' WHERE id='.intval($this->row->id));
		}

		return false;
	}

}
?>