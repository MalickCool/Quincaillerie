<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class produit_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'produits';
    }

    public function get_db_table_id(){
        return 'idproduit';
    }

    public function getProductWithFamilly($id)
    {
        $this->db->select('pr.*, fm.libelle');
        $this->db->from('produits pr, famille fm');
        $this->db->where('pr.idfamille = fm.idfamille');
        $this->db->where('pr.idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllProductWithFamilly()
    {
        $this->db->select('pr.*, fm.libelle');
        $this->db->from('produits pr, famille fm');
        $this->db->where('pr.idfamille = fm.idfamille');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllProductWithoutFT()
    {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('fichetechnique', 0);
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function add_item($post_data) {
        $this->db->insert('produits',$post_data);
        return $this->db->insert_id();
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

    function getActivated() {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('etat = 0');
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getActivatedWithFT() {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('etat = 0');
        $this->db->where('fichetechnique = 1');
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllIntrant($id)
    {
        $this->db->select('detailfiche.*');
        $this->db->from('fiche, detailfiche');
        $this->db->where('fiche.idfiche = detailfiche.idfiche');
        $this->db->where('fiche.idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFicheTechnique($id)
    {
        $this->db->select('*');
        $this->db->from('fiche');
        $this->db->where('fiche.idproduit', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getProdByName($name) {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('designation', $name);
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

	function getNotSelectedYet($array) {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where('etat = 0');
		$this->db->where_not_in('idproduit', $array);
		$this->db->order_by($this->get_db_table_id(),'DESC');
		$query = $this->db->get();
		return $query->result();
	}
}
