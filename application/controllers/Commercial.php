<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Commercial extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('commercial_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $commerciaux = $this->commercial_m->get_all();
        $data['commerciaux'] = $commerciaux;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste des commerciaux';
        $data['page'] = "Commercial/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $commerciaux = $this->commercial_m->get_all();
        $data['commerciaux'] = $commerciaux;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter un Commercial';
        $data['page'] = "Commercial/ajouter";
        $data['menu'] = 'commerciale';
        $this->load->view($this->template, $data);
    }

    public function do_upload(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('nom','Nom du Commercial','required');
        $this->form_validation->set_rules('phone','Contact du Commercial','required');

        if($this->form_validation->run()){

            $datas = array(
                'nom' => $this->input->post('nom'),
                'phone' => $this->input->post('phone'),
                'token' => $this->input->post('token'),
            );

            $lastInsertedId = 0;

            if(!$this->commercial_m->exist($this->input->post('token'))) {
                $lastInsertedId = $this->commercial_m->add_item($datas);
            }
        }
        redirect('Commercial/ajouter','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $commercial = $this->commercial_m->get($id);
        if($commercial->nom == ""){
            redirect("Commercial/");
        }
        $commerciaux = $this->commercial_m->get_all();
        $data['commerciaux'] = $commerciaux;

        $data['commercial'] = $commercial;

        $data['titre'] = 'Modifier le Commercial '.$commercial->nom;
        $data['page'] = "Commercial/modifier";
        $data['menu'] = 'commerciale';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $item = $this->commercial_m->get($_POST['id']);
        if($item->nom == ""){
            redirect("Commercial/");
        }

        $this->form_validation->set_rules('nom','Nom du Commercial','required');
        $this->form_validation->set_rules('phone','Contact du Commercial','required');

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }

            $datas = array(
                'nom' => $this->input->post('nom'),
                'phone' => $this->input->post('phone'),
                'etat' => $etat,
            );

            $this->commercial_m->update($item->idcommercial, $datas);
        }
        redirect('Commercial/ajouter');
    }

    public function historique($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $commercial = $this->commercial_m->get($id);
        if($commercial->nom == ""){
            redirect("Commercial/");
        }

        $commandes = $this->commercial_m->getHistorique($id);

        $cmdArray = array();
        foreach ($commandes as $commande) {
            $cmdArray[$commande->idcommande] = self::getArray($commande->idcommande);
        }

        //echo'<pre>'; die(print_r($cmdArray));

        $data['commandes'] = $cmdArray;
        $data['clientId'] = $commercial->idclient;
        $data['titre'] = 'Historique des commandes de '.$commercial->nom;
        $data['texte'] = 'Historique des commandes de '.$commercial->nom;
        $data['page'] = "Commercial/historique";
        $data['menu'] = 'commerciale';
        $this->load->view($this->template, $data);
    }

    public function imprimerHistorique($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $commercial = $this->commercial_m->get($id);
        if($commercial->nom == ""){
            redirect("Commercial/");
        }

        $commandes = $this->commercial_m->getHistorique($id);

        $cmdArray = array();
        foreach ($commandes as $commande) {
            $cmdArray[$commande->idcommande] = self::getArray($commande->idcommande);
        }

        $data['commandes'] = $cmdArray;

        $data['message'] = 'Historique des commandes de '.$commercial->nom;
        $message = 'Historique des commandes de '.$commercial->nom;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('commercial/printHistorique', $data, true);
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

    public function imprimer(){

        $message = "Liste des commerciaux";

        $commerciaux = $this->commercial_m->get_all();
        $data['commerciaux'] = $commerciaux;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('commercial/print', $data, true);
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
		$mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'. $message .'</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message.'.pdf', 'I');
    }

    private function getArray($id){

        $commande = $this->commande_m->get($id);

        $commerciaux = $this->commercial_m->get($commande->client_id);

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

            //echo'<pre>'; die(print_r($concerner));
            if($concerner->nbrelivrer > 0){
                $liv[] = $concerner->iddetailcommande;
            }

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
        $returnArray['Commercial'] = $commerciaux;
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

    public function detteCommercial(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$commerciaux = $this->commercial_m->get_all();

		$cmdArray = array();

		foreach ($commerciaux as $commercial) {
			$commandes = $this->commercial_m->getHistorique($commercial->idclient);

			foreach ($commandes as $commande) {
				if($commande->etat == 1){
					$tempCmd = self::getArray($commande->idcommande);

					if($tempCmd['TotalTTC'] != $tempCmd['MontantVerse']){
						$cmdArray[$commande->idcommande] = self::getArray($commande->idcommande);
					}
				}

			}
		}

		//echo'<pre>'; die(print_r($cmdArray));

		$data['commandes'] = $cmdArray;
		$data['titre'] = 'Liste des dettes Client';
		$data['texte'] = 'Liste des dettes Client ';
		$data['page'] = "client/dettes";
		$data['menu'] = 'commerciale';
		$this->load->view($this->template, $data);
	}



	public function imprimerDette(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$commerciaux = $this->commercial_m->get_all();

		$cmdArray = array();

		foreach ($commerciaux as $commercial) {
			$commandes = $this->commercial_m->getHistorique($commercial->idclient);

			foreach ($commandes as $commande) {
				if($commande->etat == 1){
					$tempCmd = self::getArray($commande->idcommande);

					if($tempCmd['TotalTTC'] != $tempCmd['MontantVerse']){
						$cmdArray[$commande->idcommande] = self::getArray($commande->idcommande);
					}
				}

			}
		}

		//echo'<pre>'; die(print_r($cmdArray));

		$data['commandes'] = $cmdArray;

		$message = 'Liste des dettes Client';

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',

			'orientation' => 'L'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('client/printDette', $data, true);
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
		$mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'. $message .'</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message.'.pdf', 'I');
	}
}
