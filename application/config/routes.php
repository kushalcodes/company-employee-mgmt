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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'dashboard_controller';
$route['admin/login'] = 'dashboard_controller/admin_login';
$route['admin/company/(:num)'] = 'company_controller/index/$1';
$route['admin/company'] = 'company_controller/rdr_index';
$route['admin/company/delete/(:num)'] = 'company_controller/delete/$1';
$route['admin/company/edit'] = 'company_controller/edit';
$route['admin/employee/(:num)'] = 'employee_controller/index/$1';
$route['admin/employee'] = 'employee_controller/rdr_index';
$route['logout'] = 'dashboard_controller/logout';
// apis
$route['v1/api/admin/employee/create']['post'] = 'employee_controller/create';
$route['v1/api/admin/employee/delete/(:num)']['delete'] = 'employee_controller/delete/$1';
$route['v1/api/admin/employee/edit']['post'] = 'employee_controller/edit';
$route['v1/api/admin/employee/update_company']['post'] = 'employee_controller/update_company';
