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
$route['default_controller'] = 'pages/home';
$route['truyen-(:any)'] = 'pages/story/$1';
$route['truyen-(:any)/(:num)'] = 'pages/story/$1/$2';
$route['truyen-(:any)/chuong-(:num).html'] = 'pages/chapter/$1/$2';
$route['the-loai-(:any)'] = 'pages/tag/$1';
$route['the-loai-(:any)/(:num)'] = 'pages/tag/$1/$2';
$route['tac-gia-(:any)'] = 'pages/author/$1';
$route['tac-gia-(:any)/(:num)'] = 'pages/author/$1/$2';
$route['tim-kiem'] = 'pages/search';
$route['admin'] = 'dashboard/home';
$route['admin/truyen'] = 'story/index';
$route['admin/truyen/them-moi.html'] = 'story/create';
$route['admin/truyen/chinh-sua-(:any).html'] = 'story/edit/$1';
$route['admin/truyen/xoa-(:any).html'] = 'story/del/$1';
$route['admin/truyen-(:any)/danh-sach-chuong'] = 'chapter/index/$1';
$route['admin/truyen-(:any)/danh-sach-chuong/(:num)'] = 'chapter/index/$1/$2';
$route['admin/them-chuong-moi.html'] = 'chapter/create';
$route['admin/truyen-(:any)/chinh-sua-chuong-(:num).html'] = 'chapter/edit/$1/$2';
$route['admin/truyen-(:any)/xoa-chuong-(:num).html'] = 'chapter/del/$1/$2';
$route['admin/the-loai'] = 'tag/index';
$route['admin/the-loai/them-moi.html'] = 'tag/create';
$route['admin/the-loai/chinh-sua-(:any).html'] = 'tag/edit/$1';
$route['admin/the-loai/xoa-(:any).html'] = 'tag/del/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
