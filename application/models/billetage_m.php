<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class argent_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'argent';
    }

    public function get_db_table_id(){
        return 'id_argent';
    }

    function add_item($post_data) {
        $this->db->insert('argent',$post_data);
        return $this->db->insert_id();
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

	function getByType($type) {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where('type', $type);
		$this->db->where('etat = 0');
		$this->db->order_by($this->get_db_table_id(),'DESC');
		$query = $this->db->get();
		return $query->result();
	}
}
