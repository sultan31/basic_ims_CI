<?php

class Access_control
{
    var $CI;

    function __construct()
    {
        $this->CI =& get_instance();
    }

    function access_rights() 
    {        
        //print_r($this->CI->session->all_userdata());       
        if( $this->CI->session->userdata('user_id') != '' && $this->CI->router->fetch_class() !='logout')
        {   
            //print_r($this->CI->session->all_userdata());
            $user_id = $this->CI->session->userdata('user_id');            

            $ignore = array('masters','login','fedex','total_order_excel', 'religare_incremental_date_excel', 'justpay_dis_req_excel','user_registration_excel','dedupe_excel_incremental','daily_statistics_report','religare','disbursment_approval','disbursment_approval_excel','seller_margin','dedupe_excel_tilldate','cibil_tell_date_excel','cibil_incremental_date_excel','dedupe_check','plupload','schedular_cron','religare_excel','cron_notification');

            if($this->CI->router->fetch_class() != '' && (!in_array($this->CI->router->fetch_class(), $ignore)))
            {
                if($this->CI->session->userdata('href') !="" && $this->CI->session->userdata('href') == $this->CI->router->fetch_class())
                {  
                    if($this->CI->session->userdata('read') == 1)
                    {                                                
                        $flag = 'TRUE';                       
                    }
                    else
                    {    
                        $flag = 'FALSE';
                    }                    
                }
                else
                {                    
                    $this->CI->db->select('admin_group_id');
                    $this->CI->db->where('user_id', $user_id); 

                    $group_id                       = $this->CI->db->get('admin_user_groups')->result_array();
                    $controller_name                = $this->CI->router->fetch_class();

                    $this->CI->db->select('id');
                    $this->CI->db->like('controller_name', $controller_name);
                    $menu_id            =  $this->CI->db->get('admin_navigation_menu')->result_array();
                    if(!empty($menu_id))
                    {
                        $this->CI->db->select('read,write,delete');
                        $this->CI->db->where('admin_navigation_menu_id', $menu_id[0]['id']); 
                        $this->CI->db->where('admin_group_id', $group_id[0]['admin_group_id']);
                        $result             = $this->CI->db->get('admin_access_rights')->result_array();
                        $this->CI->session->set_userdata('href', $controller_name);                   

                        if(!empty($result))
                        {
                            $this->CI->session->set_userdata('read', $result[0]['read']);
                            $this->CI->session->set_userdata('write', $result[0]['write']);
                            $this->CI->session->set_userdata('delete', $result[0]['delete']);
                            if($result[0]['read'] == 1)
                            {
                                $flag = 'TRUE'; 
                            }
                            else
                            {                                 
                                $flag = 'FALSE';
                            }                            
                        }
                        else
                        {                              
                           $flag = 'FALSE';
                        }
                    }
                    else
                    {                        
                       $flag = 'FALSE';                    
                    }
                }
               
                if($flag == 'FALSE') 
                {
                    $this->CI->output->set_output('');
                    $this->CI->output->set_status_header('403');
                    exit($this->CI->load->view('403', null, true)); 
                }
                else
                {
                    return true;
                }
                             
            }        
       
        }       

    }
} 

?>