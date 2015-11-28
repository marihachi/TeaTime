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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'MainController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

$route['signup'] = 'MainController/signup';
$route['(:any)'] = 'UserController/index/$1';
$route['status/(:any)'] = 'StatusController/index/$1';
$route['image/status/(:any)'] = 'ImageController/status/$1';
$route['image/header/(:any)'] = 'ImageController/header/$1';
$route['image/icon/(:any)'] = 'ImageController/icon/$1';

//
//  Web APIs
//
$route['api/web/account/create'] = 'api/web/WebAPI_AccountController/create';
$route['api/web/account/login'] = 'api/web/WebAPI_AccountController/login';
$route['api/web/account/logout'] = 'api/web/WebAPI_AccountController/logout';
$route['api/web/user/follow'] = 'api/web/WebAPI_UserController/follow';
$route['api/web/user/unfollow'] = 'api/web/WebAPI_UserController/unfollow';
$route['api/web/status/update'] = 'api/web/WebAPI_StatusController/update';
$route['api/web/status/timeline'] = 'api/web/WebAPI_StatusController/timeline';

//
// REST APIs
//
$route['api/friend/show'] = 'api/UserController/friendshow';
$route['api/status/show'] = 'api/StatusController/show';
$route['api/status/timeline'] = 'api/StatusController/timeline';
