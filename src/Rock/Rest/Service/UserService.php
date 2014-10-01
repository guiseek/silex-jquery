<?php

namespace Rock\Rest\Service;

use Silex\Application;

class UserService {
	private $db;
	private $table = 'user';
	public function __construct($db)
	{
		$this->db = $db;
	}
	public function find($id)
	{
		return $this->db->fetchAssoc("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
	}
	public function findAll()
	{
		return $this->db->fetchAll("SELECT * FROM {$this->table}");
	}
	public function create($data)
	{
		return $this->db->insert($this->table, ['name' => $data['name'], 'email' => $data['email']]);
	}
	public function update($id, $data)
	{
		return $this->db->update($this->table, ['name' => $data['name'],'email' => $data['email']], ['id' => $id]);
	}
	public function delete($id)
	{
		return $this->db->delete($this->table, ['id' => $id]);
	}
}

?>