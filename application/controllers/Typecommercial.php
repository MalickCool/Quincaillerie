<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('client_m');
        $this->load->model('vente_m');
        $this->load->model('paiement_m');
        $this->load->model('commercial_m');
        $this->load->model('detailvente_m');
        $this->load->model('produit_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $clients = $this->client_m->get_all();
        $data['clients'] = $clients;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste des Clients';
        $data['page'] = "client/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $clients = $this->client_m->get_all();
        $data['clients'] = $clients;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter un Client';
        $data['page'] = "client/ajouter";
        $data['menu'] = 'commerciale';
        $data['script'] = 'global';
        $this->load->view($this->template, $data);
    }

    public function do_upload(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('nom','Nom du client','required');
        $this->form_validation->set_rules('phone','Contact du client','required');

        if($this->form_validation->run()){

            $datas = array(
                'nom' => $this->input->post('nom'),
                'adresse' => $this->input->post('adresse'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'type_client' => $this->input->post('type_client'),
                'ncc' => $this->input->post('ncc'),
                'token' => $this->input->post('token'),
            );

            $lastInsertedId = 0;

            if(!$this->client_m->exist($this->input->post('token'))) {
                $lastInsertedId = $this->client_m->add_item($datas);
            }
        }
        redirect('client/ajouter','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $client = $this->client_m->get($id);
        if($client->nom == ""){
            redirect("client/");
        }
        $clients = $this->client_m->get_all();
        $data['clients'] = $clients;

        $data['client'] = $client;

        $data['titre'] = 'Modifier le client '.$client->nom;
        $data['page'] = "client/modifier";
        $data['menu'] = 'commerciale';
		$data['script'] = 'global';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $item = $this->client_m->get($_POST['id']);
        if($item->nom == ""){
            redirect("client/");
        }

        $this->form_validation->set_rules('nom','Nom du client','required');
        $this->form_validation->set_rules('phone','Contact du client','required');

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }

            $datas = array(
                'nom' => $this->input->post('nom'),
                'adresse' => $this->input->post('adresse'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'type_client' => $this->input->post('type_client'),
                'etat' => $etat,
            );

            $this->client_m->update($item->idclient, $datas);
        }
        redirect('client/ajouter');
    }

    public function historique($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $client = $this->client_m->get($id);
        if($client->nom == ""){
            redirect("client/");
        }

        $achats = $this->client_m->getHistorique($id);

        $cmdArray = array();
        foreach ($achats as $achat) {
            $cmdArray[$achat->idvente] = $this->vente_m->getArray($achat->idvente);
        }

		//echo'<pre>'; die(print_r($cmdArray));

        $data['achats'] = $cmdArray;
        $data['clientId'] = $client->idclient;
        $data['titre'] = 'Historique des Achats de '.$client->nom;
        $data['texte'] = 'Historique des Achats de '.$client->nom;
        $data['page'] = "client/historique";
        $data['menu'] = 'commerciale';
        $this->load->view($this->template, $data);
    }

    public function imprimerHistorique($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $client = $this->client_m->get($id);
        if($client->nom == ""){
            redirect("client/");
        }

        $commandes = $this->client_m->getHistorique($id);

        $cmdArray = array();
        foreach ($commandes as $commande) {
            $cmdArray[$commande->idcommande] = self::getArray($commande->idcommande);
        }

        $data['commandes'] = $cmdArray;

        $data['message'] = 'Historique des commandes de '.$client->nom;
        $message = 'Historique des commandes de '.$client->nom;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('client/printHistorique', $data, true);
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

        $message = "Liste des Clients";

        $clients = $this->client_m->get_all();
        $data['clients'] = $clients;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('client/print', $data, true);
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

    public function detteClient(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$link = '';
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$periode = "Liste des Créances Client du ".date('d/m/Y');
				$debut = date('Y/m/d');
				$fin = date('Y/m/d');
				$link = 'today';
			}else{
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$periode = "Liste des Créances Client du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
				$link = strtotime($debut)."_".strtotime($fin);
			}
		}else{
			$periode = "Liste des Créances Client du ".date('d/m/Y');
			$debut = date('Y/m/d');
			$fin = date('Y/m/d');
			$link = 'today';
		}

		$supMessage = '';

		if(isset($_POST['client'])){
			if($_POST['client'] == 'all'){
				$theClient = null;
				$supMessage = 'Tous les Clients';
			} else{
				$theClient = $_POST['client'];
				$supMessage = $this->client_m->get($_POST['client'])->nom;
			}
		}else{
			$theClient = null;
			$supMessage = 'Tous les Clients';
		}

		$ventes = $this->vente_m->getDataByPeriode2($debut, $fin, $theClient);

		$cmdArray = array();

		foreach ($ventes as $vente) {
			if($vente->etat == 0){
				$tempCmd = $this->client_m->getArray($vente->idvente);

				if($tempCmd['TotalTTC'] != $tempCmd['MontantVerse']){
					$cmdArray[$vente->idvente] = $this->client_m->getArray($vente->idvente);
				}
			}
		}
		$clients = $this->client_m->get_all();

		$data['clients'] = $clients;

		$data['selectedClient'] = $theClient;

		$data['supMessage'] = $supMessage;

		$data['link'] = $link;
		//echo'<pre>'; die(print_r($cmdArray));

		$data['script'] = 'filter1';

		$data['dettes'] = $cmdArray;
		$data['titre'] = $periode;
		$data['page'] = "client/dettes";

		$data['menu'] = 'comptabilite';

		$this->load->view($this->template, $data);
	}



	public function imprimerDette(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$clients = $this->client_m->get_all();

		$cmdArray = array();

		foreach ($clients as $client) {
			$commandes = $this->client_m->getHistorique($client->idclient);

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
