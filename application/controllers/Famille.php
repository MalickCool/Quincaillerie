<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 06/04/2020
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Famille extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('famille_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $familles = $this->famille_m->get_all();
        $data['familles'] = $familles;
        $data['titre'] = 'Les Familles de Produit';
        $data['page'] = "famille/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $familles = $this->famille_m->get_all();
        $data['familles'] = $familles;
        $data['titre'] = 'Ajouter une Famille de Produit';
        $data['page'] = "famille/ajouter";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('libelle','Désignation de la famille','required');

        if($this->form_validation->run()){

            $datas = array(
                'libelle' => $this->input->post('libelle'),
                'etat' => 0,
                'token' => $this->input->post('token'),
            );

            if(!$this->famille_m->exist($this->input->post('token'))) {
                $this->famille_m->add_item($datas);
				$this->session->set_flashdata('message', "Famille créée avec succès");
            }else{
				$this->session->set_flashdata('message', "Echec lors de la création de la Famille");
			}
        }else{
			$this->session->set_flashdata('message', "Echec lors de la création de la Famille");
		}
        redirect('famille/ajouter','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $famille = $this->famille_m->get($id);
        if($famille->libelle == ""){
            redirect("famille/");
        }
        $familles = $this->famille_m->get_all();
        $data['familles'] = $familles;

        $data['famille'] = $famille;

        $data['titre'] = 'Modifier un famille '.$famille->libelle;
        $data['page'] = "famille/modifier";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $famille = $this->famille_m->get($_POST['id']);
        if($famille->libelle == ""){
            redirect("famille/");
        }

        $this->form_validation->set_rules('libelle','Désignation de la famille','required');

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
                'libelle' => $this->input->post('libelle'),
                'etat' => $etat,
            );

            $this->famille_m->update($famille->idfamille, $datas);
			$this->session->set_flashdata('message', "Famille Modifiée avec succès");
        }else{
			$this->session->set_flashdata('message', "Echec lors de la modification de la Famille");
		}
        redirect('famille/ajouter','refresh');
    }

    public function getProducts(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $item = $this->famille_m->get($_POST['famille']);
        if($item->libelle == ""){
            $products = '';
        }else{
            $products = $this->famille_m->getProducts($item->idfamille);
        }

        print_r(json_encode($products));
    }

    public function imprimer(){

        $message = "Liste des Familles enregistrées";

        $familles = $this->famille_m->get_all();
        $data['familles'] = $familles;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('famille/print', $data, true);
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
