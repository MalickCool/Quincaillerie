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
            );

            if(!$this->fournisseur_m->exist($this->input->post('token'))) {
                $this->fournisseur_m->add_item($datas);
            }
        }
        redirect('fournisseur/index','refresh');
        $data['title'] = 'Ajouter un Fournisseur';
        $data['main_content']='fournisseur/index';
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
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
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('fournisseur/print', $data, true);
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
