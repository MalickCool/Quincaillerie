<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class versement_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'versements';
    }

    public function get_db_table_id(){
        return 'idversement';
    }

    function add_item($post_data) {
        $this->db->insert('versements',$post_data);
        return $this->db->insert_id();
    }

    function getTodayVersement() {
        $this->db->select_sum('montant');
        $this->db->from('versements');
        $this->db->where('dateversement', date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getTodayVersementListe() {
        $this->db->select('*');
        $this->db->from('versements');
        $this->db->where('dateversement', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    function getVersementByPerode($begin, $end) {
        $realDateBegin = date('Y-m-d', strtotime($begin));
        $realDateEnd = date('Y-m-d', strtotime($end));
        $this->db->select_sum('montant');
        $this->db->from('versements');
        $this->db->where('dateversement >=', $realDateBegin);
        $this->db->where('dateversement <=', $realDateEnd);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getAPeriodeListeVersement($begin, $end) {
        $realDateBegin = date('Y-m-d', strtotime($begin));
        $realDateEnd = date('Y-m-d', strtotime($end));
        $this->db->select('*');
        $this->db->from('versements');
        $this->db->where('dateversement >=', $realDateBegin);
        $this->db->where('dateversement <=', $realDateEnd);
        $query = $this->db->get();
        return $query->result();
    }

    function getADayListeVersement($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select('*');
        $this->db->from('versements');
        $this->db->where('dateversement', $realDate);
        $query = $this->db->get();
        return $query->result();
    }

    function getADayVersement($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('versements');
        $this->db->where('dateversement', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getVersementGauche($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('versements');
        $this->db->where('dateversement <=', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getVersementDroite($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('versements');
        $this->db->where('dateversement >', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
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
