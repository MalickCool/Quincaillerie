<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class inventaire_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'inventaire';
    }

    public function get_db_table_id(){
        return 'idinventaire';
    }

    function add_item($post_data) {
        $this->db->insert('inventaire',$post_data);
        return $this->db->insert_id();
    }

    public function getAllWithDetails(){
        $this->db->select('inv.*, ent.designation');
        $this->db->from('inventaire inv, entrepot ent');
        $this->db->where('inv.identrepot = ent.identrepot');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTodayInventairesWithDetails(){
        $this->db->select('inv.*, ent.designation');
        $this->db->from('inventaire inv, entrepot ent');
        $this->db->where('inv.identrepot = ent.identrepot');
        $this->db->where('inv.dateinventaire', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getInventairesWithDetailsByPeriode($debut, $fin){
        $this->db->select('inv.*, ent.designation');
        $this->db->from('inventaire inv, entrepot ent');
        $this->db->where('inv.identrepot = ent.identrepot');
        $this->db->where('inv.dateinventaire >=', date('Y-m-d', strtotime($debut)));
        $this->db->where('inv.dateinventaire <=', date('Y-m-d', strtotime($fin)));
        $query = $this->db->get();
        return $query->result();
    }

    public function getTodayInventairesWithDetails2($entrepot){
        $this->db->select('inv.dateinventaire, ent.designation AS entrepot, det.*, p.designation');
        $this->db->from('inventaire inv, entrepot ent, detailinventaire det, produits p');
        $this->db->where('inv.identrepot = ent.identrepot');
        $this->db->where('inv.idinventaire = det.idinventaire');
        $this->db->where('det.idproduit = p.idproduit');
        if(!is_null($entrepot)){
            $this->db->where('inv.identrepot', $entrepot);
        }
        $this->db->where('inv.dateinventaire', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getInventairesWithDetailsByPeriode2($debut, $fin, $entrepot){
        $this->db->select('inv.dateinventaire, ent.designation AS entrepot, det.*, p.designation');
        $this->db->from('inventaire inv, entrepot ent, detailinventaire det, produits p');
        $this->db->where('inv.identrepot = ent.identrepot');
        $this->db->where('inv.idinventaire = det.idinventaire');
        $this->db->where('det.idproduit = p.idproduit');
        if(!is_null($entrepot)){
            $this->db->where('inv.identrepot', $entrepot);
        }
        $this->db->where('inv.dateinventaire >=', date('Y-m-d', strtotime($debut)));
        $this->db->where('inv.dateinventaire <=', date('Y-m-d', strtotime($fin)));
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
