<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/* -------------------------------------------- USER INTERFACE ---------------------------------------------------------- */

$route[''] = "users_interface/index";
$route['admin']	= "users_interface/admin_login";
$route['zone/:num']	= "users_interface/zone_content";
$route['fun/:num']	= "users_interface/fun_content";
$route['catalog/viewimage/:num'] = "users_interface/viewimage";
$route['unit/viewimage/:num'] = "users_interface/viewimage";

/* -------------------------------------------- ADMIN INTERFACE ---------------------------------------------------------- */
$route['profile'] = "admin_interface/profile";
$route['shutdown'] = "admin_interface/shutdown";