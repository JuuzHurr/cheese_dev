<?php

class Db_Row extends Db {

	public $table;
	public $table_columns;
	public $row;

	function __construct($table=false){
		$this->row = new StdClass();
		$this->table = $table;
	}

	public function get(){
		return $this->row;
	}

	public function set($row){
		$this->row = $row;
	}

	public function new(){
		$this->row->id = null;
	}

	public function save(){

		if(intval($this->row->id)){
			$this->update();
		}else{
			$this->insert();
		}
	}

	public function fetch($where_clause='',$return_columns='',$limit='',$order_by=''){

		if(isset($this->table)){

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

			$this->row = parent::fetch_object('SELECT '.$columns.' FROM '.$this->table.$s_clause);

			return $this->row;
		}
	}

	public function update(){
		
		if(isset($this->table) && isset($this->row->id)){

			$set_clause = '';

			$row_vars = get_object_vars($this->row);

			if(is_array($row_vars) && count($row_vars) > 0){

				if(!isset($this->table_columns)){
					$this->table_columns = parent::getTableColumns($this->table);
				}

				foreach ($row_vars as $key => $value) {

					if($key != "id"){

						if(in_array($key, $this->table_columns)){

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
							trigger_error("Db_Row : insertRow : column ".$key." wasn't not found in table ".$this->table." and didn't save.");
						}
					}
				}
			}
			
			$set_clause = trim($set_clause);
			$set_clause = substr($set_clause,0,strlen($set_clause)-1);
			
			if(!empty($set_clause)){
				return parent::execute('UPDATE '.$this->table.' SET '.$set_clause.' WHERE id = '.$this->row->id);
			}

		}

		return false;
	}

	public function insert(){
		
		if(isset($this->table)){

			$col_clause = '';
			$value_clause = '';

			$row_vars = get_object_vars($this->row);

			if(is_array($row_vars) && count($row_vars) > 0){

				if(!isset($this->table_columns)){
					$this->table_columns = parent::getTableColumns($this->table);
				}

				foreach ($row_vars as $key => $value) {

					if(in_array($key, $this->table_columns)){

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
						trigger_error("Db_Row : insertRow : column ".$key." wasn't not found in table ".$this->table." and didn't save.");
					}
				}
			}

			$col_clause = trim($col_clause);
			$col_clause = substr($col_clause,0,strlen($col_clause)-1);
			
			$value_clause = trim($value_clause);
			$value_clause = substr($value_clause,0,strlen($value_clause)-1);

			if(!empty($col_clause) && !empty($value_clause)){
				return parent::execute('INSERT INTO '.$this->table.'('.$col_clause.') VALUES ('.$value_clause.')');
			}
		}

		return false;
	}

	public function delete(){
		
		if(isset($this->table) && intval($this->row->id)){
			return parent::execute('DELETE FROM '.$this->table.' WHERE id='.intval($this->row->id));
		}

		return false;
	}

}
?>