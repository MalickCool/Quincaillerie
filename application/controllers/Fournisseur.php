<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Fournisseur extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('fournisseur_m');
        $this->load->model('depense_m');
        $this->load->model('boncommande_m');
        $this->load->model('detailsbc_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $fournisseurs = $this->fournisseur_m->get_all();
        $data['fournisseurs'] = $fournisseurs;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste des Fournisseurs';
        $data['page'] = "fournisseur/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $fournisseurs = $this->fournisseur_m->get_all();
        $data['fournisseurs'] = $fournisseurs;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter un Fournisseur';
        $data['page'] = "fournisseur/ajouter";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('designation','Désignation du fournisseur','required');
        $this->form_validation->set_rules('contact','contact du fournisseur','required');

        //echo'<pre>'; die(print_r($reclamation));

        if($this->form_validation->run()){

            $datas = array(
                'designation' => $this->input->post('designation'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'situation' => $this->input->post('situation'),
                'etat' => 0,
                'token' => $this->input->post('token'),

                'nomRep' => $this->input->post('nomRep'),
                'fonction' => $this->input->post('fonction'),
                'contactPersonnel' => $this->input->post('contactPersonnel'),
                'contactProfessionnel' => $this->input->post('contactProfessionnel'),
                'observation' => $this->input->post('observation'),

                'ncc' => $this->input->post('ncc'),
                'rccm' => $this->input->post('rccm'),
                'ncb' => $this->input->post('ncb'),

                'echeance' => $this->input->post('echeance'),
            );

            if(!$this->fournisseur_m->exist($this->input->post('token'))) {
                $this->fournisseur_m->add_item($datas);
				$this->session->set_flashdata('message', "Fournisseur crée avec succès");
            }else{
				$this->session->set_flashdata('message', "Echec lors de la création du Fournisseur");
			}
        }else{
			$this->session->set_flashdata('message', "Echec lors de la création du Fournisseur");
		}
        redirect('fournisseur/ajouter','refresh');
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
            redirect("fournisseur/ajouter");
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

				'echeance' => $this->input->post('echeance'),
            );

            $this->fournisseur_m->update($item->idfournisseur, $datas);
			$this->session->set_flashdata('message', "Fournisseur Modifié avec succès");
        }else{
			$this->session->set_flashdata('message', "Echec lors de la modification du Fournisseur");
		}
        redirect('fournisseur/ajouter','refresh');
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
