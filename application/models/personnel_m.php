<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class paiement_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'paiements';
    }

    public function get_db_table_id(){
        return 'idpaiement';
    }

    public function get_db_table_date(){
        return 'datepaiement';
    }

    public function get_db_table_foreign(){
        return 'vente_id';
    }

    function add_item($post_data) {
        $this->db->insert('paiements',$post_data);
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

    function getTodayPaiement() {
        $this->db->select_sum('montant');
        $this->db->from('paiements');
        $this->db->where('datepaiement', date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getADayPaiement($day) {
        $this->db->select_sum('montant');
        $this->db->from('paiements');
        $this->db->where('datepaiement', date('Y-m-d', strtotime($day)));
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getSumByCommandeId($idCommande) {
        $this->db->select_sum('montant');
        $this->db->from($this->get_db_table());
        $this->db->where('vente_id', $idCommande);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getPaiementGauche($idCmd, $idPaiement) {
        $this->db->select_sum('montant');
        $this->db->from($this->get_db_table());
        $this->db->where('idpaiement <', $idPaiement);
        $this->db->where('vente_id =', $idCmd);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

	function getPaiementGauche0($day) {
		$realDate = date('Y-m-d', strtotime($day));
		$this->db->select_sum('montant');
		$this->db->from($this->get_db_table());
		$this->db->where('datepaiement <=', $realDate);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0]->montant;
	}

	function getPaiementDroite0($day) {
		$realDate = date('Y-m-d', strtotime($day));
		$this->db->select_sum('montant');
		$this->db->from($this->get_db_table());
		$this->db->where('datepaiement >', $realDate);
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
