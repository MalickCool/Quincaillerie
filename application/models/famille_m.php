<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class famille_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'famille';
    }

    public function get_db_table_id(){
        return 'idfamille';
    }

    function add_item($post_data) {
        $this->db->insert('famille',$post_data);
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

    function getFamilleByName($name) {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('libelle', $name);
        $this->db->order_by($this->get_db_table_id(),'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getProducts($idFamille){
        $this->db->select('*');
        $this->db->from('produits');
        $this->db->where('produits.idfamille', $idFamille);
        $query = $this->db->get();
        return $query->result();
    }

    function getProductsByPV($idFamille, $idpoint){
        $this->db->select('produits.*, stockproduits.qte AS quantite');
        $this->db->from('produits, stockproduits');
        $this->db->where('produits.idproduit = stockproduits.idproduit');
        $this->db->where('stockproduits.idpoint', $idpoint);
        $this->db->where('produits.idfamille', $idFamille);
        $query = $this->db->get();
        return $query->result();
    }

    function getProductsActivatedWithFT($idFamille){
        $this->db->select('*');
        $this->db->from('produits');
        $this->db->where('produits.idfamille', $idFamille);
        $this->db->where('etat = 0');
        $this->db->where('fichetechnique = 1');
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