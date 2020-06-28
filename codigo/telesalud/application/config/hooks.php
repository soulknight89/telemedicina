<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
//$hook['post_controller'][] = array(
//	'class' => 'Hook_sesion',
//	'function' => 'save_log',
//	'filename' => 'Hook_session.php',
//	'filepath' => 'hooks'
//);

$hook['post_controller'][] = array(
	'class' => 'Hook_sesion',
	'function' => 'check_login',
	'filename' => 'Hook_session.php',
	'filepath' => 'hooks'
);
