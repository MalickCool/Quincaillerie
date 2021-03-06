<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 12/07/2019
 * Time: 15:32
 */
if (! defined('BASEPATH')) exit("no direct script access allowed");
class detailsbl_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_db_table(){
        return 'detailbl';
    }

    public function get_db_table_id(){
        return 'iddetail';
    }

    function add_item($post_data) {
        $this->db->insert('detailbl',$post_data);
        return $this->db->insert_id();
    }


	function getDetails($idBon) {
		$this->db->select('*');
		$this->db->from('detailbl');
		$this->db->where('idbon', $idBon);
		$query = $this->db->get();
		return $query->result();
	}

    function getArticles($id) {
        $this->db->select('d.iddetail, d.qte, d.pu, p.designation AS produit');
        $this->db->from('detailbl d, produits p');
        $this->db->where('d.idproduit = p.idproduit');
        $this->db->where('idbon', $id);
        $query = $this->db->get();
        return $query->result();
    }



































    function getAchatsByPeriode($date) {
        $this->db->select('detailfacture.*');
        $this->db->from('detailfacture, factureachat');
        $this->db->where('detailfacture.idfactureachat = factureachat.idfacture');
        $this->db->where('datefacture >', date('Y-m-d', strtotime($date)));
        $query = $this->db->get();
        return $query->result();
    }

	function getAchatsByDay($date) {
		$this->db->select('detailfacture.*, intrant.designation AS intrant, fournisseur.designation');
		$this->db->from('detailfacture, factureachat, intrant, fournisseur');
		$this->db->where('detailfacture.idfactureachat = factureachat.idfacture');
		$this->db->where('detailfacture.idproduit = intrant.idintrant');
		$this->db->where('factureachat.idfournisseur = fournisseur.idfournisseur');
		$this->db->where('datefacture =', $date);
		$query = $this->db->get();
		return $query->result();
	}



	function getAchatsByIntrant($idIntrant, $date) {
		$this->db->select_sum('qte');
		$this->db->from('detailfacture, factureachat');
		$this->db->where('detailfacture.idfactureachat = factureachat.idfacture');
		$this->db->where('datefacture', $date);
		$this->db->where('idproduit', $idIntrant);
		$query = $this->db->get();
		$result = $query->result();
		if(!empty($result))
			return $result[0]->qte;
		else
			return 0;
	}

	function getAchatsByIntrantPrev($idIntrant, $today, $date) {
		$this->db->select_sum('qte');
		$this->db->from('detailfacture, factureachat');
		$this->db->where('detailfacture.idfactureachat = factureachat.idfacture');
		$this->db->where('datefacture <=', $today);
		$this->db->where('datefacture >=', $date);
		$this->db->where('idproduit', $idIntrant);
		$query = $this->db->get();
		$result = $query->result();
		if(!empty($result))
			return $result[0]->qte;
		else
			return 0;
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
