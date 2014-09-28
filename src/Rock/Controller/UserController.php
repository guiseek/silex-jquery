<?php

namespace Rock\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
	public function index(Request $request, Application $app)
	{
		return $app['twig']->render('user/index.twig', array(
		));
	}
}