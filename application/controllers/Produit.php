<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 10/07/2019
 * Time: 08:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('famille_m');
        $this->load->model('produit_m');
    }

    public $template = 'templates/template';

    public function index()
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $produits = $this->produit_m->getAllProductWithFamilly();
        $data['produits'] = $produits;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Liste des Produits';
        $data['page'] = "produit/liste";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function ajouter(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $produits = $this->produit_m->getAllProductWithFamilly();

        $familles = $this->famille_m->get_all();
        $data['produits'] = $produits;
        $data['familles'] = $familles;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Ajouter une nouveau Produit';
        $data['page'] = "produit/ajouter";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function do_upload(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('designation','Désignation du produit','required');
        $this->form_validation->set_rules('montant','Montant du produit','required');

        if($this->form_validation->run()){

            $datas = array(
                'designation' => $this->input->post('designation'),
                'montant' => $this->input->post('montant'),
                'montant_revendeur' => $this->input->post('montant_revendeur'),
                'information' => $this->input->post('information'),
                'idfamille' => $this->input->post('idfamille'),
                'masse' => $this->input->post('masse'),
                'etat' => 0,
                'seuil' => $this->input->post('seuil'),
                'token' => $this->input->post('token'),
            );

            if(!$this->produit_m->exist($this->input->post('token'))) {
                $this->produit_m->add_item($datas);
            }
        }
        redirect('produit/index','refresh');
    }

    public function edit($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $produit = $this->produit_m->get($id);
        if($produit->designation == ""){
            redirect("produit/");
        }
        $produits = $this->produit_m->getAllProductWithFamilly();
        $data['produits'] = $produits;

        $familles = $this->famille_m->get_all();
        $data['familles'] = $familles;

        $data['produit'] = $produit;

        $data['titre'] = 'Modifier le produit '.$produit->designation;
        $data['page'] = "produit/modifier";
        $data['menu'] = 'config';
        $this->load->view($this->template, $data);
    }

    public function update(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }


        $produit = $this->produit_m->get($_POST['id']);
        if($produit->designation == ""){
            redirect("produit/");
        }

        $this->form_validation->set_rules('designation','Désignation du produit','required');
        $this->form_validation->set_rules('montant','Montant du produit','required');

        if($this->form_validation->run()){

            $etat = 0;
            if(isset($_POST['etat'])){
                $etat = 1;
            }
            $datas = array(
                'designation' => $this->input->post('designation'),
                'montant' => $this->input->post('montant'),
                'montant_revendeur' => $this->input->post('montant_revendeur'),
                'information' => $this->input->post('information'),
                'idfamille' => $this->input->post('idfamille'),
				'masse' => $this->input->post('masse'),
				'seuil' => $this->input->post('seuil'),
                'etat' => $etat,
            );

            $this->produit_m->update($produit->idproduit, $datas);
        }
        redirect('produit/index','refresh');
    }

    public function imprimer(){

        $message = "Liste des articles enregistrés";

        $produits = $this->produit_m->getAllProductWithFamilly();
        $data['produits'] = $produits;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('produit/print', $data, true);
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
