<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/* -------------------------------------------- USER INTERFACE ---------------------------------------------------------- */

$route[''] = "users_interface/index";
$route['admin']	= "users_interface/admin_login";

$route['resort/:any/:any/:num/book'] = "users_interface/unit_book";
$route['resort/:any/:any/information'] = "users_interface/unit_information";
$route['resort/:any/:any'] = "users_interface/zone_subcontent";
$route['resort/:any']	= "users_interface/zone_content";

$route['book'] = "users_interface/choice_zone";
$route['resorts-photo'] = "users_interface/choice_zone";
$route['video'] = "users_interface/choice_zone";
$route['camers'] = "users_interface/choice_zone";
$route['news'] = "users_interface/choice_zone";

$route['zone/:num/book'] = "users_interface/order";
$route['zone/:num/news'] = "users_interface/zone_news";
$route['zone/:num/news/:num'] = "users_interface/zone_news";
$route['zone/:num/resorts-photo'] = "users_interface/resorts_photo";
$route['zone/:num/video'] = "users_interface/video";
$route['zone/:num/camers'] = "users_interface/camers";

$route['weather'] = "users_interface/weather";
$route['payment'] = "users_interface/payment";
$route['map-of-sochi'] = "users_interface/map";
$route['contacts'] = "users_interface/contacts";
$route['reviews'] = "users_interface/reviews";
$route['reviews/:num'] = "users_interface/reviews";

$route['catalog/viewimage/:num'] = "users_interface/viewimage";
$route['unit/viewimage/:num'] = "users_interface/viewimage";

/* -------------------------------------------- ADMIN INTERFACE ---------------------------------------------------------- */
$route['profile'] = "admin_interface/profile";
$route['shutdown'] = "admin_interface/shutdown";