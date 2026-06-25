<?php
require 'core/bootstrap.php';

$routes = [
	/* Startseite (leitet je nach Login weiter) */
	'/' => 'WelcomeController@index',

	/* Hauptseiten */
	'/welt' => 'WelcomeController@index',
	'/auftraege' => 'WelcomeController@auftraege',
	'/mitarbeiter' => 'WelcomeController@mitarbeiter',

	/* Informationen hinzufügen */
	'/addEmploy' => 'WelcomeController@addEmploy',
	'/addOrder' => 'WelcomeController@addOrder',

	/* Informationen Löschen */
	'/deleteMit' => 'WelcomeController@deleteMit',
	'/deleteAuf' => 'WelcomeController@deleteAuf',

	/* Anhänge (Datei-Upload) */
	'/downloadAttachment' => 'WelcomeController@downloadAttachment',
	'/deleteAttachment' => 'WelcomeController@deleteAttachment',

	/* Informationen bearbeiten */
	'/updateMit' => 'WelcomeController@updateMit',
	'/updateAuf' => 'WelcomeController@updateAuf',
	'/changeStatus' => 'WelcomeController@changeStatus',

	/* Login */
	'/login' => 'WelcomeController@login',
	'/config' => 'WelcomeController@config',
	'/register' => 'WelcomeController@register',
	'/logout' => 'WelcomeController@logout',

	/* Error */
	'/error' => 'WelcomeController@error',
];

$db = [
	'name'     => 'minipaprep',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');