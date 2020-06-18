<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('service_m');
        $this->load->model('client_m');
        $this->load->model('produit_m');
        $this->load->model('prix_m');
        $this->load->model('commercial_m');
        $this->load->model('proforma_m');
        $this->load->model('detailproforma_m');
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
				$periode = "Liste des Chantiers enregistrés le ".date('d/m/Y');
				$debut = date('Y/m/d');
				$fin = date('Y/m/d');
				$link = "today";
			}else{
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$periode = "Liste des Chantiers enregistrés du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
				$link = strtotime($debut)."_".strtotime($fin);
			}
		}else{
			$periode = "Liste des Chantiers enregistrés le ".date('d/m/Y');
			$debut = date('Y/m/d');
			$fin = date('Y/m/d');
			$link = "today";
		}

		$services = $this->service_m->getByPeriode($debut, $fin, 'dateenregistrement');

		$bigArray = array();
		foreach ($services as $key => $service) {
			$bigArray[$key] = $this->proforma_m->getArrayForService($service->idservice);
		}

		$data['link'] = $link;
		$data['services'] = $bigArray;
		$data['texte'] = $periode;
		$data['script'] = "filter1";
		$data['script2'] = "global";
		//echo"<pre>"; die(print_r($bigArray));
		$data['titre'] = $periode;
		$data['page'] = "service/index";
		$data['menu'] = 'edition';
		$this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $services = $this->service_m->get_all();
        $data['services'] = $services;

		$clients = $this->client_m->get_all();
		$data['clients'] = $clients;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter un Chantier';
        $data['page'] = "service/ajouter";
        $data['menu'] = 'gc';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('adresse', 'adresse', 'required');
        $this->form_validation->set_rules('datedebut', 'datedebut', 'required');
        $this->form_validation->set_rules('montant', 'montant', 'required');

        if($this->form_validation->run()){

            $datas = array(
                'typeservice' => $this->input->post('typeservice'),
                'adresse' => $this->input->post('adresse'),
                'delai' => $this->input->post('delai'),
                'datedebut' => $this->input->post('datedebut'),
                'dateenregistrement' => date("Y/m/d"),
                'detail' => $this->input->post('detail'),
                'client_id' => $this->input->post('client_id'),
                'montant' => $this->input->post('montant'),
                'token' => $this->input->post('token'),
            );

            if(!$this->service_m->exist($this->input->post('token'))) {
                $idService = $this->service_m->add_item($datas);
            }
        }
        redirect('service/proforma/'.$idService,'refresh');
    }

	public function proforma($id = null){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}


		$service = $this->service_m->get($id);
		if($service->adresse == ""){
			redirect("accueil/");
		}

		$data['service'] = $service;

		if(is_null($id)){
			redirect("accueil/");
		}else{
			$client = $this->client_m->get($service->client_id);
			if($client->nom == ""){
				redirect("accueil/");
			}
		}

		if(is_null($client)){
			redirect("accueil/");
		}

		$produits = $this->produit_m->get_all();

		$productArray = array();

		foreach ($produits as $produit) {
			$price = $this->prix_m->getPrice($produit->idproduit, $client->type_client);

			$productArray[$produit->idproduit]['Designation'] = $produit->designation;
			$productArray[$produit->idproduit]['IdProduit'] = $produit->idproduit;
			$productArray[$produit->idproduit]['Prix'] = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
		}

		$data['client'] = $client;
		$data['produits'] = $productArray;
		//echo'<pre>'; die(print_r($data));
		$data['titre'] = 'Proforma Chantier N° '.$id;
		$data['script'] = "proforma";
		$data['page'] = "service/quincaillerie";
		$data['menu'] = 'gc';
		$this->load->view($this->template, $data);
	}

	public function materiaux(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		//echo'<pre>'; die(print_r($_POST));

		$this->form_validation->set_rules('serviceId','serviceId','required');
		$this->form_validation->set_rules('token','token','required');

		if($this->form_validation->run()){

			if($_POST['remisefacture'] < 0){
				$remise = 0;
			}else{
				$remise = $_POST['remisefacture'];
			}

			$datas = array(
				'dateemission' => date('Y-m-d'),
				'service_id' => $this->input->post('serviceId'),
				'tva_id' => $this->input->post('tva'),
				'montant' => 0,
				'remisefacture' => $remise,
				'token' => $this->input->post('token'),
			);

			if(!$this->proforma_m->exist($this->input->post('token'))) {
				$proforma_id = $this->proforma_m->add_item($datas);

				$serviseSelected = $this->service_m->get($_POST['serviceId']);

				$client = $this->client_m->get($serviseSelected->client_id);

				$tva_id = $_POST['tva'];
				if($tva_id == ""){
					$pourcent = 0;
				}else{
					$pourcent = $tva_id;
				}

				$montant = 0;

				foreach($_POST['lib2'] as $cle => $lib2){
					$produit = $this->produit_m->get($lib2);

					$price = $this->prix_m->getPrice($produit->idproduit, $client->type_client);

					$price = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
					$montant += $price * $_POST['qte'][$cle];

					$dataR = array(
						'proforma_id' => $proforma_id,
						'produit_id' => $lib2,
						'qte' => $_POST['qte'][$cle],
						'pu' => $price,
						'remise' => $_POST['remise'][$cle],
					);
					$this->detailproforma_m->add_item($dataR);
				}

				$tva = ($montant * 0.18);

				$mttc = $tva + $montant;


				$montantPayer = $_POST['montP'];

				if(($montantPayer + $remise) > $mttc){
					$montantPayer = $mttc;
				}

				$vente = array(
					'montant' => $montant,
				);
				$this->proforma_m->update($proforma_id, $vente);
			}
		}
		redirect('service/index','refresh');
	}

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $fournisseur = $this->fournisseur_m->get($id);
        if($fournisseur->designation == ""){
            redirect("fournisseur/");
        }
        $fournisseurs = $this->fournisseur_m->get_all();
        $data['fournisseurs'] = $fournisseurs;

        $data['fournisseur'] = $fournisseur;

        $data['titre'] = 'Modifier le fournisseur '.$fournisseur->designation;
        $data['page'] = "fournisseur/modifier";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $item = $this->fournisseur_m->get($_POST['id']);
        if($item->designation == ""){
            redirect("fournisseur/");
        }

        $this->form_validation->set_rules('designation','Désignation du fournisseur','required');
        $this->form_validation->set_rules('contact','contact du fournisseur','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
                'designation' => $this->input->post('designation'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'situation' => $this->input->post('situation'),
                'etat' => $etat,

				'nomRep' => $this->input->post('nomRep'),
				'fonction' => $this->input->post('fonction'),
				'contactPersonnel' => $this->input->post('contactPersonnel'),
				'contactProfessionnel' => $this->input->post('contactProfessionnel'),
				'observation' => $this->input->post('observation'),

				'ncc' => $this->input->post('ncc'),
				'rccm' => $this->input->post('rccm'),
				'ncb' => $this->input->post('ncb'),
            );

            $this->fournisseur_m->update($item->idfournisseur, $datas);

        }
        redirect('fournisseur/index','refresh');
    }

    public function imprimer(){

        $message = "Liste des Fournisseurs";

        $fournisseurs = $this->fournisseur_m->get_all();
        $data['fournisseurs'] = $fournisseurs;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('fournisseur/print', $data, true);

		$mpdf->setFooter('{PAGENO} / {nb}');
		$mpdf->SetHTMLHeader('
            <page_header>
                <table style="border: none;">
                    <tr>
                        <td style="width: 20%;">
                        
                        </td>
                        <td style="width: 60%;  padding-left: 0px; border: none !important; text-align: center">
                            <img src="'.FCPATH.'/Uploads/logo.jpg" style="width: 100%;"  alt="">
                        </td>
                        <td style="width: 20%;">
                        
                        </td>
                   </tr>
                </table>
            </page_header>');
		$mpdf->AddPage('', // L - landscape, P - portrait
			'', '', '', '',
			15, // margin_left
			15, // margin right
			37, // margin top
			30, // margin bottom
			10, // margin header
			5); // margin footer
        $mpdf->WriteHTML($html);
        $mpdf->Output($message.'.pdf', 'I');
    }

    public function dettes(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$link = '';
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$periode = "Liste des Créances Fournisseur du ".date('d/m/Y');
				$debut = date('Y/m/d');
				$fin = date('Y/m/d');
				$link = 'today';
			}else{
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$periode = "Liste des Créances Fournisseur du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
				$link = strtotime($debut)."_".strtotime($fin);
			}
		}else{
			$periode = "Liste des Créances Fournisseur du ".date('d/m/Y');
			$debut = date('Y/m/d');
			$fin = date('Y/m/d');
			$link = 'today';
		}

		$supMessage = '';

		if(isset($_POST['fournisseur'])){
			if($_POST['fournisseur'] == 'all'){
				$fourn = null;
				$supMessage = 'Tous les Fournisseurs';
			} else{
				$fourn = $_POST['fournisseur'];
				$supMessage = $this->fournisseur_m->get($_POST['fournisseur'])->designation;
			}
		}else{
			$fourn = null;
			$supMessage = 'Tous les Fournisseurs';
		}

		$bons = $this->boncommande_m->getDataByPeriode2($debut, $fin, $fourn);

		foreach ($bons as $key => $bon) {
			$mtntRegler = $this->depense_m->getDepenseByFactureAchat($bon->idfacture);
			if($mtntRegler == '')
				$mtntRegler = 0;

			$details = $this->detailsbc_m->getArticles($bon->idfacture);

			$mtntFacture = 0;
			foreach ($details as $detail) {
				$mtntFacture += ($detail->pu * $detail->qte);
			}

			$bons[$key]->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;
			$bons[$key]->Fournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;
			$bons[$key]->montantCommande = $mtntFacture;
			$bons[$key]->montantRegler = $mtntRegler;
		}

		//echo'<pre>'; die(print_r($bon));

		$fournisseurs = $this->fournisseur_m->get_all();

		$data['fournisseurs'] = $fournisseurs;

		$data['selectedFournisseur'] = $fourn;
		$data['supMessage'] = $supMessage;

		$data['bons'] = $bons;

		$data['link'] = $link;

		$data['script'] = 'filter1';
		$data['titre'] = $periode;
		$data['page'] = "fournisseur/dettes";
		$data['menu'] = 'comptabilite';
		$this->load->view($this->template, $data);
	}
}
