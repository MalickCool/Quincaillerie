<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 10/07/2019
 * Time: 08:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Prix extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('produit_m');
        $this->load->model('typeclient_m');
        $this->load->model('prix_m');
    }

    public $template = 'templates/template';

    public function configurer($id)
    {
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $produit = $this->produit_m->get($id);

		if($produit == ""){
			redirect("produit/index");
		}
        $data['produit'] = $produit;

		$types = $this->typeclient_m->get_all();
		$data['types'] = $types;

		$priceArray = array();

		foreach ($types as $type) {
			$price = $this->prix_m->getPrice($id, $type->idType);

			$priceArray[$type->idType] = (!empty($price) AND isset($price[0])) ? $price[0]->prix : $produit->montant;
			//echo"<pre>"; die(print_r($hisPrice));
		}

		$data['priceArray'] = $priceArray;

		//echo"<pre>"; die(print_r($priceArray));

        $data['titre'] = 'Configurer Prix du produit: '.$produit->designation;
        $data['page'] = "prix/configurer";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

		//echo"<pre>"; die(print_r($_POST));

        $this->form_validation->set_rules('idProduit','Id du Produit','required');

		$types = $this->typeclient_m->get_all();

        if($this->form_validation->run()){

			$prices = $this->prix_m->getPrices($_POST['idProduit']);
			if(!empty($prices)){
				foreach ($prices as $price) {
					$datas = array(
						'etat' => 1,
						'deleted' => 1,
					);

					$this->prix_m->update($price->idPrix, $datas);
				}
			}

			foreach ($types as $type) {
				if(isset($_POST['Type_'.$type->idType])){
					$datas = array(
						'produit_id' => $this->input->post('idProduit'),
						'tyclient_id' => $type->idType,
						'prix' => $_POST['Type_'.$type->idType],
						'etat' => 0,
						'deleted' => 0,
					);

					$this->prix_m->add_item($datas);
				}
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
