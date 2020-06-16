<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class prix_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'prix';
    }

    public function get_db_table_id(){
        return 'idPrix';
    }

    function add_item($post_data) {
        $this->db->insert('prix',$post_data);
        return $this->db->insert_id();
    }

    function getActivated() {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('etat = 0');
        $this->db->where('deleted = 0');
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

	function getPrices($idProduit) {
		$this->db->select('prix.*, typeclient.designation');
		$this->db->from('prix, typeclient');
		$this->db->where('prix.tyclient_id = typeclient.idType');
		$this->db->where('produit_id', $idProduit);
		$this->db->where('deleted = 0');
		$query = $this->db->get();
		return $query->result();
	}

	function getPrice($idProduit, $idType) {
		$this->db->select('prix');
		$this->db->from('prix');
		$this->db->where('produit_id', $idProduit);
		$this->db->where('tyclient_id', $idType);
		$this->db->where('etat = 0');
		$this->db->where('deleted = 0');
		$query = $this->db->get();
		return $query->result();
	}
}
