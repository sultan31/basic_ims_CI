<?php
class Logs
{
    private $CI;

    function createLogs()
    {
        $this->CI   = &get_instance();
        $query      = $this->CI->db->queries;

        $filepath   = 'logs/'.date('Y-m-d') . '.php';
        $str        ="";

        if(!file_exists($filepath))
        {
            $str    .= "userid | username | ipaddress | datetime | query \n\n";
        }

        $handle             = fopen($filepath, "a+");
        $user_id            = $this->CI->session->userdata('user_id');
        $username           = $this->CI->session->userdata('username');
        $ipaddress          = $_SERVER['REMOTE_ADDR'];
        $datetime           = date('Y-m-d h:i:s');

        if(is_array($query) && count($query) > 0)
        {
            foreach ($query as $key => $value)
            {
                if(strtolower(substr($value, 0,6))!="select")
                {   
                    $str    .= $user_id ." | " . $username . " | " . $ipaddress ." | " . $datetime ." | " . $value ."\n";
                }
            }
        }

        fwrite($handle, $str);
        fclose($handle);
    }
}
?>