<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class actioncaisse_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'actioncaisse';
    }

    public function get_db_table_id(){
        return 'idac';
    }

    function add_item($post_data) {
        $this->db->insert('actioncaisse',$post_data);
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

	public function arretCaisseDidExists($idCaisse){
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where("caisse_id", $idCaisse);
		$this->db->where("date_ouverture", date('Y/m/d'));
		$query = $this->db->get();
		$result = $query->result();
		$rep = false;
		if(!empty($result)){
			$rep = true;
		}
		return $rep;
	}

	public function getArretCaisse($idCaisse){
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where("caisse_id", $idCaisse);
		$this->db->where("date_ouverture", date('Y/m/d'));
		$query = $this->db->get();
		return $query->result();
	}
}
