<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Commande extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('boncommande_m');
        $this->load->model('fournisseur_m');
        $this->load->model('famille_m');
        $this->load->model('produit_m');
        $this->load->model('detailsbc_m');
		$this->load->model('entrepot_m');
		$this->load->model('stock_m');
        $this->load->model('depense_m');
        $this->load->model('bonlivraison_m');
        $this->load->model('detailsbl_m');
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
				$periode = "Bon de Commande du ".date('d/m/Y');
				$link = 'today';
			}else{
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$periode = "Bon de Commande du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
				$link = strtotime($debut).'_'.strtotime($fin);
			}
		}else{
			$debut = date('Y-m-d');
			$fin = date('Y-m-d');
			$periode = "Bon de Commande du ".date('d/m/Y');
			$link = 'today';
		}

		$bons = $this->boncommande_m->getDataByPeriode($debut, $fin);

		foreach ($bons as $key => $bon) {
			$solde = 0;
			$poids = 0;
			$bons[$key]->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;
			$details = $this->detailsbc_m->getDetails($bon->idfacture);
			foreach ($details as $detail) {
				$solde += ($detail->qte * $detail->pu);

				$theProduct = $this->produit_m->get($detail->idproduit);

				$poids += ($detail->qte * $theProduct->masse);

				//echo'<pre>'; die(print_r($theProduct));
			}
			//echo'<pre>'; die(print_r($details));

			$bons[$key]->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;
			$bons[$key]->PoidsTotal = $poids;

			if($bon->etat == 0){
				$bons[$key]->State = 'Non Réceptionné';
			}else{
				$bons[$key]->State = 'Réceptionné';
			}

			if($bon->tva == 'non'){
				$bons[$key]->soldeTTC = $solde;
				$bons[$key]->soldeHT = $solde;
			}else{
				$bons[$key]->soldeTTC = $solde;
				$bons[$key]->soldeHT = round($solde / 1.18, 0);
			}

			$bons[$key]->soldeTaxe = $bons[$key]->soldeTTC - $bons[$key]->soldeHT;

		}

		//echo'<pre>'; die(print_r($bons));


        $data['bons'] = $bons;
        $data['link'] = $link;
        $data['script'] = 'filter1';

        $data['titre'] = 'Liste des Bons de Commande';
        $data['page'] = "boncommande/liste";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function ajouter()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $achats = $this->boncommande_m->get_all();

        $fournisseurs = $this->fournisseur_m->get_all();

        $produits = $this->produit_m->getActivated();

		$stocks = array();

		$total = 0;

		foreach ($produits as $produit) {
			$qte = $this->stock_m->getProductStock($produit->idproduit);
			if(!is_numeric($qte))
				$qte = 0;

			if($qte > 0 AND $qte < $produit->seuil){
				$stocks[$produit->idproduit]['idProduit'] = $produit->idproduit;
				$stocks[$produit->idproduit]['designation'] = $produit->designation;
				$stocks[$produit->idproduit]['prix'] = $produit->montant;
				$stocks[$produit->idproduit]['seuil'] = $produit->seuil;
				$stocks[$produit->idproduit]['Qte'] = $qte;

				$total += ($produit->seuil - $qte) * $produit->montant;

			}
		}

		//echo'<pre>'; die(print_r($total));

        $data['totalFacture'] = $total;

        $data['stocks'] = $stocks;
        $data['achats'] = $achats;
        $data['fournisseurs'] = $fournisseurs;
        $data['produits'] = $produits;

        $data['titre'] = 'Nouveau Bon de Commade';
        $data['script'] = 'achat';
        $data['page'] = "boncommande/ajouter";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function validerAchat(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

		//echo'<pre>'; die(print_r($_POST));

        $this->form_validation->set_rules('idfournisseur','Id du fournisseur','required');

        if($this->form_validation->run()){

            $datas = array(
                'numbon' => $this->input->post('numbon'),
                'idfournisseur' => $this->input->post('idfournisseur'),
                'datebon' => date('Y-m-d'),
                'iduser' => $this->session->userdata('user_id'),
                'tva' => $this->input->post('tva'),
                'token' => $this->input->post('token'),
            );

            $montantTotal = 0;

            if(!$this->boncommande_m->exist($this->input->post('token'))) {
                $lastId = $this->boncommande_m->add_item($datas);

                $nbreProduit = sizeof($_POST['product']);
                for ($i=0; $i < $nbreProduit; $i++) {
                    $datax = array(
                        'idproduit' => $_POST['product'][$i],
                        'qte' => $_POST['qte'][$i],
                        'pu' => $_POST['pu'][$i],
                        'idbon' => $lastId,
                    );
                    $this->detailsbc_m->add_item($datax);
                }
            }
        }

        redirect('stock/ajouter','refresh');
    }

    public function updateBonCommande(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $bon = $this->boncommande_m->get($_POST['idBon']);

		if($bon->token == ""){
			redirect("commande/index");
		}

		//echo'<pre>'; die(print_r($bon));

        $this->form_validation->set_rules('idfournisseur','Id du fournisseur','required');

        if($this->form_validation->run()){

            $datas = array(
                'idfournisseur' => $this->input->post('idfournisseur'),
                'iduser' => $this->session->userdata('user_id'),
            );

			$this->boncommande_m->update($bon->idfacture, $datas);

            $montantTotal = 0;

			$this->detailsbc_m->deleteAll($bon->idfacture);

			$nbreProduit = sizeof($_POST['product']);
			for ($i=0; $i < $nbreProduit; $i++) {
				$datax = array(
					'idproduit' => $_POST['product'][$i],
					'qte' => $_POST['qte'][$i],
					'pu' => $_POST['pu'][$i],
					'idbon' => $bon->idfacture,
				);
				$this->detailsbc_m->add_item($datax);
			}

        }

        redirect('commande/index','refresh');
    }

    public function detail($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $bon = $this->boncommande_m->get($id);

        if($bon->token == ''){
            redirect("accueil/");
        }

		$bon->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

        $details = $this->detailsbc_m->getArticles($bon->idfacture);

        //echo'<pre>'; die(print_r($details));

        //$data['fournisseur'] = $fournisseur;
        $data['details'] = $details;
        $data['bon'] = $bon;

        $data['titre'] = "Bon de Commande N° ".'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;
        $data['page'] = "boncommande/afficher";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function modifier($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $bon = $this->boncommande_m->get($id);

        if($bon->token == ''){
            redirect("accueil/");
        }

		$bon->idfournisseur = $bon->idfournisseur;

		$bon->fournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

        $details = $this->detailsbc_m->getArticles($bon->idfacture);

		$total = 0;
		$intrantOnly = array();
		foreach ($details as $detail) {
			$total += ($detail->qte * $detail->pu);
			$intrantOnly[] = $detail->idproduit;
        }

		$achats = $this->boncommande_m->get_all();

		$fournisseurs = $this->fournisseur_m->get_all();

		if(!empty($intrantOnly)){
			$produits = $this->produit_m->getNotSelectedYet($intrantOnly);
		}else{
			$produits = $this->produit_m->getActivated();
		}


		$data['total'] = $total;
		$data['achats'] = $achats;
		$data['fournisseurs'] = $fournisseurs;


		$data['produits'] = $produits;

        //echo'<pre>'; die(print_r($details));

        $data['details'] = $details;
        $data['bon'] = $bon;

        $data['titre'] = "Modifier Bon de Commande N° ".'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;
        $data['page'] = "boncommande/modifier";
		$data['script'] = 'achat';
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function annuler($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $bon = $this->boncommande_m->get($id);

        if($bon->token == ''){
            redirect("accueil/");
        }

		$bon->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

        $details = $this->detailsbc_m->getArticles($bon->idfacture);

        //echo'<pre>'; die(print_r($bon));

        //$data['fournisseur'] = $fournisseur;
        $data['details'] = $details;
        $data['bon'] = $bon;

        $data['titre'] = "Annuler Bon de Commande N° ".'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;
        $data['page'] = "boncommande/annuler";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

	public function receptionner($id){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$bon = $this->boncommande_m->get($id);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$bon->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

		$details = $this->detailsbc_m->getArticles($bon->idfacture);

		$magasins = $this->entrepot_m->get_all();

		$data['details'] = $details;
		$data['bon'] = $bon;
		$data['magasins'] = $magasins;

		//echo'<pre>'; die(print_r($data));

		$data['titre'] = "Réceptionner Marchandise";
		$data['page'] = "boncommande/receptionner";
		$data['menu'] = 'stock';
		$data['script'] = 'receptionner';
		$this->load->view($this->template, $data);
	}

	public function validerReception($idbon){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		//echo'<pre>'; die(print_r($_POST));

		$magasins = $this->entrepot_m->get_all();

		$bon = $this->boncommande_m->get($idbon);

		$details = $this->detailsbc_m->getDetails($bon->idfacture);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$datas = array(
			'numbon' => $this->input->post('numbon'),
			'datebon' => date('Y-m-d'),
			'iduser' => $this->session->userdata('user_id'),
			'idbc' => $bon->idfacture,
			'token' => $this->input->post('token'),
		);

		$idBl = $this->bonlivraison_m->add_item($datas);

		$total = 0;

		foreach ($details as $detail) {

			//echo'<pre>'; die(print_r($_POST));

			if(isset($_POST['qte_'.$detail->iddetail])){

				$datax = array(
					'idproduit' => $detail->idproduit,
					'qte' => $_POST['qte_'.$detail->iddetail],
					'pu' => $detail->pu,
					'idbon' => $idBl,
				);
				$this->detailsbl_m->add_item($datax);


				foreach ($magasins as $magasin) {

					if(isset($_POST['entrepot_'.$detail->iddetail.'_'.$magasin->identrepot]) AND $_POST['entrepot_'.$detail->iddetail.'_'.$magasin->identrepot] > 0){

						$total += ($_POST['entrepot_'.$detail->iddetail.'_'.$magasin->identrepot] * $detail->pu);

						$dataz = array(
							'idproduit' => $detail->idproduit,
							'qte' => $_POST['entrepot_'.$detail->iddetail.'_'.$magasin->identrepot],
							'prixachat' => $detail->pu,
							'identrepot' => $magasin->identrepot,
							'dateachat' => $bon->datebon,
							'idbl' => $idBl,
						);
						$this->stock_m->add_item($dataz);
					}

				}



			}

			//echo'<pre>'; die(print_r($detail));
		}

		$datax = array(
			'etat' => 1,
		);
		$this->boncommande_m->update($bon->idfacture, $datax);

		//echo'<pre>'; die(print_r($_POST));

		// montantPayer

		$datas = array(
			'motifdepense' => 'Règlement Fournisseur',
			'datedepense' => date('Y-m-d'),
			'iduser' => $this->session->userdata('user_id'),
			'montant' => $this->input->post('montantPayer'),
			'token' => $this->input->post('token'),
			'typedepense' => 'fa',
			'factureachat' => $bon->idfacture,
			'fournisseur_id' => $bon->idfournisseur,
		);

		if(!$this->depense_m->exist($this->input->post('token'))) {
			$this->depense_m->add_item($datas);
		}

		if($total > $_POST['montantPayer']){
			$dataEcheance = array(
				'echeance' => $this->input->post('echeance'),
			);
			$this->boncommande_m->update($bon->idfacture, $dataEcheance);
		}

		redirect('depense/index','refresh');
	}

	public function disableBon(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		//echo'<pre>'; die(print_r($_POST));

		$idbon = $_POST['id'];

		$bon = $this->boncommande_m->get($idbon);

		$details = $this->detailsbc_m->getDetails($bon->idfacture);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$datas = array(
			'annulee' => 1,
			'motifAnnulation' => $this->input->post('motif'),
			'dateAnnulation' => date('Y/m/d'),
			'idUserAnnulation' => $this->session->userdata('user_id'),

		);
		$this->boncommande_m->update($bon->idfacture, $datas);

		redirect('commande/index','refresh');
	}

	public function show($id){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$factureAchat = $this->boncommande_m->get($id);

		if($factureAchat->token == ''){
			redirect("accueil/");
		}

		$fournisseur = $this->fournisseur_m->get($factureAchat->idfournisseur)->designation;

		$details = $this->detailsbc_m->getArticles($factureAchat->idfacture);

		//echo'<pre>'; die(print_r($details));

		$data['fournisseur'] = $fournisseur;
		$data['details'] = $details;
		$data['bon'] = $factureAchat;

		$data['titre'] = "Affichage d'une facture d'achat";
		$data['page'] = "boncommande/afficher";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function imprimerBon($id){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$bon = $this->boncommande_m->get($id);

		if($bon->token == ''){
			redirect("accueil/");
		}

		$bon->idfournisseur = $this->fournisseur_m->get($bon->idfournisseur)->designation;

		$bon->numbon = 'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

		$details = $this->detailsbc_m->getArticles($bon->idfacture);

		$details2 = $this->detailsbc_m->getDetails($bon->idfacture);

		$poids = 0;

		foreach ($details2 as $detail) {
			$theProduct = $this->produit_m->get($detail->idproduit);

			$poids += ($detail->qte * $theProduct->masse);
		}

		//echo'<pre>'; die(print_r($poids));

		$data['details'] = $details;
		$data['bon'] = $bon;
		$data['poids'] = $poids;

		$message = "Bon de Commande N° ".'BC_'.date('ymd', strtotime($bon->datebon)).'_'.$bon->idfacture;

		$data['message'] = $message;



		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-P',
			'orientation' => 'P'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('boncommande/print', $data, true);
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
}
