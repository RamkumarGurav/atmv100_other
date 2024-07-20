<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user';
$route['secureRegions'] = 'secureRegions/login';
$route['404_override'] = 'User/pageNotFound';
$route['translate_uri_dashes'] = TRUE;


$route['forgot-password'] = 'secureRegions/Login/forgot_password';
$route['Signup'] = 'User/registration';
$route['forgot_password'] = 'Login/forgot_password';
$route['reset_password/(:any)'] = 'Login/reset_password/$1';
$route['secureRegions/admin_reset_password/(:any)'] = 'secureRegions/Login/admin_reset_password/$1';

$route['employee-attendance'] = 'user/employee_attendance';

$route['employee-login'] = 'user/user_employee_login';
$route['ajax_user_employee_do_login'] = 'user/ajax_user_employee_do_login';
$route['employee-login-success'] = 'user/user_employee_login_success';
$route['employee-login-error'] = 'user/user_employee_login_error';

$route['employee-logout'] = 'user/user_employee_logout';
$route['ajax_user_employee_do_logout'] = 'user/ajax_user_employee_do_logout';
$route['employee-logout-success'] = 'user/user_employee_logout_success';
$route['employee-logout-error'] = 'user/user_employee_logut_error';

$route['employee'] = 'user/';
$route['contact'] = 'user/contact';
$route['ajax_insert_user_employee_login'] = 'user/ajax_insert_user_employee_login';
$route['ajax_insert_user_employee_logout'] = 'user/ajax_insert_user_employee_logout';
$route['thank-you'] = 'user/thank_you';
$route['access-denied'] = 'user/access_denied';
$route['test1p'] = 'user/test1p';



$route[__changePassword__] = 'user/change_password';
$route[__dashboard__] = 'Dashboard';


$route['profile'] = "user/profile";
$route[__forgotPassword__] = 'user/forgot-password';

$route['404found'] = "user/found404";



$route['getState'] = 'Ajax/getState';
$route['getCity'] = 'Ajax/getCity';


$route[__login__] = 'Login';
$route[__login__ . '/loginAuth'] = 'Login/loginAuth';

$route[__logout__] = 'user/logout';



