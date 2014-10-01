<?php

namespace Rock\Rest\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Rock\Rest\Service\UserService;

class UserController
{
	public function index(Application $app, $id)
	{
		$service = new UserService($app['db']);
		$id = (int) $id;
		if ($id) {
			$user = $service->find($id);
			if (!$user) {
				return $app->json(['message' => 'Usuário não encontrado'], 404);
			}
			return $app->json($user, 200);
		}
		$users = $service->findAll();
		return $app->json($users, 200);
	}
	public function create(Request $request, Application $app)
	{
		if (!$request->request->count()) {
			return $app->json(['message' => 'Informe um usuário'], 400);
		}
		$data = $request->request->all();
		$service = new UserService($app['db']);
		$create = $service->create($data);
		if ($create) {
			return $app->json(['message' => 'Usuário cadastrado'], 200);
		} else {
			return $app->json(['message' => 'Falha ao cadastrar usuário'], 500);
		}
	}
	public function update(Request $request, Application $app, $id)
	{
		$id = (int) $id;
		if (!$id) {
			return $app->json(['message' => 'Informe um id'], 400);
		}
		$service = new UserService($app['db']);
		$user = $service->find($id);
		if (!$user) {
			return $app->json(['message' => 'Usuário não encontrado'], 404);
		}
		$data = $request->request->all();
		$update = $service->update($id, $data);
		if ($update) {
			return $app->json(['message' => 'Usuário alterado'], 200);
		} else {
			return $app->json(['message' => 'Falha ao alterar usuário'], 500);
		}
	}
	public function delete(Application $app, $id)
	{
		$id = (int) $id;
		if (!$id) {
			return $app->json(['message' => 'Informe um id'], 400);
		}
		$service = new UserService($app['db']);
		$user = $service->find($id);
		if (!$user) {
			return $app->json(['message' => 'Usuário não encontrado'], 404);
		}
		$delete = $service->delete($id);
		if ($delete) {
			return $app->json(array('message' => 'Usuário deletado'), 200);
		} else {
			return $app->json(array('message' => 'Falha ao deletar usuário'), 500);
		}
	}
}