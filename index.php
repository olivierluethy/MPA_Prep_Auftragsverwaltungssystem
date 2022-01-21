<?php
require 'core/bootstrap.php';

$routes = [
	/* Hauptseiten */
	'/hallo/welt' => 'WelcomeController@index',
	'/hallo/auftraege' => 'WelcomeController@auftraege',
	'/hallo/mitarbeiter' => 'WelcomeController@mitarbeiter',

	/* Informationen hinzufügen */
	'/hallo/addEmploy' => 'WelcomeController@addEmploy',
	'/hallo/addOrder' => 'WelcomeController@addOrder',

	/* Informationen Löschen */
	'/hallo/deleteMit' => 'WelcomeController@deleteMit',
	'/hallo/deleteAuf' => 'WelcomeController@deleteAuf',

	/* Informationen bearbeiten */
	'/hallo/updateMit' => 'WelcomeController@updateMit',
	'/hallo/updateAuf' => 'WelcomeController@updateAuf',
	'/hallo/changeStatus' => 'WelcomeController@changeStatus',

	/* Login */
	'/hallo/login' => 'WelcomeController@login',
	'/hallo/config' => 'WelcomeController@config',
	'/hallo/register' => 'WelcomeController@register',
	'/hallo/logout' => 'WelcomeController@logout',

	/* Error */
	'/hallo/error' => 'WelcomeController@error',
];

$db = [
	'name'     => 'minipaprep',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');