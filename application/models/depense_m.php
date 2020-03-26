<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class depense_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'depense';
    }

    public function get_db_table_id(){
        return 'iddepense';
    }

    function add_item($post_data) {
        $this->db->insert('depense',$post_data);
        return $this->db->insert_id();
    }

    function getTodayDepense() {
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense', date('Y-m-d'));
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getTodayDepenseListe() {
        $this->db->select('*');
        $this->db->from('depense');
        $this->db->where('datedepense', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    function getDepenseByPerode($begin, $end) {
        $realDateBegin = date('Y-m-d', strtotime($begin));
        $realDateEnd = date('Y-m-d', strtotime($end));
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense >=', $realDateBegin);
        $this->db->where('datedepense <=', $realDateEnd);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getAPeriodeListeDepense($begin, $end) {
        $realDateBegin = date('Y-m-d', strtotime($begin));
        $realDateEnd = date('Y-m-d', strtotime($end));
        $this->db->select('*');
        $this->db->from('depense');
        $this->db->where('datedepense >=', $realDateBegin);
        $this->db->where('datedepense <=', $realDateEnd);
        $query = $this->db->get();
        return $query->result();
    }

	function getAPeriodeListeDepenseByType($begin, $end, $type) {
		$realDateBegin = date('Y-m-d', strtotime($begin));
		$realDateEnd = date('Y-m-d', strtotime($end));
		$this->db->select('*');
		$this->db->from('depense');
		$this->db->where('datedepense >=', $realDateBegin);
		$this->db->where('datedepense <=', $realDateEnd);

		if(!is_null($type))
			$this->db->where('typedepense =', $type);

		$query = $this->db->get();
		return $query->result();
	}

    function getADayListeDepense($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select('*');
        $this->db->from('depense');
        $this->db->where('datedepense', $realDate);
        $query = $this->db->get();
        return $query->result();
    }

    function getADayDepense($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getADayDepense2($day, $type) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense', $realDate);

        $this->db->where('factureachat', $type);

        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getADayDepense22($day, $type) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select('*');
        $this->db->from('depense');
        $this->db->where('datedepense', $realDate);

        $this->db->where('factureachat', $type);

        $query = $this->db->get();
        return $query->result();
    }

    function getDepenseGauche($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense <=', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getDepenseByFactureAchat($idBonCommande) {
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('factureachat', $idBonCommande);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getDepenseDroite($day) {
        $realDate = date('Y-m-d', strtotime($day));
        $this->db->select_sum('montant');
        $this->db->from('depense');
        $this->db->where('datedepense >', $realDate);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->montant;
    }

    function getReglementsFactureAchatById() {
        $this->db->select('*');
        $this->db->from('depense');
        $this->db->where('factureachat = 1');
        $query = $this->db->get();
        return $query->result();
    }

	function getSituationBanque($begin, $end) {
		$realDateBegin = date('Y-m-d', $begin);
		$realDateEnd = date('Y-m-d', $end);
		$this->db->select('*');
		$this->db->from('depense');
		$this->db->where('factureachat = 2');
		$this->db->where('datedepense >=', $realDateBegin);
		$this->db->where('datedepense <=', $realDateEnd);
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
