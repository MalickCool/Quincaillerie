<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actioncaisse extends CI_Controller {

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('actioncaisse_m');
		$this->load->model('paiement_m');
		$this->load->model('versement_m');
		$this->load->model('depense_m');
		$this->load->model('argent_m');
		$this->load->model('billetage_m');
	}

	public $template = 'templates/template';

	public function ouverture(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_SESSION['caisse'])){
			$caisse = $_SESSION['caisse'];
		}else{
			redirect("auth/login");
		}

		if(isset($_SESSION['IdAC'])){
			redirect("accueil/index");
		}

		$data['caisse'] = $caisse;
		$data['utilisateur'] = $this->session->userdata('username');
		$data['titre'] = 'Ouverture de Caisse';
		$data['page'] = "actioncaisse/ouvrir";
		$data['menu'] = 'caisse';
		$data['script'] = 'actioncaisse';
		$this->load->view($this->template, $data);
	}

	public function reouverture(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_SESSION['caisse'])){
			$caisse = $_SESSION['caisse'];
		}else{
			redirect("auth/login");
		}

		if(!isset($_SESSION['arretCaisse'])){
			redirect("auth/login");
		}

		if(isset($_SESSION['IdAC'])){
			redirect("accueil/index");
		}

		$data['caisse'] = $caisse;
		$data['utilisateur'] = $this->session->userdata('username');
		$data['titre'] = 'Ouverture de Caisse';
		$data['page'] = "actioncaisse/reouvrir";
		$data['menu'] = 'caisse';
		$data['script'] = 'actioncaisse';
		$this->load->view($this->template, $data);
	}

	public function arret(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_SESSION['caisse'])){
			$caisse = $_SESSION['caisse'];
		}else{
			redirect("auth/login");
		}

		if(!isset($_SESSION['arretCaisse'])){
			redirect("auth/login");
		}

		if(!isset($_SESSION['IdAC'])){
			redirect("auth/login");
		}

		$theDate = date('Y-m-d');
		$vente = self::getADayVente($theDate);

		if(!is_numeric($vente))
			$vente = 0;

		$versement = self::getADayVersement($theDate);
		if(!is_numeric($versement))
			$versement = 0;

		$depenseAchat = self::getADayDepenseAchat($theDate);
		if(!is_numeric($depenseAchat))
			$depenseAchat = 0;


		$depenseBanque = self::getADayDepenseBanque($theDate);
		if(!is_numeric($depenseBanque))
			$depenseBanque = 0;


		$depenseExploitation = self::getADayDepenseExploitation($theDate);
		if(!is_numeric($depenseExploitation))
			$depenseExploitation = 0;




		$data['Entree']['Vente'] = $vente;
		$data['Entree']['Versement'] = $versement;

		$data['Entree']['Total'] = $vente + $versement;

		$data['Sortie']['ReglementFournisseur'] = $depenseAchat;
		$data['Sortie']['VersementBanque'] = $depenseBanque;
		$data['Sortie']['DepenseExploitation'] = $depenseExploitation;

		$data['Sortie']['Total'] = $depenseExploitation + $depenseBanque + $depenseAchat;




		//echo"<pre>"; die(print_r($data));

		$data['caisse'] = $caisse;
		$data['utilisateur'] = $this->session->userdata('username');
		$data['titre'] = 'Arrêt de Caisse';
		$data['page'] = "actioncaisse/arret";
		$data['menu'] = 'caisse';
		$data['script'] = 'actioncaisse';
		$this->load->view($this->template, $data);
	}

	public function billetage(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_SESSION['caisse'])){
			$caisse = $_SESSION['caisse'];
		}else{
			redirect("auth/login");
		}

		if(!isset($_SESSION['arretCaisse'])){
			redirect("auth/login");
		}

		if(!isset($_SESSION['IdAC'])){
			redirect("auth/login");
		}

		$theDate = date('Y-m-d');
		$vente = self::getADayVente($theDate);

		if(!is_numeric($vente))
			$vente = 0;

		$versement = self::getADayVersement($theDate);
		if(!is_numeric($versement))
			$versement = 0;

		$depenseAchat = self::getADayDepenseAchat($theDate);
		if(!is_numeric($depenseAchat))
			$depenseAchat = 0;


		$depenseBanque = self::getADayDepenseBanque($theDate);
		if(!is_numeric($depenseBanque))
			$depenseBanque = 0;


		$depenseExploitation = self::getADayDepenseExploitation($theDate);
		if(!is_numeric($depenseExploitation))
			$depenseExploitation = 0;




		$data['Entree']['Vente'] = $vente;
		$data['Entree']['Versement'] = $versement;

		$data['Entree']['Total'] = $vente + $versement;

		$data['Sortie']['ReglementFournisseur'] = $depenseAchat;
		$data['Sortie']['VersementBanque'] = $depenseBanque;
		$data['Sortie']['DepenseExploitation'] = $depenseExploitation;

		$data['Sortie']['Total'] = $depenseExploitation + $depenseBanque + $depenseAchat;


		$billets = array_reverse($this->argent_m->getByType('Billet'));
		$pieces = array_reverse($this->argent_m->getByType('Pièce'));

		$data['Argents']['Billets'] = $billets;
		$data['Argents']['Pièces'] = $pieces;

		//echo"<pre>"; die(print_r($data));

		$data['caisse'] = $caisse;
		$data['utilisateur'] = $this->session->userdata('username');
		$data['titre'] = 'Billetage';
		$data['page'] = "actioncaisse/billetage";
		$data['menu'] = 'caisse';
		$data['script'] = 'actioncaisse';
		$this->load->view($this->template, $data);
	}

	public function getFinance(){
		$theDate = date('Y-m-d');
		$vente = self::getADayVente($theDate);

		if(!is_numeric($vente))
			$vente = 0;

		$versement = self::getADayVersement($theDate);
		if(!is_numeric($versement))
			$versement = 0;

		$depenseAchat = self::getADayDepenseAchat($theDate);
		if(!is_numeric($depenseAchat))
			$depenseAchat = 0;


		$depenseBanque = self::getADayDepenseBanque($theDate);
		if(!is_numeric($depenseBanque))
			$depenseBanque = 0;


		$depenseExploitation = self::getADayDepenseExploitation($theDate);
		if(!is_numeric($depenseExploitation))
			$depenseExploitation = 0;




		$data['Entree']['Vente'] = $vente;
		$data['Entree']['Versement'] = $versement;

		$data['Entree']['Total'] = $vente + $versement;

		$data['Sortie']['ReglementFournisseur'] = $depenseAchat;
		$data['Sortie']['VersementBanque'] = $depenseBanque;
		$data['Sortie']['DepenseExploitation'] = $depenseExploitation;

		$data['Sortie']['Total'] = $depenseExploitation + $depenseBanque + $depenseAchat;

		return $data;
	}

	public function confirmBilletage(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$finance = self::getFinance();

		$mySolde = $finance['Entree']['Total'] - $finance['Sortie']['Total'];

		//echo"<pre>"; die(print_r($_POST));

		$idAC = $_SESSION['IdAC'];

		$datas = array(
			'date_fermeture' => date("Y/m/d"),
			'heure_fermeture' => date("H:i:s"),
			'etat' => 1,
			'commentaire' => $_POST['remarque'],
			'solde_theorique' => $mySolde,
		);
		$this->actioncaisse_m->update($idAC, $datas);

		$coupures = $this->argent_m->get_all();

		foreach ($coupures as $coupure) {
			if (isset($_POST[$coupure->id_argent . '_Coupure']) AND $_POST[$coupure->id_argent . '_Coupure'] > 0) {
				$datas = array(
					'quantite' => $_POST[$coupure->id_argent . '_Coupure'],
					'date_billetage' => date("Y/m/d"),
					'ac_id' =>  $_SESSION['IdAC'],
					'argent_id' => $coupure->id_argent,
				);
				$this->billetage_m->add_item($datas);
			}
		}

		$_SESSION['statusCaisse'] = "close";

		unset($_SESSION['IdAC']);

		redirect("accueil/");
	}











	public function getADayVente($day){
		$paiements = $this->paiement_m->getByPeriode($day, $day, 'datepaiement');
		$somme = $this->paiement_m->sum($paiements, 'montant');
		return $somme;
	}

	public function getADayVersement($day){
		$somme = $this->versement_m->getADayVersement($day);
		return $somme;
	}

	public function getADayDepense($day){
		$somme = $this->depense_m->getADayDepense($day);
		return $somme;
	}

	public function getADayDepenseAchat($day){
		$somme = $this->depense_m->getADayDepense2($day, 'fa');
		return $somme;
	}

	public function getADayDepenseBanque($day){
		$somme = $this->depense_m->getADayDepenseBanque($day, 'banque');
		return $somme;
	}

	public function getADayDepenseIntervention($day){
		$somme = $this->depense_m->getADayDepense22($day, 3);
		return $somme;
	}

	public function getADayDepenseExploitation($day){
		$somme = $this->depense_m->getADayDepenseExploitation($day, 'exp');
		return $somme;
	}
}
