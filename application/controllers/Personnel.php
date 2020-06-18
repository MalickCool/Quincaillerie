<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Personnel extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('personnel_m');
        $this->load->model('entrepot_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $personnels = $this->personnel_m->get_all();
        $data['personnels'] = $personnels;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste du Personnel enregistré';
        $data['page'] = "personnel/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

		$personnels = $this->personnel_m->get_all();
		$data['personnels'] = $personnels;

		$magasins = $this->entrepot_m->getActivated();
		$data['magasins'] = $magasins;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter Personnel';
        $data['page'] = "personnel/ajouter";
        $data['menu'] = 'rh';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('nom', 'nom','required');
        $this->form_validation->set_rules('prenom', 'prenom','required');
        $this->form_validation->set_rules('contact', 'contact','required');
        $this->form_validation->set_rules('fonction', 'fonction','required');

        //echo'<pre>'; die(print_r($reclamation));

        if($this->form_validation->run()){

            $datas = array(
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'contact' => $this->input->post('contact'),
                'statut' => $this->input->post('statut'),
                'magasin_id' => $this->input->post('magasin_id'),
                'fonction' => $this->input->post('fonction'),
                'etat' => 0,
                'token' => $this->input->post('token'),
            );

            if(!$this->personnel_m->exist($this->input->post('token'))) {
                $this->personnel_m->add_item($datas);
            }
        }
        redirect('personnel/ajouter','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $personnel = $this->personnel_m->get($id);
        if($personnel->nom == ""){
            redirect("personnel/ajouter");
        }
		$personnels = $this->personnel_m->get_all();
        $data['personnels'] = $personnels;

        $data['personnel'] = $personnel;

		$magasins = $this->entrepot_m->getActivated();
		$data['magasins'] = $magasins;

        $data['titre'] = 'Modifier Personnel '.$personnel->nom." ".$personnel->prenom;
        $data['page'] = "personnel/modifier";
        $data['menu'] = 'rh';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $item = $this->personnel_m->get($_POST['id']);
        if($item->nom == ""){
            redirect("personnel/");
        }

		$this->form_validation->set_rules('nom', 'nom','required');
		$this->form_validation->set_rules('prenom', 'prenom','required');
		$this->form_validation->set_rules('contact', 'contact','required');
		$this->form_validation->set_rules('fonction', 'fonction','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
				'nom' => $this->input->post('nom'),
				'prenom' => $this->input->post('prenom'),
				'contact' => $this->input->post('contact'),
				'statut' => $this->input->post('statut'),
				'magasin_id' => $this->input->post('magasin_id'),
				'fonction' => $this->input->post('fonction'),
				'token' => $this->input->post('token'),
                'etat' => $etat,
            );

            $this->personnel_m->update($item->idpersonnel, $datas);
        }
        redirect('personnel/ajouter','refresh');
    }

    public function imprimer(){

        $message = "Liste du Personnel";

		$magasins = $this->entrepot_m->getActivated();

		$personnels = array();

		foreach ($magasins as $magasin) {
			$personns = $this->personnel_m->getAllForPrint($magasin->identrepot);
			if(!empty($personns))
				$personnels[$magasin->designation] = $personns;
		}

		//echo'<pre>'; die(print_r($personnels));

        $data['magasins'] = $personnels;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('personnel/print', $data, true);
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
}
