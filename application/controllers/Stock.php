<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('stock_m');
        $this->load->model('produit_m');
        $this->load->model('produit_m');
        $this->load->model('entrepot_m');
        $this->load->model('vente_m');
        $this->load->model('detailvente_m');
        $this->load->model('transfert_m');
        $this->load->model('detailtransfert_m');
    }

    public $template = 'templates/template';

    public function achat()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $stocks = $this->stock_m->get_all();
        $data['stocks'] = $stocks;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Etat du Stock';
        $data['page'] = "stock/ajouter";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $produits = $this->produit_m->getActivated();

        $stocks = array();
        foreach ($produits as $produit) {
            $stocks[$produit->idproduit]['designation'] = $produit->designation;
            $stocks[$produit->idproduit]['seuil'] = $produit->seuil;
            $qte = $this->stock_m->getProductsWithDetails($produit->idproduit);
            $listeP = $this->stock_m->getProductsWithDetails2($produit->idproduit);
            $prix = 0;
            foreach ($listeP as $iteme) {
                $prix += ($iteme->qte * $iteme->prixachat);
            }
            //echo"<pre>"; die(print_r($prix));
            $stocks[$produit->idproduit]['Qte'] = $qte;
            $stocks[$produit->idproduit]['Poids'] = $produit->masse * $qte;
            $stocks[$produit->idproduit]['Montant'] = $prix;


        }

        //$stocks = $this->stock_m->getAllProductsWithDetails();
        $data['stocks'] = $stocks;
        //echo"<pre>"; die(print_r($stocks));
        $data['titre'] = 'Etat du Stock';
        $data['page'] = "stock/liste";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function entrepot()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $produits = $this->produit_m->getActivated();
		$entrepots = $this->entrepot_m->getActivated();


		//$ent = $_POST['entrepot'];
		//$entrepot = $this->entrepot_m->get($_POST['entrepot']);

		$stocks = array();

		foreach ($produits as $produit) {
			$stocks[$produit->idproduit]['Produit'] = $produit;
			foreach ($entrepots as $entrepot) {
				$qte = $this->stock_m->getProductsByEntrepotWithDetails($produit->idproduit, $entrepot->identrepot);
				if(!is_numeric($qte))
					$qte = 0;

				if($qte > 0){
					$stocks[$produit->idproduit]['Quantité'][$entrepot->identrepot] = $qte;
				}
			}
		}


        $entrepots = $this->entrepot_m->getActivated();


        $data['stocks'] = $stocks;
        $data['entrepots'] = $entrepots;
        $data['produits'] = $produits;

        //echo"<pre>"; die(print_r($stocks));
        $data['titre'] = 'Etat du Stock';
        $data['page'] = "stock/entrepot";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $stocks = $this->stock_m->get_all();
        $data['stocks'] = $stocks;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Facture d\'Achat';
        $data['page'] = "stock/ajouter";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('designation','Désignation de l\'intrant','required');
        $this->form_validation->set_rules('masse','Masse de l\'intrant','required');

        //echo'<pre>'; die(print_r($reclamation));

        if($this->form_validation->run()){

            $datas = array(
                'designation' => $this->input->post('designation'),
                'description' => $this->input->post('description'),
                'masse' => $this->input->post('masse'),
                'unite' => $this->input->post('unite'),
                'etat' => 0,
                'token' => $this->input->post('token'),
            );

            if(!$this->stock_m->exist($this->input->post('token'))) {
                $this->stock_m->add_item($datas);
            }
        }
        redirect('intrant/index','refresh');
        $data['title'] = 'Ajouter un intrant';
        $data['main_content']='intrant/index';
        $data['menu']='intrant';
        $this->load->view($this->template, $data);
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $intrant = $this->stock_m->get($id);
        if($intrant->designation == ""){
            redirect("intrant/");
        }
        $intrants = $this->stock_m->get_all();
        $data['intrants'] = $intrants;

        $data['intrant'] = $intrant;

        $data['titre'] = 'Modifier un intrant '.$intrant->designation;
        $data['page'] = "intrant/modifier";
        $data['menu'] = 'intrant';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $intrant = $this->stock_m->get($_POST['id']);
        if($intrant->designation == ""){
            redirect("intrant/");
        }

        $this->form_validation->set_rules('designation','Désignation de l\'intrant','required');
        $this->form_validation->set_rules('masse','Masse de l\'intrant','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
                'designation' => $this->input->post('designation'),
                'description' => $this->input->post('description'),
                'masse' => $this->input->post('masse'),
                'unite' => $this->input->post('unite'),
                'etat' => $etat,
            );

            $this->stock_m->update($intrant->idintrant, $datas);

        }
        redirect('intrant/index','refresh');
        $data['title'] = 'Ajouter un intrant';
        $data['main_content']='intrant/index';
        $data['menu']='intrant';
        $this->load->view($this->template, $data);
    }

    public function imprimer(){

        $message = "Etat du Stock Général";

        $intrants = $this->intrant_m->getActivated();

        $stocks = array();
        foreach ($intrants as $intrant) {
            $stocks[$intrant->idintrant]['designation'] = $intrant->designation;
            $stocks[$intrant->idintrant]['seuil'] = $intrant->seuil;
            $stocks[$intrant->idintrant]['unite'] = $this->unite_m->get($intrant->unite)->symbole;
            $qte = $this->stock_m->getProductsWithDetails($intrant->idintrant);
            $stocks[$intrant->idintrant]['Qte'] = $qte;
            $stocks[$intrant->idintrant]['Poids'] = $intrant->masse * $qte;
        }

        //$stocks = $this->stock_m->getAllProductsWithDetails();
        $data['stocks'] = $stocks;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('stock/print', $data, true);
        $mpdf->setFooter('{PAGENO} / {nb}');
        $mpdf->SetHTMLHeader('
            <div style="text-align: right; font-weight: bold;">
                '.$message.'
            </div>');
        $mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'.$message.'</td>
                </tr>
            </table>');
        $mpdf->WriteHTML($html);
        $mpdf->Output($message.'.pdf', 'I');
    }

    public function destocker(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_POST['magasin']) AND isset($_POST['achat'])){
			$achat = $this->vente_m->get($_POST['achat']);

			$details = $this->detailvente_m->getByForeignKey($achat->idvente);

			$magasin = $this->entrepot_m->get($_POST['magasin']);

			$verif = true;

			//echo'<pre>'; die(print_r($details));

			foreach ($details as $detail) {
				$qte = $this->stock_m->getProductsByEntrepotWithDetails($detail->produit_id, $magasin->identrepot);
				if(!is_numeric($qte))
					$verif = false;
			}

			if($verif){
				foreach ($details as $detail) {
					$lines = $this->stock_m->getProductsLineByEntrepotWithDetails($detail->produit_id, $magasin->identrepot);

					if(!empty($lines)){

						$aRetirer = $detail->qte;

						foreach ($lines as $line) {
							if($line->qte > 0){
								if($aRetirer > 0){
									if($aRetirer >= $line->qte){
										$aRetirer -= $line->qte;
										$dataz = array(
											'qte' => 0,
										);
										$this->stock_m->update($line->idstock, $dataz);
									}else{
										$nvxQte = $line->qte - $aRetirer;
										$aRetirer = 0;

										$dataz = array(
											'qte' => $nvxQte,
										);
										$this->stock_m->update($line->idstock, $dataz);
									}

								}
							}
						}
					}
				}

				$dataVente = array(
					'etatlivraison' => 1,
					'datelivraison' => date('Y/m/d'),
					'entrepotlivraison' => $magasin->identrepot,
				);
				$this->vente_m->update($achat->idvente, $dataVente);

				$this->session->set_flashdata('destockage', 'Destockage effectué');

			}else{
				$this->session->set_flashdata('destockage', 'Impossible de Livrer ces marchandises. Quantité insufisante dans ce magasin');
			}
			//echo'<pre>'; die('Verif ==> '.$verif);
		}else{
			$this->session->set_flashdata('destockage', 'Choisissez un magasin pour la livraison');
		}

		redirect('vente/index','refresh');
	}

	public function transfert(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$entrepots = $this->entrepot_m->getActivated();
		$data['entrepots'] = $entrepots;

		$data['titre'] = 'Transfert Interne de Stock';
		$data['page'] = "stock/choixmagasin";
		$data['menu'] = 'stock';
		$this->load->view($this->template, $data);
	}

	public function transfert_step2(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$entrepotDe = $this->entrepot_m->get($_POST['de']);
		$data['entrepotDe'] = $entrepotDe;

		$entrepotVers = $this->entrepot_m->get($_POST['vers']);
		$data['entrepotVers'] = $entrepotVers;

		$produits = $this->produit_m->getActivated();
		$stocks = array();
		foreach ($produits as $produit) {
			$qte = $this->stock_m->getProductsByEntrepotWithDetails($produit->idproduit, $_POST['de']);
			if(!is_numeric($qte))
				$qte = 0;

			if($qte > 0){
				$stocks[$produit->idproduit]['idProduit'] = $produit->idproduit;
				$stocks[$produit->idproduit]['designation'] = $produit->designation;
				$stocks[$produit->idproduit]['seuil'] = $produit->seuil;
				$stocks[$produit->idproduit]['Qte'] = $qte;
			}
		}

		//echo "<pre>";die(print_r($stocks));
		$data['stocks'] = $stocks;
		$data['de'] = $entrepotDe;
		$data['vers'] = $entrepotVers;

		$data['titre'] = 'Transfert Interne de Stock';
		$data['page'] = "stock/transfert";
		$data['menu'] = 'stock';
		$this->load->view($this->template, $data);
	}

	public function insertTransfert(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$entrepotDe = $this->entrepot_m->get($_POST['de']);
		
		$entrepotVers = $this->entrepot_m->get($_POST['vers']);

		$produits = $this->produit_m->getActivated();

		$datas = array(
			'datetransfert' => date('Y/m/d'),
			'heuretransfert' => date('H:i:s'),
			'user_id' => $this->session->userdata('user_id'),
			'token' => $this->input->post('token'),

			'de' => $this->input->post('de'),
			'vers' => $this->input->post('vers'),
		);

		$idTransfert = $this->transfert_m->add_item($datas);

		foreach ($produits as $produit) {
			if(isset($_POST['stock_'.$produit->idproduit]) AND $_POST['stock_'.$produit->idproduit] > 0){
				//echo "<pre>";die(print_r($_POST['stock_'.$produit->idproduit]));
				$dataDetail = array(
					'idproduit' => $produit->idproduit,
					'quantite' => $_POST['stock_'.$produit->idproduit],
					'transfert_id' => $idTransfert,
				);
				$this->detailtransfert_m->add_item($dataDetail);

				$lines = $this->stock_m->getAllStockByIdArticle($produit->idproduit, $_POST['de']);
				//echo "<pre>";die(print_r($lines));
				$aRetirer = $_POST['stock_'.$produit->idproduit];
				foreach ($lines as $line) {
					if($line->qte > 0){
						if($aRetirer > 0){
							if($aRetirer >= $line->qte){
								$aRetirer -= $line->qte;
								$dataY = array(
									'idproduit' => $produit->idproduit,
									'qte' => $line->qte,
									'prixachat' => $line->prixachat,
									'identrepot' => $_POST['vers'],
									'idbl' => $line->idbl,
									'dateachat' => $line->dateachat,
								);
								$this->stock_m->insert($dataY);

								$dataz = array(
									'qte' => 0,
								);
								$this->stock_m->update($line->idstock, $dataz);
							}else{
								$nvxQte = $line->qte - $aRetirer;

								$dataY = array(
									'idproduit' => $produit->idproduit,
									'qte' => $aRetirer,
									'prixachat' => $line->prixachat,
									'identrepot' => $_POST['vers'],
									'idbl' => $line->idbl,
									'dateachat' => $line->dateachat,
								);
								$this->stock_m->insert($dataY);

								$aRetirer = 0;

								$dataz = array(
									'qte' => $nvxQte,
								);
								$this->stock_m->update($line->idstock ,$dataz);
							}
						}
					}
				}
			}
		}

		redirect('stock/entrepot','refresh');
	}


































































































    public function stock(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $points = $this->point_m->getActivated();

        $liste = $this->produit_m->getActivated();

        if(isset($_POST['pointvente'])){
            if($_POST['pointvente'] == 'all'){
                $idpoint = null;
            }else{
                $idpoint = $_POST['pointvente'];
            }
        }else{
            $idpoint = null;
        }

        $resultArray = array();
        $i = 0;
        foreach ($liste as $key => $item) {
            $realQte = $this->stockproduit_m->getQte($item->idproduit, $idpoint);
            if($realQte > 0){
                $item->qte = $realQte;
                $resultArray[$i] = $item;
            }
            $i++;
        }
        //echo"<pre>"; die(print_r($resultArray));

        //echo"<pre>"; die(print_r($liste));

        $data['selectedPoint'] = $idpoint;
        $data['stocks'] = $resultArray;
        $data['points'] = $points;

        //echo"<pre>"; die(print_r($points));
        $data['titre'] = 'Stock Point de Ventes';
        $data['page'] = "vente/liste";
        $data['menu'] = 'vente';
        $this->load->view($this->template, $data);
    }

    public function printStk($param = null){


        $message = "Reste par Point de Vente";

        $liste = $this->produit_m->getActivated();

        if(!is_null($param)){
            if($param == 'all'){
                $idpoint = null;
                $point = 'Tous les Points de Vente';
            }else{
                $idpoint = $param;
                $p = $this->point_m->get($idpoint);
                if(!is_object($p)){
                    $idpoint = null;
                    $point = 'Tous les Points de Vente';
                }else{
                    $point = 'Point de Vente: '.$p->designation;
                }
            }
        }else{
            $idpoint = null;
            $point = 'Tous les Points de Vente';
        }

        $resultArray = array();
        $i = 0;
        foreach ($liste as $key => $item) {
            $realQte = $this->stockproduit_m->getQte($item->idproduit, $idpoint);
            if($realQte > 0){
                $item->qte = $realQte;
                $resultArray[$i] = $item;
            }
            $i++;
        }

        //echo"<pre>"; die(print_r($resultArray));

        $data['selectedPoint'] = $point;
        $data['stocks'] = $resultArray;

        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('stock/printReste', $data, true);
        $mpdf->setFooter('{PAGENO} / {nb}');
        $mpdf->SetHTMLHeader('
        <div style="text-align: right; font-weight: bold;">
            '.$message.'
        </div>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">'.$message.'</td>
            </tr>
        </table>');
        $mpdf->WriteHTML($html);
        $mpdf->Output($message.'.pdf', 'I');
    }

    public function equilibrer($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $point = $this->point_m->get($id);

        $liste = $this->produit_m->getActivated();

        $idpoint = $point->idpoint;

        $resultArray = array();
        $i = 0;
        foreach ($liste as $key => $item) {
            $realQte = $this->stockproduit_m->getQte($item->idproduit, $idpoint);
            if($realQte > 0){
                $item->qte = $realQte;
                $resultArray[$i] = $item;
            }
            $i++;
        }

        $data['stocks'] = $resultArray;
        $data['point'] = $point;
        $data['titre'] = 'Equilibrer Produits';
        $data['page'] = "vente/equilibrer";
        $data['menu'] = 'vente';
        $this->load->view($this->template, $data);
        //echo"<pre>"; die(print_r($resultArray));
    }

    public function insertEquibrage(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $datax = array(
            'dateperte' => date('Y/m/d'),
            'heureperte' => date('H:i:s'),
            'iduser' => $this->session->userdata('user_id'),
            'idpoint' => $this->input->post('pointvente'),
            'token' => $this->input->post('token'),
        );

        $new = $_POST['new'];
        $old = $_POST['old'];

        //echo "<pre>"; die(print_r($_POST));

        if(!$this->perteproduit_m->exist($this->input->post('token'))) {

            $lastId = $this->perteproduit_m->add_item($datax);



            foreach ($new as $key => $item) {

                $theProduct = $this->produit_m->get($key);

                $datax = array(
                    'idproduit' => $key,
                    'qteavant' => $old[$key],
                    'qteapres' => $item,
                    'idperteproduit' => $lastId,
                );
                $this->detailperteproduction_m->add_item($datax);

                //Diminution Qte dans produit

                $diff = $item - $old[$key];
                $datay = array(
                    'qte' => $theProduct->qte + $diff,
                );
                $this->produit_m->update($theProduct->idproduit, $datay); // Reduction du stock disponible

                //Diminution Qte dans stock production
                $idLine = $this->stockproduit_m->getLineId3($theProduct->idproduit, $_POST['pointvente']);

                $total = 0;
                foreach ($idLine as $idL) {
                    $stockProduit = $this->stockproduit_m->get($idL->id);
                    $total += $stockProduit->qte;
                }

                $diff2 = $item - $total;

                if($diff2 >= 0){
                    $forAdd = $diff2;
                    foreach ($idLine as $idL) {
                        if($forAdd > 0){
                            $stockProduit = $this->stockproduit_m->get($idL->id);
                            $dataP2 = array(
                                'qte' => $stockProduit->qte + $forAdd,
                            );

                            $this->stockproduit_m->update($stockProduit->id, $dataP2);

                            $forAdd = 0;
                        }
                    }
                }else{

                    $aRetirer = -1 * $diff2;

                    foreach ($idLine as $idL) {
                        $stockProduit = $this->stockproduit_m->get($idL->id);

                        if($stockProduit->qte > 0){

                            if($aRetirer > 0){
                                if($aRetirer >= $stockProduit->qte){
                                    $aRetirer -= $stockProduit->qte;

                                    $dataP2 = array(
                                        'qte' => 0,
                                    );

                                    $this->stockproduit_m->update($stockProduit->id, $dataP2);

                                }else{
                                    $nvxQte = $stockProduit->qte - $aRetirer;

                                    $dataP2 = array(
                                        'qte' => $nvxQte,
                                    );

                                    $this->stockproduit_m->update($stockProduit->id, $dataP2);

                                    $aRetirer = 0;
                                }
                            }
                        }
                    }
                }
            }
        }
        redirect('stock/stock','refresh');
    }

    public function historique_perte(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $bigarray = array();
        $link = '';
        if(isset($_POST['periode'])){
            if($_POST['periode'] == 'today'){
                $debut = date("Y/m/d");
                $fin = date("Y/m/d");

                $data['texte'] = 'Pertes du '.date("d/m/Y");

                $link = 'today';
            }else{
                $debut = $_POST['debut'];
                $fin = $_POST['fin'];
                $link = strtotime($debut).'_'.strtotime($fin);
                $data['texte'] = 'Pertes du '.date("d/m/Y", strtotime($debut)).' au '.date("d/m/Y", strtotime($fin));
            }
        }else{
            $debut = date("Y/m/d");
            $fin = date("Y/m/d");

            $data['texte'] = 'Pertes du '.date("d/m/Y");

            $link = 'today';
        }

        $liste = $this->perteproduit_m->getPerteByPeriode($debut, $fin);

        if(!empty($liste)){
            foreach ($liste as $item) {
                $details = $this->detailperteproduction_m->getDetailPerteByID($item->idperte);
                $point = $this->point_m->get($item->idpoint);

                if(!empty($details)){
                    foreach ($details as $detail) {
                        $qteperdue = $detail->qteavant - $detail->qteapres;

                        $produit = $this->produit_m->get($detail->idproduit);
                        $bigarray[$detail->iddetailperte]['Produit'] = $produit->designation;
                        $bigarray[$detail->iddetailperte]['quantite'] = $qteperdue;
                        $bigarray[$detail->iddetailperte]['Point'] = $point->designation;
                        $bigarray[$detail->iddetailperte]['date'] = date("d/m/Y", strtotime($item->dateperte));
                        $bigarray[$detail->iddetailperte]['heure'] = date("H:i", strtotime($item->heureperte));
                    }
                }
            }
        }
        //echo"<pre>"; die(print_r($bigarray));
        $data['details'] = $bigarray;
        $data['link'] = $link;
        $data['titre'] = $data['texte'];
        $data['page'] = "stock/historique";
        $data['menu'] = 'prod';
        $data['script'] = 'filter1';
        $this->load->view($this->template, $data);
    }

    public function printHistory($param){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $bigarray = array();
        $link = '';
        if(isset($param)){
            if($param == 'today'){
                $debut = date("Y/m/d");
                $fin = date("Y/m/d");

                $data['texte'] = 'Pertes du '.date("d/m/Y");
            }else{
                $temp = explode('_', $param);
                $debut = date('Y/m/d', $temp[0]);
                $fin = date('Y/m/d', $temp[1]);

                $data['texte'] = 'Pertes du '.date("d/m/Y", strtotime($debut)).' au '.date("d/m/Y", strtotime($fin));
            }
        }else{
            $debut = date("Y/m/d");
            $fin = date("Y/m/d");

            $data['texte'] = 'Pertes du '.date("d/m/Y");
        }

        $liste = $this->perteproduit_m->getPerteByPeriode($debut, $fin);

        if(!empty($liste)){
            foreach ($liste as $item) {
                $details = $this->detailperteproduction_m->getDetailPerteByID($item->idperte);
                $point = $this->point_m->get($item->idpoint);

                if(!empty($details)){
                    foreach ($details as $detail) {
                        $qteperdue = $detail->qteavant - $detail->qteapres;

                        $produit = $this->produit_m->get($detail->idproduit);
                        $bigarray[$detail->iddetailperte]['Produit'] = $produit->designation;
                        $bigarray[$detail->iddetailperte]['quantite'] = $qteperdue;
                        $bigarray[$detail->iddetailperte]['Point'] = $point->designation;
                        $bigarray[$detail->iddetailperte]['date'] = date("d/m/Y", strtotime($item->dateperte));
                        $bigarray[$detail->iddetailperte]['heure'] = date("H:i", strtotime($item->heureperte));
                    }
                }
            }
        }
        //echo"<pre>"; die(print_r($bigarray));
        $message = $data['texte'];

        $data['details'] = $bigarray;

        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('stock/printHistoriquePerte', $data, true);
        $mpdf->setFooter('{PAGENO} / {nb}');
        $mpdf->SetHTMLHeader('
        <div style="text-align: right; font-weight: bold;">
            '.$message.'
        </div>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">'.$message.'</td>
            </tr>
        </table>');
        $mpdf->WriteHTML($html);
        $mpdf->Output($message.'.pdf', 'I');
    }














































    public function afficher(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$link = 'today';
				$debut = date('Y-m-d');
				$fin = date('Y-m-d');
				$periode = "Date: Aujourd'hui";
			}else{
				$link = $_POST['debut'].'_'.$_POST['fin'];
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$periode = "Periode: Du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
			}
		}else{
			$link = 'today';
			$debut = date('Y-m-d');
			$fin = date('Y-m-d');
			$periode = "Date: Aujourd'hui";
		}

		if(isset($_POST['intrant']) AND $_POST['intrant'] != ''){
			$intrants[] = $this->intrant_m->get($_POST['intrant']);
			$selected = $_POST['intrant'];
		}else{
			$intrants = $this->intrant_m->getActivated();
			$selected = "";
		}


		//$intrants = $this->intrant_m->getActivated();

		$debut = strtotime($debut);

		$fin = strtotime($fin);

		for ($currentDate = $debut; $currentDate <= $fin; $currentDate += (86400)) {
			$theDate = date('Y-m-d', $currentDate);


			$i = 0;
			foreach ($intrants as $intrant) {
				if($intrant->idintrant > 0) {
					$stock = $this->stock_m->getProductStock($intrant->idintrant);
					if (!is_numeric($stock))
						$stock = 0;

					// Process to get a day Stock

					$achatPrev = $this->details_achat_m->getAchatsByIntrantPrev($intrant->idintrant, date('Y/m/d'), $theDate);
					$destockagePrev = $this->destockage_m->getAllQteDestocker($intrant->idintrant, $theDate, date('Y/m/d'));

					$stockInitial = $stock - $achatPrev + $destockagePrev;
					//echo'<pre>'; die(print_r($stockInitial));
					// End Process

					$achat = $this->details_achat_m->getAchatsByIntrant($intrant->idintrant, $theDate);

					if (!is_numeric($achat))
						$achat = 0;

					$destockagePain = $this->destockage_m->getQteDestocker($intrant->idintrant, $theDate, 'pain');

					$destockageViennoiserie = $this->destockage_m->getQteDestocker($intrant->idintrant, $theDate, 'viennoiserie');


					//$destockagePain = self::convertQte($intrant, $destockagePain);
					//$destockageViennoiserie = self::convertQte($intrant, $destockageViennoiserie);

					if($stockInitial < 0)
						$stockInitial = 0;

					$unite = $this->unite_m->get($intrant->unite)->symbole;

					$stk[$theDate][$i]['Intrant'] = $intrant->designation;
					$stk[$theDate][$i]['Unite'] = $unite;
					$stk[$theDate][$i]['StockInitial'] = $stockInitial;
					$stk[$theDate][$i]['Achat'] = $achat;
					$stk[$theDate][$i]['DestockagePain'] = $destockagePain;
					$stk[$theDate][$i]['DestockageViennoiserie'] = $destockageViennoiserie;
					$stk[$theDate][$i]['StockFinal'] = $stockInitial + $achat - $destockagePain - $destockageViennoiserie;

					$i++;
				}
			}
		}

		//echo'<pre>'; die(print_r($stk));


		$data['selectedProduit'] = $selected;
		$data['intrants'] = $this->intrant_m->getActivated();

		$data['stocks'] = $stk;
		$data['link'] = $link;
		$data['titre'] = $periode;
		$data['page'] = "stock/stock";
		$data['menu'] = 'prod';
		$data['script'] = 'filter1';
		$this->load->view($this->template, $data);


		//echo'<pre>'; die(print_r($stk));
	}

	public function convertQte($intrant, $oldQte){

		$item = $this->detailfiche_m->getOneLine($intrant->idintrant);

		$realQte = 0;

		if (!empty($item)) {

			$item = $item[0];
			//echo'<pre>'; die(print_r($item));


			if ($item->idunite != $intrant->unite) {  // Si unite par defaut de l'intrant est differente de l'unite lors de l'enregistrement de la ligne FT alores on convertie l'unite par defaud
				$theUnit = $this->unite_m->get($intrant->unite); // Represente l'objet Unite de l'intrant ( a modifier)
				$uniteParDefaut = $this->unite_m->get($item->idunite); // Represente l'objet Unite de la FT

				//echo'<pre>'; die(print_r($uniteParDefaut));
				if ($theUnit->parent > 0) {
					$realQte = $theUnit->valeur * $oldQte;

					//echo "Second QTe ============ > ".$realQte." Kg <br>";

					if ($uniteParDefaut->parent != $theUnit->idunite) {
						$realQte = $realQte / $uniteParDefaut->valeur;
					}

					//echo "Second QTe ============ > ".$realQte." g <br>";

					//echo'<pre>'; die(print_r($realQte));
				} else {
					$realQte = $oldQte / $uniteParDefaut->valeur;

					if ($theUnit->parent != $intrant->unite) {
						$realQte = $realQte / $uniteParDefaut->valeur;
					}
				}
			} else {
				$realQte = $oldQte;
			}

		}
		return $realQte;
	}

}
