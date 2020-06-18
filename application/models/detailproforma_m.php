<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class detailproforma_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'detailproforma';
    }

    public function get_db_table_id(){
        return 'iddetailproforma';
    }

    public function get_db_table_foreign(){
        return 'proforma_id';
    }

    function add_item($post_data) {
        $this->db->insert('detailproforma',$post_data);
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
