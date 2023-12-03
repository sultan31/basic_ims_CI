<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }
	
	function get_category_list()
	{
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*',false);
		$this->db->from('category as a');
		$this->db->order_by("created_date", "desc");
		$this->db->where('a.flag','0');
		$result = $query->get()->result_array();
		return $result;
	}
}