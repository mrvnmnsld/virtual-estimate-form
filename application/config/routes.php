<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['dashboard'] = 'main/dashboard';
$route['patient/followup'] = 'followup/create';

$route['admin'] = 'main/admin';
$route['forms'] = 'main/forms';
$route['logout'] = 'main/logout';
$route['info'] = 'main/info';
$route['testEmail'] = 'main/testEmail';


$route[(':any')] = 'main/error';