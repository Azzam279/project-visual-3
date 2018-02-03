<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model1 extends CI_Model {

	public function selectData($table) {
		return $res = $this->db->get($table);
	}

	public function selectWhere($table, $where) {
		return $res = $this->db->get_where($table, $where);
	}

	public function selectLimit($table, $start, $limit) {
		return $res = $this->db->get($table, $start, $limit);
	}

	public function selectQuery($query, $data) {
		return $res = $this->db->query($query, $data);
	}

	public function selectQuery2($query) {
		return $res = $this->db->query($query);
	}

	public function selectWhereSpec($table,$array) {
		$this->db->where($array);
		return $this->db->get($table);
	}

	public function insertData($table, $data) {
		foreach ($data as $name => $value) {
			$this->db->set($name, $value);
		}
		return $this->db->insert($table);
	}

	public function updateData($name, $val, $table, $data) {
		$this->db->where($name, $val);
		return $this->db->update($table, $data);
	}

	public function updateDataSpec($array, $table, $data) {
		$this->db->where($array);
		return $this->db->update($table, $data);
	}

	public function deleteData($table, $where) {
		$this->db->where($where);
		return $this->db->delete($table);
	}

	public function joinData($table1, $table2, $type, $ket) {
		$query = "SELECT * FROM $table1 $type $table2 ON $ket";
		return $this->db->query($query);
	}

	public function SUM($table, $sum, $array) {
		$this->db->select_sum($sum);
		$this->db->where($array);
		return $this->db->get($table);
	}

}

/* End of file model.php */
/* Location: ./application/models/model.php */