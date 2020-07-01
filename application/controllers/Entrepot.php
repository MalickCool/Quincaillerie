<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Entrepot extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('entrepot_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $entrepots = $this->entrepot_m->get_all();
        $data['entrepots'] = $entrepots;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste des entrepots enregistré';
        $data['page'] = "entrepot/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $entrepots = $this->entrepot_m->get_all();
        $data['entrepots'] = $entrepots;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter un Magasin';
        $data['page'] = "entrepot/ajouter";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('designation','Désignation de l\'entrepôt ','required');

        //echo'<pre>'; die(print_r($reclamation));

        if($this->form_validation->run()){

            $datas = array(
                'designation' => $this->input->post('designation'),
                'details' => $this->input->post('details'),
                'datecreation' => date('Y-m-d'),
                'etat' => 0,
                'iduser' => $this->session->userdata('user_id'),
                'token' => $this->input->post('token'),
            );

            if(!$this->entrepot_m->exist($this->input->post('token'))) {
                $this->entrepot_m->add_item($datas);
				$this->session->set_flashdata('message', "Magasin crée avec succès");
            }else{
				$this->session->set_flashdata('message', "Echec lors de la création du Magasin");
			}
        }else{
			$this->session->set_flashdata('message', "Echec lors de la création du Magasin");
		}
        redirect('entrepot/ajouter','refresh');
        $data['title'] = 'Ajouter un Entrepot';
        $data['main_content'] = 'entrepot/ajouter';
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $entrepot = $this->entrepot_m->get($id);
        if($entrepot->designation == ""){
            redirect("entrepot/");
        }
        $entrepots = $this->entrepot_m->get_all();
        $data['entrepots'] = $entrepots;

        $data['entrepot'] = $entrepot;

        $data['titre'] = 'Modifier l\'entrepot '.$entrepot->designation;
        $data['page'] = "entrepot/modifier";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $item = $this->entrepot_m->get($_POST['id']);
        if($item->designation == ""){
            redirect("entrepot/ajouter");
        }

        $this->form_validation->set_rules('designation','Désignation du fournisseur','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
                'designation' => $this->input->post('designation'),
                'details' => $this->input->post('details'),
                'datecreation' => date('Y-m-d'),
                'iduser' => $this->session->userdata('user_id'),
                'etat' => $etat,
            );

            $this->entrepot_m->update($item->identrepot, $datas);
			$this->session->set_flashdata('message', "Magasin Modifié avec succès");
        }else{
			$this->session->set_flashdata('message', "Echec lors de la modification du Magasin");
		}
        redirect('entrepot/ajouter','refresh');
    }

    public function imprimer(){

        $message = "Liste des lieux de stockage enregistrés";

        $entrepots = $this->entrepot_m->get_all();
        $data['entrepots'] = $entrepots;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('entrepot/print', $data, true);
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
