<?php

require_once __DIR__ . '/bootstrap.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app['debug'] = true;

$app->register(new DoctrineServiceProvider(), array(
	'db.options' => array (
		'driver' => 'pdo_mysql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'password' => 'root',
		'dbname' => 'silex'
	)
));

$app->register(new TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/views' 
));

$restUser = $app['controllers_factory'];
$restUser->get('/{id}', 'Rock\Rest\Controller\UserController::index')->value('id', null);
$restUser->post('/', 'Rock\Rest\Controller\UserController::create');
$restUser->put('/{id}', 'Rock\Rest\Controller\UserController::update')->value('id', null);
$restUser->delete('/{id}', 'Rock\Rest\Controller\UserController::delete')->value('id', null);
$app->mount('/rest/user', $restUser);

$index = $app['controllers_factory'];
$index->get('/', 'Rock\Controller\IndexController::index');
$app->mount('/', $index);

$user = $app['controllers_factory'];
$user->get('/', 'Rock\Controller\UserController::index');
$app->mount('/user', $user);

$app->error(function (\Exception $e, $code) use ($app) {
	switch ($code) {
		case 404:
			$message = $app['twig']->render('error404.twig', array(
				'code' => $code,
				'message' => $e->getMessage () 
			));
			break;
		default:
			$message = $e->getMessage() . ' no arquivo ' . $e->getFile() . ', na linha: ' . $e->getLine();
			break;
	}
	return new Response($message, $code);
});
