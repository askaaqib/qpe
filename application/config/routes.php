<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'users/login';
$route['register'] = 'users/register';

$route['default_controller'] = 'users';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
