<?php

namespace Rock\RestController;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

class UserController
{
	public function index(Application $app, $id)
	{
		if ($id) {
			$user = $app['db']->fetchAssoc('SELECT * FROM user WHERE id = :id', array('id' => (int) $id));
			if (!$user) {
				return $app->json(array('message' => 'Usuário não encontrado'), 404);
			}
			return $app->json($user, 200);
		}
		$users = $app['db']->fetchAll('SELECT * FROM user');
		return $app->json($users, 200);
	}
	
	public function save(Request $request, Application $app)
	{
		$data = $request->request->all();
		if ($data['id']) {
			$app['db']->update('user', array('name' => $data['name'], 'email' => $data['email']), array('id' => (int) $data['id']));
			return $app->json(array('message' => 'Usuário alterado'), 200);
		} else {
			$app['db']->insert('user', array('name' => $data['name'], 'email' => $data['email']));
			return $app->json(array('message' => 'Usuário cadastrado'), 200);
		}
	}
	
	public function delete(Application $app, $id)
	{
		$delete = $app['db']->delete('user', array('id' => (int) $id));
		return $app->json($delete, 200);
	}
}