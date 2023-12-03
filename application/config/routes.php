<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'login';
// $route['admin'] = 'auth';
$route['store/(:num)'] = 'store/store_list_by_id';

// $route['store/details/(:num)'] = 'store/store_details_by_id';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['how-it-works'] = 'how_it_works';

//$route['store_details'] = 'store_details';
$route['store-details/:num'] = 'store_details';
$route['admin'] = 'admin/login';

