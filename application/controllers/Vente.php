<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Vente extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('client_m');
        $this->load->model('produit_m');
        $this->load->model('vente_m');
        $this->load->model('detailvente_m');
        $this->load->model('commercial_m');
        $this->load->model('paiement_m');
        $this->load->model('entrepot_m');
        $this->load->model('typeclient_m');
        $this->load->model('prix_m');
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
                $periode = "Liste des Ventes du ".date('d/m/Y');
                $debut = date('Y/m/d');
                $fin = date('Y/m/d');
                $link = "today";
            }else{
                $debut = $_POST['debut'];
                $fin = $_POST['fin'];
                $periode = "Liste des Ventes du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
                $link = strtotime($debut)."_".strtotime($fin);
            }
        }else{
            $periode = "Liste des Ventes du ".date('d/m/Y');
            $debut = date('Y/m/d');
            $fin = date('Y/m/d');
            $link = "today";
        }

        $ventes = $this->vente_m->getByPeriode($debut, $fin, 'datevente');
        //echo "<pre>";die(print_r($commandes));

        $bigArray = array();
        foreach ($ventes as $key => $vente) {
            //$bigArray[$key] = self::getArray($commande->idcommande);
            $bigArray[$key] = $this->vente_m->getArray($vente->idvente);
        }

        $data['link'] = $link;
        $data['ventes'] = $bigArray;
        $data['texte'] = $periode;
        $data['magasins'] = $this->entrepot_m->getActivated();
        $data['script'] = "filter1";
        $data['script2'] = "global";
        //echo"<pre>"; die(print_r($bigArray));
        $data['titre'] = $periode;
        $data['page'] = "vente/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function selectCustomer(){
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

		$clients = $this->client_m->get_all();
		$data['clients'] = $clients;

		$types = $this->typeclient_m->getActivated();
		$data['types'] = $types;

		$data['page'] = "vente/customer";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        if(!isset($_GET['client'])){
			redirect("vente/selectCustomer");
		}else{
        	$client = $this->client_m->get($_GET['client']);
        	if($client->nom == ""){
				redirect("vente/selectCustomer");
			}
		}

        if(is_null($client)){
			redirect("vente/selectCustomer");
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

        $commerciaux = $this->commercial_m->getActivated();
        $data['commerciaux'] = $commerciaux;

        $data['script'] = "vente";
        //echo"<pre>"; die(print_r($productArray));
        $data['titre'] = 'Vendre';
        $data['page'] = "vente/ajouter";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        //echo'<pre>'; die(print_r($_POST));

        $this->form_validation->set_rules('client_id','Nom du client','required');
        $this->form_validation->set_rules('token','token','required');

        if($this->form_validation->run()){

            if($_POST['remisefacture'] < 0){
                $remise = 0;
            }else{
                $remise = $_POST['remisefacture'];
            }

            $datas = array(
                'datevente' => date('Y-m-d'),
                'client_id' => $this->input->post('client_id'),
                'commercial_id' => $this->input->post('commercial_id'),
                'tva_id' => $this->input->post('tva'),
                'avance' => 0,
                'montant' => 0,
                'remisefacture' => $remise,
                'token' => $this->input->post('token'),
                'arretcaisse_id' => $_SESSION['IdAC'],
            );

            if(!$this->vente_m->exist($this->input->post('token'))) {
                $vente_id = $this->vente_m->add_item($datas);

				$client = $this->client_m->get($_POST['client_id']);

                $tva_id = $_POST['tva'];
                if($tva_id == ""){
                    $pourcent = 0;
                }else{
                    $pourcent = $tva_id;
                }
                // dd($tva_id);

                $montant = 0;

                foreach($_POST['lib2'] as $cle => $lib2){
                    $produit = $this->produit_m->get($lib2);

					$price = $this->prix_m->getPrice($produit->idproduit, $client->type_client);

					$price = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
                    $montant += $price * $_POST['qte'][$cle];

                    $dataR = array(
                        'vente_id' => $vente_id,
                        'produit_id' => $lib2,
                        'qte' => $_POST['qte'][$cle],
                        'pu' => $price,
                        'remise' => $_POST['remise'][$cle],
                    );
                    $this->detailvente_m->add_item($dataR);
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
                $this->vente_m->update($vente_id, $vente);

                if($_POST['montP'] > 0){
					$paiement = array(
						'vente_id' => $vente_id,
						'userid' => $this->session->userdata('user_id'),
						'montant' => $montantPayer,
						'etat' => 0,
						'datepaiement' => date('Y/m/d'),

						'typepaiement' => $this->input->post('typepaiement'),
						'numerocheque' => $this->input->post('numerocheque'),
						'nombanque' => $this->input->post('nombanque'),

						'token' => $this->input->post('token'),
						'arretcaisse_id' => $_SESSION['IdAC'],
					);

					if(!$this->paiement_m->exist($this->input->post('token'))) {
						$this->paiement_m->add_item($paiement);
					}
				}

                if($montantPayer !== $mttc  ){
					$dataR2 = array(
						'echeance' => $this->input->post('echeance'),
					);
                    $this->vente_m->update($vente_id, $dataR2);
				}
            }
        }
        redirect('vente/ajouter','refresh');
    }

    public function details($id){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $returnArray = $this->vente_m->getArray($id);

        //echo "<pre>";die(print_r($returnArray));
        $data['returnArray'] = $returnArray;
        $data['script'] = 'global';
        $data['titre'] = 'Détail de la Vente N° '.$id;
        $data['page'] = "vente/details";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);

    }

    public function modifier($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $vente = $this->vente_m->get($id);

        if($vente->token == ''){
            redirect('vente/index','refresh');
        }

        $returnArray = $this->vente_m->getArray($id);
        $data['returnArray'] = $returnArray;

        $client = $this->client_m->get($vente->client_id);
        $data['client'] = $client;

		$produits = $this->produit_m->get_all();

		$productArray = array();

		foreach ($produits as $produit) {
			$price = $this->prix_m->getPrice($produit->idproduit, $client->type_client);

			$productArray[$produit->idproduit]['Designation'] = $produit->designation;
			$productArray[$produit->idproduit]['IdProduit'] = $produit->idproduit;
			$productArray[$produit->idproduit]['Prix'] = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
		}
        $data['produits'] = $productArray;

		$commerciaux = $this->commercial_m->getActivated();
		$data['commerciaux'] = $commerciaux;

        $data['script'] = "vente";

        //echo "<pre>";die(print_r($returnArray));

        $data['titre'] = 'Modifier la Vente N° '.$id;
        $data['page'] = "vente/modifier";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }

    public function update(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $vente = $this->vente_m->get($_POST['cmdID']);
        if($vente->token == ''){
            redirect('vente/index','refresh');
        }

        //echo "<pre>";die(print_r($_POST));

        $this->form_validation->set_rules('client_id','Nom du client','required');

        //echo'<pre>'; die(print_r($reclamation));

		if($_POST['remisefacture'] < 0){
			$remise = 0;
		}else{
			$remise = $_POST['remisefacture'];
		}

        if($this->form_validation->run()){

            $datas = array(
				'client_id' => $this->input->post('client_id'),
				'commercial_id' => $this->input->post('commercial_id'),
				'tva_id' => $this->input->post('tva'),
				'avance' => 0,
				'montant' => 0,
				'remisefacture' => $remise,
            );

            if(1 == 1) {

                $this->vente_m->update($vente->idvente, $datas);
                $vente_id = $vente->idvente;

				$client = $this->client_m->get($_POST['client_id']);

                $montant = 0;
                foreach($_POST['lib2'] as $cle => $lib2){

                    $exist = $this->detailvente_m->checkIfAlreadyExist($vente_id, $lib2);


					$produit = $this->produit_m->get($lib2);

					$price = $this->prix_m->getPrice($produit->idproduit, $client->type_client);

					$price = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
					$montant += $price * $_POST['qte'][$cle];


                    if(empty($exist)){
                        $dataR = array(
                            'vente_id' => $vente_id,
                            'produit_id' => $lib2,
                            'qte' => $_POST['qte'][$cle],
                            'pu' => $produit->montant,
                            'remise' => $_POST['remise'][$cle],
                        );
                        $this->detailvente_m->add_item($dataR);
                    }else{
                        $dataR = array(
                            'qte' => $_POST['qte'][$cle],
                            'remise' => $_POST['remise'][$cle],
                        );
                        $this->detailvente_m->update($exist[0]->iddetailvente, $dataR);
                    }
                }

                $commande = array(
                    'montant' => $montant,
                );
                $this->vente_m->update($vente_id, $commande);
            }
        }
        redirect('vente/index','refresh');
    }

    public function annuler($id){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $commande = $this->vente_m->get($id);
        if($commande->token == ''){
            redirect('vente/index','refresh');
        }
        if($commande->etat == 1){
            redirect('vente/index','refresh');
        }

        $commandee = array(
            'etat' => -1,
        );
        $this->vente_m->update($commande->idvente, $commandee);
        redirect('vente/index','refresh');
    }

    public function imprimer($item){

        $message = "Liste des Sites";

        if(isset($item)){
            if($item == 'today'){
                $message = "Liste des Ventes du ".date('d/m/Y');
                $debut = date('Y/m/d');
                $fin = date('Y/m/d');
            }else{
                $temp = explode('_', $item);

                $debut = date('Y/m/d', $temp[0]);
                $fin = date('Y/m/d', $temp[1]);

                $message = "Liste des Ventes du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
            }
        }else{
            $message = "Liste des Ventes du ".date('d/m/Y');
            $debut = date('Y/m/d');
            $fin = date('Y/m/d');
        }

        $commandes = $this->vente_m->getByPeriode($debut, $fin, 'datevente');
        //echo "<pre>";die(print_r($commandes));

        $bigArray = array();
        foreach ($commandes as $key => $commande) {
            $bigArray[$key] = $this->vente_m->getArray($commande->idvente);
        }

        $data['commandes'] = $bigArray;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('vente/print', $data, true);
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
        $mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'.$message.'</td>
                </tr>
            </table>');
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

    public function imprimerCommande($id){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $commande = $this->vente_m->get($id);



        $message = 'FACT_'.date('ymd', strtotime($commande->datevente)).'_'.$commande->idvente;



        $returnArray = $this->vente_m->getArray($commande->idvente);


        //echo "<pre>";die(print_r($returnArray));
        $data['returnArray'] = $returnArray;

        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('vente/printCommande', $data, true);
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

    public function livrer($idvente){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$returnArray = $this->vente_m->getArray($idvente);

		//echo "<pre>";die(print_r($returnArray));
		$data['returnArray'] = $returnArray;
		$data['script'] = 'global';
		$data['titre'] = 'Détail de la Vente N° '.$idvente;
		$data['page'] = "vente/details";
		$data['menu'] = 'edition';
		$this->load->view($this->template, $data);
	}

	public function imprimerBL($id){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$commande = $this->vente_m->get($id);



		$message = 'BON DE LIVRAISON N° '.date('ymd', strtotime($commande->datelivraison)).'_'.$commande->idvente;



		$returnArray = $this->vente_m->getArray($commande->idvente);


		//echo "<pre>";die(print_r($returnArray));
		$data['returnArray'] = $returnArray;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-P',
			'orientation' => 'P'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('vente/printBL', $data, true);
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
