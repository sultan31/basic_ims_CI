<?php 
class Home_model extends CI_Model 
{
	/**
	* Instanciar o CI
	*/
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


function getCombo($sql,$value=false)
	{
		    $query=$this->db->query($sql);
			$str='';
			foreach($query->result() as $row)
			{
				$selected="";
				if($value)
				{
					if($value==$row->f1)
					{
						$selected=" selected='selected'";
					}
				}
				$str.="<option value='".$row->f1."'".$selected.">".$row->f2."</option>";
			}
			
			return $str;
	}
	
	function getCombofromtable($field1,$field2,$table,$where,$preSelected)
	{
		$fields=$field1.' as f1,'.$field2.' as f2';
		$this->db->select($fields);
		$this->db->from($table);
		$this->db->where($where);
		$result = $this->db->get();
		$str='';
		foreach($result->result() as $row){
			$selected="";
				if($preSelected)
				{
					if($preSelected==$row->f1)
					{
						$selected=" selected='selected'";
					}
				}
				$str.="<option value='".$row->f1."'".$selected.">".$row->f2."</option>";
		}
		return $str;
	}

	function get_dropdown_search_data($input_search_text,$db_table_name,$search_box_id,$result_table_id,$value_box_id,$depend_box_id = false){
		$str='';
		if($db_table_name == 'country_master'){
			$where = "name LIKE '%".$input_search_text."%' and active='1'";		
			$this->db->select('name,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->name."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'state_master'){
			$where = "state_name LIKE '%".$input_search_text."%' and status='1'";		
			$this->db->select('state_name,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->state_name."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'seller_warehouse'){
			$where = "warehouse_code LIKE '%".$input_search_text."%' and status='1'";		
			$this->db->select('warehouse_code,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->warehouse_code."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'seller_product'){
			if($depend_box_id != false){
				$depend_sql = " and seller_id=".$depend_box_id." ";
			}else{
				$depend_sql = "";
			}
			$where = "product_name LIKE '%".$input_search_text."%' ".$depend_sql." and status='1' ";		
			$this->db->select('product_name,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->product_name."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'city_master'){
			if($depend_box_id != false){
				$depend_sql = " and state_id=".$depend_box_id." ";
			}else{
				$depend_sql = "";
			}
			$where = "city_name LIKE '%".$input_search_text."%' and status='1' ".$depend_sql." ";		
			$this->db->select('city_name,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->city_name."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'pincode_master'){
			if($depend_box_id != false){
				$depend_sql = " and city_id=".$depend_box_id." ";
			}else{
				$depend_sql = "";
			}
			$where = "pincode LIKE '%".$input_search_text."%' and status='1' ".$depend_sql." ";		
			$this->db->select('pincode,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
    		echo $this->db->last_query();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->pincode."</td></tr>";
	    	}
	    	return $str;
		}
		if($db_table_name == 'seller_master'){
			$where = "seller_name LIKE '%".$input_search_text."%' and status='1'";		
			$this->db->select('seller_name,id');
    		$this->db->from($db_table_name);
    		$this->db->where($where);
    		$result = $this->db->get();
	    	foreach($result->result() as $row){
	    		$str.="<tr><td class='dropdown_td' id='sm_".$row->id."' name='".$row->id."' onclick='get_dropdown_value(this.id,\"$search_box_id\",\"$result_table_id\",\"$value_box_id\",\"$db_table_name\")' >".$row->seller_name."</td></tr>";
	    	}
	    	return $str;
		}
	
	}

}
?>