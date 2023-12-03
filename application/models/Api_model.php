<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }
	
	function get_one_detail($table, $id)
	{
		$data = $this->db->get_where($table, ['id' => $id])->result_array();
		
		return $data;
	}

	function make_query($select_column, $table, $order_column, $search_column, $join='')  
	  {  

	  		// pre($select_column);
	  		// pre($table);
	  		// pre($order_column);
	  		// pre($search_column);
	  		// pre($join);
	       $this->db->select($select_column);  
	       $this->db->from($table);
	       if(!empty($join))
	       {
	       		$this->db->join($join[0], $join[1], $join[2]);
	       }
	      
	       if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '')  
	       {  
	       		for ($i=0; $i < count($search_column); $i++) 
	       		{ 
	       			if($i == 0)
	       			{
	       				$this->db->like($search_column[$i], $_POST["search"]["value"]);  
	       			}
	       			else
	       			{
	       				$this->db->or_like($search_column[$i], $_POST["search"]["value"]);  
	       			}
	       		}
	            
	            
	       }  
	       if(isset($_POST["order"]))  
	       {  
	            $this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
	       }  
	       else  
	       {  
	            $this->db->order_by('id', 'DESC');  
	       }  
	  }  


	  function make_datatables($select_column, $table, $order_column, $search_column, $join=''){  
	       $this->make_query($select_column, $table, $order_column, $search_column, $join);  
	       if($_POST["length"] != -1)  
	       {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	       }  
	       $query = $this->db->get(); 
	       // pre($this->db->last_query()); 
	       return $query->result();  
	  } 

	  function get_all_data($table, $join = '')  
	  {  
	  		if(!empty($join))
	  		{
	  			$this->db->select("*");  
	       		$this->db->from($table);  
	       		$this->db->join($join[0], $join[1], $join[2]);
	  		}
	  		else
	  		{
	  			$this->db->select("*");  
	      		$this->db->from($table);  	
	  		}
	       
	       return $this->db->count_all_results();  
	  }   

	  function get_filtered_data($select_column, $table, $order_column, $search_column, $join = ''){  
	       $this->make_query($select_column, $table, $order_column, $search_column, $join);  
	       $query = $this->db->get();  
	       return $query->num_rows();  
	  } 

	function get_columns($table, $columns, $condition_field = '', $condition_value = '')
	{
		$this->db->select($columns);
		$this->db->from($table);
		if($condition_field != '')
		{
			$this->db->where($condition_field, $condition_value);
		}
		
		$data = $this->db->get()->result_array();
		
		return $data;
	}

	function fetch_related_data($table, $id, $ref_column)
	{
		$data = $this->db->get_where($table, [$ref_column => $id])->result_array();
		
		return $data;
	}

}