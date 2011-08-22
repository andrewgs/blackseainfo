<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/* -------------------------------------------- USER INTERFACE ---------------------------------------------------------- */

$route[''] = "users_interface/index";
$route['admin']	= "users_interface/admin_login";
$route['zone/:num']	= "users_interface/zone_content";
$route['zone/:num/catalog/:num/information'] = "users_interface/unit_information";
$route['zone/1/catalog/1/book'] = "users_interface/unit_book";

$route['fun/:num']	= "users_interface/choice_zone";
$route['reviews'] = "users_interface/choice_zone";
$route['book'] = "users_interface/choice_zone";
$route['resorts-photo'] = "users_interface/choice_zone";
$route['video'] = "users_interface/choice_zone";
$route['camers'] = "users_interface/choice_zone";
$route['news'] = "users_interface/choice_zone";
$route['weather'] = "users_interface/choice_zone";

$route['payment'] = "users_interface/payment";
$route['map-of-sochi'] = "users_interface/map_of_sochi";
$route['contacts'] = "users_interface/contacts";

$route['catalog/viewimage/:num'] = "users_interface/viewimage";
$route['unit/viewimage/:num'] = "users_interface/viewimage";

/* -------------------------------------------- ADMIN INTERFACE ---------------------------------------------------------- */
$route['profile'] = "admin_interface/profile";
$route['shutdown'] = "admin_interface/shutdown";