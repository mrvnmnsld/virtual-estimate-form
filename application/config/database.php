<?php
defined('BASEPATH') or exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn' => '',
	// 'hostname' => '192.168.1.98',
	'hostname' => '153.92.15.82',
	'username' => 'u871114563_root',
	'password' => 'Mariel121721!',
	'database' => 'u871114563_vrtestm',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'connect_timeout' => 10
);
