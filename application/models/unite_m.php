<?php
/**
 * Created by PhpStorm.
 * User: Malick Coulibaly
 * Date: 01/07/2020
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class unite_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_db_table(){
		return 'unite';
	}

	public function get_db_table_id(){
		return 'idunite';
	}

	function add_item($post_data) {
		$this->db->insert('unite',$post_data);
		return $this->db->insert_id();
	}

	function getRootUnities() {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where('parent = 0');
		$this->db->order_by($this->get_db_table_id(),'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function getHisChild($id) {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where('parent', $id);
		$this->db->order_by($this->get_db_table_id(),'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function getActivated() {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where('etat = 0');
		$this->db->order_by($this->get_db_table_id(),'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function exist($token){
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where("token", $token);
		$query = $this->db->get();
		$result = $query->result();
		$rep = false;
		if(!empty($result)){
			$rep = true;
		}
		return $rep;
	}
}
