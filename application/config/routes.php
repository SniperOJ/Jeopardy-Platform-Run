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

$route['challenge/get_all_challenges'] = 'challenge/get_all_challenges';
$route['challenge/get_challenge_info/(:num)'] = 'challenge/get_challenge_info';
$route['challenge/get_type_challenges/(:any)'] = 'challenge/get_type_challenges';
$route['challenge/create'] = 'challenge/create_challenge';
$route['challenge/update'] = 'challenge/update_challenge';
$route['challenge/submit'] = 'challenge/submit';
$route['challenge/delete/(:num)'] = 'challenge/delete_challenge';
$route['challenge/progress'] = 'challenge/progress';
$route['challenge/progress_qqbot'] = 'challenge/progress_qqbot';
$route['challenge/(:any)'] = 'challenge/view';
$route['challenge'] = 'challenge/view';

$route['user/register'] = 'user/register';
$route['user/check_username_existed'] = 'user/check_username_existed';
$route['user/check_email_existed'] = 'user/check_email_existed';
$route['user/get_captcha'] = 'user/get_captcha';
$route['user/check_captcha_current'] = 'user/check_captcha_current';
$route['user/login'] = 'user/login';
$route['user/active/(:any)'] = 'user/active';
$route['user/verify/(:any)'] = 'user/verify_reset_code';
$route['user/forget'] = 'user/forget';
$route['user/reset'] = 'user/reset';
$route['user/score'] = 'user/score';
$route['user/rank_bot'] = 'user/rank_bot';
$route['user/logout'] = 'user/logout';
$route['user/(:any)'] = 'user/profile';
$route['user'] = 'user/profile';

$route['home/view'] = 'home/view';
$route['home/(:any)'] = 'home/view';
$route['home'] = 'home/view';

$route['(:any)'] = 'home/view';

$route['default_controller'] = 'home/view';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
