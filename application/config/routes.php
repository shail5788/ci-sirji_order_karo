<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//API Routes

// $route['api/v1/user/register']="api/userController/register";
// $route['api/v1/user/login']="api/userController/login";
// $route['api/v1/user/get-user']="api/userController/get_user";
// $route['api/v1/user/get-all-user']="api/userController/get_users";
// $route['api/v1/user/send-otp']="api/userController/re_send_otp";
// $route['api/v1/user/otp-verfify']="api/userController/otpVerification";

$route['v1/user/register']="api/userController/register";
$route['v1/user/login']="api/userController/login";
$route['v1/user/get-user']="api/userController/get_user";
$route['v1/user/get-all-user']="api/userController/get_users";
$route['v1/user/send-otp']="api/userController/re_send_otp";
$route['v1/user/otp-verfify']="api/userController/otpVerification";
// Brand Routes 
$route['v1/brand']="api/BrandController/create_brand";
$route['v1/brand/(:any)']="api/BrandController/get_brand";
$route['v1/brands/(:any)']="api/BrandController/get_all_brand";

// Category Route 
$route['v1/category']="api/CategoryController/create_category";
$route['v1/category/(:any)']="api/CategoryController/get_category";
$route['v1/categories/(:any)']="api/CategoryController/get_all_category";

