<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Depense extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('depense_m');
        $this->load->model('fournisseur_m');
        $this->load->model('boncommande_m');
        $this->load->model('detailsbc_m');
        $this->load->model('entrepot_m');
        $this->load->model('paiement_m');
        $this->load->model('typedepense_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

		$link = '';
        if(isset($_POST['periode'])){
            if($_POST['periode'] == 'today'){
				$debut = date('Y-m-d');
				$fin = date('Y-m-d');
                $periode = "Dépenses du ".date('d/m/Y');
				$link = 'today';
            }else{
                $debut = $_POST['debut'];
                $fin = $_POST['fin'];
                $periode = "Dépenses du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
				$link = strtotime($debut).'_'.strtotime($fin);
            }
        }else{
			$debut = date('Y-m-d');
			$fin = date('Y-m-d');
            $periode = "Dépenses du ".date('d/m/Y');
			$link = 'today';
        }

		if(isset($_POST['typeDepense'])){
			if($_POST['typeDepense'] == 'all'){
				$type = null;
				$dep = 'Toute les Dépenses';
			} else {
				$type = $_POST['typeDepense'];

				switch ($type) {
					case 'fa':
						$dep = "Facture d'achat";
						break;

					case 'banque':
						$dep = 'Versement Banque';
					break;

					case 'exp':
						$dep = "Dépenses d'exploitation";
					break;

					default:
						$dep = "Totes les Dépenses";
						break;
				}
			}
		}else{
			$type = null;
			$dep = 'Toute les Dépenses';
		}

		$depenses = $this->depense_m->getAPeriodeListeDepenseByType($debut, $fin, $type);




		foreach ($depenses as $key => $depens) {
			$depenses[$key]->token = '-';

			if($depens->typedepense == 'fa'){
				$facture = $this->boncommande_m->get($depens->factureachat);
				$fournisseur = $this->fournisseur_m->get($facture->idfournisseur);

				$depenses[$key]->token = $fournisseur->designation;
			}
		}
		//echo"<pre>"; die(print_r($depenses));
		$data['depenses'] = $depenses;

		$data['link'] = $link;
		$data['dep'] = $dep;

		$data['selectedType'] = isset($_POST['typeDepense']) ? $_POST['typeDepense'] : 'all';

        $data['titre'] = $periode;
        $data['script'] = "filter1";
        $data['page'] = "depense/liste";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $depenses = $this->depense_m->get_all();
        $data['depenses'] = $depenses;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter une Depense';
        $data['page'] = "depense/ajouter";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('motifdepense','Motif de la dépense','required');
        $this->form_validation->set_rules('montant','Montant de la dépense','required');

        //echo'<pre>'; die(print_r($reclamation));

        if($this->form_validation->run()){

            $datas = array(
                'motifdepense' => $this->input->post('motifdepense'),
                'datedepense' => date('Y-m-d'),
                'iduser' => $this->session->userdata('user_id'),
                'montant' => $this->input->post('montant'),
                'token' => $this->input->post('token'),
                'typedepense' => $_POST['typedepense'],
                'factureachat' => null,
				'arretcaisse_id' => $_SESSION['IdAC'],
            );

            if(!$this->depense_m->exist($this->input->post('token'))) {
                $this->depense_m->add_item($datas);
            }
        }
        redirect('depense/ajouter','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $depense = $this->depense_m->get($id);
        if($depense->motifdepense == ""){
            redirect("compte/");
        }
        $depenses = $this->depense_m->get_all();
        $data['depenses'] = $depenses;

        $data['depense'] = $depense;

        $data['titre'] = 'Modifier une depense';
        $data['page'] = "depense/modifier";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $item = $this->depense_m->get($_POST['id']);
        if($item->motifdepense == ""){
            redirect("depense/");
        }

        $this->form_validation->set_rules('motifdepense','Motif de la dépense','required');
        $this->form_validation->set_rules('montant','Montant de la dépense','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $datas = array(
                'motifdepense' => $this->input->post('motifdepense'),
                'iduser' => $this->session->userdata('user_id'),
                'montant' => $this->input->post('montant'),
            );

            $this->depense_m->update($item->iddepense, $datas);

        }
        redirect('depense/index','refresh');
    }

	public function reglerfournisseur($idFacture){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$bon = $this->boncommande_m->get($idFacture);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$bon->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

		$details = $this->detailsbc_m->getArticles($bon->idfacture);

		$totalPaiement = $this->depense_m->getDepenseByFactureAchat($idFacture);


		$magasins = $this->entrepot_m->get_all();

		$data['details'] = $details;
		$data['oldPaiement'] = $totalPaiement;
		$data['bon'] = $bon;
		$data['magasins'] = $magasins;

		//echo'<pre>'; die(print_r($totalPaiement));

		$data['titre'] = "Régler Dette Fournisseur";
		$data['page'] = "depense/reglerFournisseur";
		$data['menu'] = 'caisse';
		$data['script'] = 'receptionner';
		$this->load->view($this->template, $data);
	}

	public function validerPaiementFournisseur(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$this->form_validation->set_rules('idFacture','Id Facture','required');

		$bon = $this->boncommande_m->get($_POST['idFacture']);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$details = $this->detailsbc_m->getArticles($bon->idfacture);

		$totalFacture = 0;

		foreach ($details as $detail) {
			$totalFacture += ($detail->qte * $detail->pu);
		}

		$totalPaiement = $this->depense_m->getDepenseByFactureAchat($bon->idfacture);

		$cumulPaiementInclusif = $totalPaiement + $_POST['montantPayer'];

		if($cumulPaiementInclusif > $totalFacture){
			//Il a payer plus

			$difference = $cumulPaiementInclusif - $totalFacture;
			$montantPayer = $_POST['montantPayer'] - $difference;
		}else{
			// Paiement accepter

			$montantPayer = $_POST['montantPayer'];
		}

		$datas = array(
			'motifdepense' => 'Règlement Fournisseur',
			'datedepense' => date('Y-m-d'),
			'iduser' => $this->session->userdata('user_id'),
			'montant' => $montantPayer,
			'token' => $this->input->post('token'),
			'typedepense' => 'fa',
			'factureachat' => $bon->idfacture,
			'fournisseur_id' => $bon->idfournisseur,
			'arretcaisse_id' => $_SESSION['IdAC'],
		);

		if(!$this->depense_m->exist($this->input->post('token'))) {
			$this->depense_m->add_item($datas);
		}

		redirect('depense/index','refresh');
	}


}
