<?php

    /**
     * Created by PhpStorm.
     * User: GLORIA TECHNOLOGY
     * Date: 29/01/2019
     * Time: 09:14
     */


class MY_Model extends CI_Model 
{

	public function getUser(){
		$this->db->select('*');
		$this->db->from("contacts");
		$this->db->where('opened', 0);
		$query = $this->db->get();
		$message = $query->result();

		$this->db->select('*');
		$this->db->from("inscriptions");
		$this->db->join('services', 'inscriptions.services_IdService = services.IdService');
		$this->db->where('opened', 0);
		$query = $this->db->get();
		$inscription = $query->result();

		$notification['message'] = $message;
		$notification['inscription'] = $inscription;
		//echo"<pre>"; die(print_r($notification));
		return $notification;
	}

    function truncate($text, $chars = 120) {
        if(strlen($text) > $chars) {
            $text = $text.' ';
            $text = substr($text, 0, $chars);
            $text = substr($text, 0, strrpos($text ,' '));
            $text = $text.'...';
        }
        return $text;
    }

 //methode d'insertion des données d'une ligne de la table
  public function insert($data)
  {
    $this->db->insert($this->get_db_table(), $data);
  }

    /*
       * Insert file data into the database
       * @param array the data for inserting into the table
       */
    public function insertEnMasse($data = array()){
        $insert = $this->db->insert_batch($this->get_db_table(),$data);
        return $insert?true:false;
    }

  //methode d'insertion des données de plusieurs lignes de la table
  public function insert_batch($data)
  {
    $this->db->insert_batch($this->get_db_table(), $data);
  }
  //methode d'affichage de toutes les lignes de la table
  public function get_all()
  {
    $this->db->select('*');
    $this->db->from($this->get_db_table());
    $this->db->order_by($this->get_db_table_id(),'ASC');
    $query = $this->db->get();
    return $query->result();
  }

  public function getCompanyInfos()
  {
    $this->db->select('*');
    $this->db->from('company');
    $query = $this->db->get();
    return $query->result();
  }


 //METHODE RENVOYANT UNE LIGNE DE LA TABLE CORRESPONDANT A L'ID
 public function get($id)
  {
    $query = $this->db->get_where($this->get_db_table(), array($this->get_db_table_id() => $id));
    return $query->row();
  }

   //METHODE RENVOYANT PLUSIEURS LIGNES DE LA TABLE CORRESPONDANT A L'ID
   public function get_result($id)
    {
      $query = $this->db->get_where($this->get_db_table(), array($this->get_db_table_id() => $id));
      return $query->result();
    }


 //methode de modifiation d'une ligne de table en fonction correspondant a l'id
   public function update($id, $data)
  {   
    $this->db->where($this->get_db_table_id(), $id);
    $this->db->update($this->get_db_table(), $data);
  }

 //methode de suppression d'une ligne de la base de donnée en fonction de son id
   public function delete($id)
  {
    $this->db->where($this->get_db_table_id(), $id);
    $this->db->delete($this->get_db_table());
  }
 //mathode de jointure entre deux  tables
  public function jointure($table1, $table2, $id)
  {

  	$this->db->select('*');
  	$this->db->from($this->table1);
  	$this->db->join($this->table2, $this->table1.$this->id =$this->table2.$this->id);
  	$query = $this->db->get();
  }

  // methode pour formatter les 
    public function formatNumber($number){
        if(is_numeric($number))
            return number_format($number, 0, ',', ' ');
        else
            return $number;
    }


	function getByPeriode($begin, $end, $field, $orderBy = null) {
		$realDateBegin = date('Y-m-d', strtotime($begin));
		$realDateEnd = date('Y-m-d', strtotime($end));
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where($field.' >=', $realDateBegin);
		$this->db->where($field.' <=', $realDateEnd);
		if(is_null($orderBy))
			$this->db->order_by($field,'DESC');
		else
			$this->db->order_by($orderBy,'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function getArray($id){

		$vente = $this->vente_m->get($id);

		$clients = $this->client_m->get($vente->client_id);
		$commercial = $this->commercial_m->get($vente->commercial_id);

		if($vente->tva_id > 0){
			//$tvas = $this->taxe_m->get($vente->tva_id);
			$tva = 18;
		}else{
			$tva = 0;
		}

		$concerners = $this->detailvente_m->getByForeignKey($vente->idvente);

		$productArray = array();
		$i = 0;
		$liv = array();

		$totalRemise = 0;

		foreach ($concerners as $concerner) {
			$produit = $this->produit_m->get($concerner->produit_id);
			$productArray[$i]['Produit'] = $produit->designation;
			$productArray[$i]['IdProduit'] = $produit->idproduit;
			$productArray[$i]['Qte'] = $concerner->qte;
			$productArray[$i]['Pu'] = $concerner->pu;
			$productArray[$i]['Remise'] = $concerner->remise;
			$productArray[$i]['Etat'] = $concerner->etat;
			$productArray[$i]['IdDetail'] = $concerner->iddetailvente;

			$totalRemise += ($concerner->qte * ($concerner->remise));

			$i++;
		}

		$paiements = $this->paiement_m->getByForeignKey($vente->idvente);

		$sommeVersee = $this->paiement_m->sum($paiements, 'montant');

		$returnArray['Vente'] = $vente;

		$returnArray['Client'] = $clients;
		$returnArray['Commercial'] = $commercial;

		$returnArray['Tva'] = $tva;

		$returnArray['MontTVA'] = $vente->montant * $tva / 100;
		$returnArray['MontHT'] = $vente->montant;

		$totalRemise += $vente->remisefacture;

		$returnArray['TotalRemise'] = $totalRemise;

		$returnArray['MontTTC'] = $vente->montant  + ($vente->montant * $tva / 100);
		$returnArray['TotalTTC'] = $vente->montant + ($vente->montant * $tva / 100) - $totalRemise;
		$returnArray['Produits'] = $productArray;
		$returnArray['Paiements'] = $paiements;
		$returnArray['MontantVerse'] = $sommeVersee;
		$returnArray['Reste'] = $returnArray['TotalTTC'] - $sommeVersee;


		//echo'<pre>'; die(print_r($returnArray));

		return $returnArray;
	}

	function getByForeignKey($idForeignKey) {
		$this->db->select('*');
		$this->db->from($this->get_db_table());
		$this->db->where($this->get_db_table_foreign(), $idForeignKey);
		$query = $this->db->get();
		return $query->result();
	}

	function sum($array, $field){
		$sum = 0;
		foreach ($array as $item) {
			$sum += $item->$field;
		}
		return $sum;
	}



}
