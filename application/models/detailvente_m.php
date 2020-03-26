<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class detailvente_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'detailvente';
    }

    public function get_db_table_id(){
        return 'iddetailvente';
    }

    public function get_db_table_foreign(){
        return 'vente_id';
    }

    function add_item($post_data) {
        $this->db->insert('detailvente',$post_data);
        return $this->db->insert_id();
    }

    function getByForeignKey2($idForeignKey) {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where($this->get_db_table_foreign(), $idForeignKey);
        $this->db->where('etat <> 1');
        $query = $this->db->get();
        return $query->result();
    }

    function checkIfAlreadyExist($idForeignKey, $idproduit) {
        $this->db->select('*');
        $this->db->from($this->get_db_table());
        $this->db->where('vente_id', $idForeignKey);
        $this->db->where('produit_id', $idproduit);
        $this->db->where('etat <> 2');
        $query = $this->db->get();
        return $query->result();
    }

    function getNbreByBriqueId($idbrique, $begin, $end) {
        $realDateBegin = date('Y-m-d', strtotime($begin));
        $realDateEnd = date('Y-m-d', strtotime($end));
        $this->db->select('detailvente.*');
        $this->db->from('detailvente, vente');
        $this->db->where('detailvente.vente_id = vente.idvente');
        $this->db->where('brique_id', $idbrique);
        $this->db->where('vente.etat > -1');
        $this->db->where('vente.datevente > -1');
        $this->db->where('vente.datevente >=', $realDateBegin);
        $this->db->where('vente.datevente <=', $realDateEnd);
        $query = $this->db->get();
        return $query->result();
    }



    function getDetailsNew($iddetail){
        $this->db->select('detailcomposition.*, intrants.designation');
        $this->db->from('detailcomposition, intrants');
        $this->db->where('detailcomposition.idintrant = intrants.idintrant');
        $this->db->where('detailcomposition.idcomposition', $iddetail);
        $query = $this->db->get();
        return $query->result();
    }

    function getDetails($iddetail){
        $this->db->select('detailcomposition.*, intrants.designation, unites.designation AS unite, unites.symbole');
        $this->db->from('detailcomposition, intrants, unites');
        $this->db->where('detailcomposition.idintrant = intrants.idintrant');
        $this->db->where('detailcomposition.idunite = unites.idunite');
        $this->db->where('detailcomposition.idcomposition', $iddetail);
        $query = $this->db->get();
        return $query->result();
    }

    function getIntrantsOnly($iddetail){
        $this->db->select('detailcomposition.idintrant');
        $this->db->from('detailcomposition, intrants');
        $this->db->where('detailcomposition.idintrant = intrants.idintrant');
        $this->db->where('detailcomposition.idcomposition', $iddetail);
        $query = $this->db->get();
        return $query->result();
    }

    function deleteAllByFTId($idcomposition)
    {
        $this->db->delete('detailcomposition', array('idcomposition' => $idcomposition));
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
