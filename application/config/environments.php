<?php
/****
 * Error if .htaccess file is not accessible
 ****/
if(! defined('ENVIRONMENT') )
{
    $domain = strtolower($_SERVER['HTTP_HOST']);
    switch($domain) {
        case 'crecertrade.com' :
            define('ENVIRONMENT', 'production');
        break;

        // case 'stage.crecertrade.com' :
        //     define('ENVIRONMENT', 'staging');
        // break;

        default :
            define('ENVIRONMENT', 'development');
        break;
    }
}

?>