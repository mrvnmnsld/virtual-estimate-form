<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['dashboard'] = 'main/dashboard';
$route['patient/followup'] = 'followup/create';

$route['admin'] = 'main/admin';
$route['forms'] = 'main/forms';
$route['submitted-forms'] = 'main/submittedForms';
$route['logout'] = 'main/logout';
$route['info'] = 'main/info';

$route['getSampleImages'] = 'main/getSampleImages';
$route['getChargerModels'] = 'main/getChargerModels';
$route['addChargerModel'] = 'main/addChargerModel';
$route['submitEstimate'] = 'main/submitEstimate';
$route['getEstimates'] = 'main/getEstimates';
$route['getEstimateDetails'] = 'main/getEstimateDetails';


$route['testEmail'] = 'main/testEmail';
$route['setupAdmin'] = 'main/setupAdmin';


$route[(':any')] = 'main/error';