<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Paiement extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('client_m');
        $this->load->model('produit_m');
        $this->load->model('vente_m');
        $this->load->model('paiement_m');
        $this->load->model('detailvente_m');
        $this->load->model('commercial_m');
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
                $periode = "Liste des Paiements Client du ".date('d/m/Y');
                $debut = date('Y/m/d');
                $fin = date('Y/m/d');
                $link = 'today';
            }else{
                $debut = $_POST['debut'];
                $fin = $_POST['fin'];
                $periode = "Liste des Paiements Client du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
                $link = strtotime($debut)."_".strtotime($fin);
            }
        }else{
            $periode = "Liste des Paiements Client du ".date('d/m/Y');
            $debut = date('Y/m/d');
            $fin = date('Y/m/d');
            $link = 'today';
        }

        $paiements = $this->paiement_m->getByPeriode($debut, $fin, 'datepaiement');

        $data['paiements'] = $paiements;
        $data['texte'] = $periode;
        $data['link'] = $link;
        $data['script'] = "filter1";
        $data['titre'] = $periode;
        $data['page'] = "paiement/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $vente = $this->vente_m->get($id);

        $returnArray = $this->vente_m->getArray($id);

        if($returnArray['MontantVerse'] >= $returnArray['TotalTTC']){
            redirect('accueil/index','refresh');
        }

        //echo "<pre>";die(print_r($returnArray));
        $data['returnArray'] = $returnArray;
        $data['script'] = 'global';
        $data['titre'] = 'Faire un Versement';
        $data['page'] = "paiement/ajouter";
        $data['menu'] = 'caisse';
        $this->load->view($this->template, $data);
    }


    public function validerversement(){

        $this->form_validation->set_rules('montV','Montant du versement','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()) {

            $vente = $this->vente_m->get($_POST['comdId']);

            $array =  $this->vente_m->getArray($vente->idvente);

			//echo "<pre>";die(print_r($array));


            if($array['Reste'] <= 0){
                redirect('accueil/index','refresh');
            }

            //echo "<pre>";die(print_r($array));

            $montantVersee = $_POST['montV'];
            if($montantVersee > $array['Reste'])
                $montantVersee = $array['Reste'];

            $paiement = array(
                'vente_id' => $vente->idvente,
                'userid' => $this->session->userdata('user_id'),
                'montant' => $montantVersee,
                'etat' => 0,
                'datepaiement' => date('Y/m/d'),

				'typepaiement' => $this->input->post('typepaiement'),
				'numerocheque' => $this->input->post('numerocheque'),
				'nombanque' => $this->input->post('nombanque'),

                'token' => $this->input->post('token'),
				'arretcaisse_id' => $_SESSION['IdAC'],
            );


            if(!$this->paiement_m->exist($this->input->post('token'))){
                $this->paiement_m->add_item($paiement);


                $venteArray = array(
                    'echeance' => $this->input->post('echeance'),
                );
                $this->vente_m->update($vente->idvente, $venteArray);

            }

        }

        redirect('paiement/index','refresh');
    }


    public function imprimer($param){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        if(isset($param)){
            if($param == 'today'){
                $periode = "Liste des Paiements Client du ".date('d/m/Y');
                $debut = date('Y/m/d');
                $fin = date('Y/m/d');
            }else{
                $temp = explode('_', $param);
                $debut = $temp[0];
                $fin = $temp[1];
                $periode = "Liste des Paiements Client du ".date("d/m/Y", $debut)." au ".date("d/m/Y", $fin);
            }
        }else{
            $periode = "Liste des Paiements Client du ".date('d/m/Y');
            $debut = date('Y/m/d');
            $fin = date('Y/m/d');
        }

        $paiements = $this->paiement_m->getByPeriode(date("Y/m/d", $debut), date("Y/m/d", $fin), 'datepaiement');
        foreach ($paiements as $key => $paiement) {
            $commande = $this->commande_m->get($paiement->commande_id);
            $paiements[$key]->token = $commande->datecommande;
        }
        $message = $periode;

        //echo'<pre>';die(print_r($paiements));
        $data['paiements'] = $paiements;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('paiement/print', $data, true);
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

    public function imprimerRecu($id){

        $paiement = $this->paiement_m->get($id);

        $commande = $this->vente_m->get($paiement->vente_id);

        $oldPaiement = $this->paiement_m->getPaiementGauche($commande->idvente, $id);

        if(!is_numeric($oldPaiement))
            $oldPaiement = 0;

        $data['oldPaiement'] = $oldPaiement;

        $data['paiement'] = $paiement;

        $data['commande'] = $commande;

        $returnArray = $this->vente_m->getArray($commande->idvente);

        //echo "<pre>";die(print_r($returnArray));
        $data['returnArray'] = $returnArray;

        $message = "Reçu de Paiement N° ".date("Y/m/", strtotime($paiement->datepaiement))."_".$paiement->idpaiement;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('paiement/printPaiement', $data, true);
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
            <table width="100%" style="padding-bottom: 100px">
                <tr>
                    <td width="30%" align="center">AGENT</td>
                    <td width="40%"></td>
                    <td width="30%" align="center">DEPOSANT</td>
                </tr>
                <tr>
                    <td width="30%" align="center">'. $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name .'</td>
                    <td></td>
                    <td width="30%" align="center">'. ucfirst($paiement->nompayeur) .'</td>
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

	public function imprimerListePaiement($id){


		$vente = $this->vente_m->get($id);

		if($vente->token == ''){
			redirect("accueil/index");
		}

		$returnArray = $this->vente_m->getArray($id);

		$data['returnArray'] = $returnArray;
		//echo "<pre>";die(print_r($returnArray));

		$message = "Liste des Paiements de la Facture FACT_".date('ymd', strtotime($vente->datevente)).'_'.$vente->idvente;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-P',
			'orientation' => 'P'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('paiement/printListePaiement', $data, true);
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

    private function getArray($id){

        $commande = $this->commande_m->get($id);

        $clients = $this->client_m->get($commande->client_id);

        if($commande->tva_id > 0){
            $tvas = $this->taxe_m->get($commande->tva_id);
            $tva = $tvas->pourcentage;
        }else{
            $tva = 0;
        }

        //$concerners = Concerner::where('commande_id', '=', $commande->id)->getQuery()->get()->all();
        $concerners = $this->detailcommande_m->getByForeignKey($commande->idcommande);

        $briqueArray = array();
        $i = 0;
        $liv = array();

        $totalRemise = 0;

        foreach ($concerners as $concerner) {
            $brique = $this->brique_m->get($concerner->brique_id);
            $briqueArray[$i]['Brique'] = $brique->designation;
            $briqueArray[$i]['CodeBrique'] = $brique->code;
            $briqueArray[$i]['IdBrique'] = $brique->idbrique;
            $briqueArray[$i]['Qte'] = $concerner->qte;
            $briqueArray[$i]['Pu'] = $concerner->pu;
            $briqueArray[$i]['Remise'] = $concerner->remise;
            $briqueArray[$i]['Etat'] = $concerner->etat;
            $briqueArray[$i]['NbreLivrer'] = $concerner->nbrelivrer;
            $briqueArray[$i]['IdDetail'] = $concerner->iddetailcommande;

            $totalRemise += ($concerner->qte * ($concerner->remise));

            if($concerner->nbrelivrer > 0)
                $liv[] = $concerner->iddetailcommande;

            $i++;
        }

        $livraisons = array();
        $m = 0;
        foreach ($liv as $item) {
            $items = $this->livraison_m->getByForeignKey($item);

            foreach ($items as $iteme) {
                if($iteme->etat == 1){
                    $vehicule = $this->vehicule_m->get($iteme->vehicule_id);
                    $agglos = $this->brique_m->get($this->detailcommande_m->get($iteme->iddetailcommande)->brique_id);

                    $livraisons[$m]['DateLivraison'] = date('d/m/Y', strtotime($iteme->datelivraison));
                    $livraisons[$m]['Vehicule'] = $vehicule->immatriculation;
                    $livraisons[$m]['Agglos'] = $agglos->code;
                    $livraisons[$m]['Qte'] = $iteme->qte;
                    $m++;
                }
            }
        }

        $paiements = $this->paiement_m->getByForeignKey($commande->idcommande);

        $sommeVersee = $this->paiement_m->sum($paiements, 'montant');



        $frais = $this->transport_m->get($commande->frais_id);


        $returnArray['Commande'] = $commande;
        if(is_object($frais))
            $mtantTransport = $frais->montant;
        else
            $mtantTransport = 0;

        $returnArray['FraisPort'] = $mtantTransport;
        $returnArray['Client'] = $clients;
        $returnArray['Tva'] = $tva;
        $returnArray['MontTVA'] = $commande->montant * $tva / 100;
        $returnArray['MontHT'] = $commande->montant;

        $totalRemise += $commande->remisefacture;

        $returnArray['TotalRemise'] = $totalRemise;

        $returnArray['MontTTC'] = $commande->montant + ($commande->montant * $tva / 100);
        $returnArray['TotalTTC'] = $commande->montant + ($commande->montant * $tva / 100) + $mtantTransport - $totalRemise;
        $returnArray['Briques'] = $briqueArray;
        $returnArray['Paiements'] = $paiements;
        $returnArray['MontantVerse'] = $sommeVersee;
        $returnArray['Reste'] = $returnArray['TotalTTC'] - $sommeVersee;
        $returnArray['Livraisons'] = $livraisons;

        //echo'<pre>'; die(print_r($returnArray));

        return $returnArray;
    }
}
