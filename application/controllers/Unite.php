<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 01/07/2020
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Unite extends CI_Controller {

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('unite_m');
	}

	public $template = 'templates/template';

	public function index()
	{
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}
		$unites = $this->unite_m->get_all();

		$array = array();
		$i = 0;
		foreach ($unites as $unite) {
			$array[$i]['idunite'] = $unite->idunite;
			$array[$i]['designation'] = $unite->designation;
			$array[$i]['symbole'] = $unite->symbole;
			$array[$i]['valeur'] = $unite->valeur;
			$array[$i]['etat'] = $unite->etat;

			if($unite->parent == 0){
				$array[$i]['parent'] = "-";
				$array[$i]['idparent'] = 0;
			}else{
				$array[$i]['parent'] = $this->unite_m->get($unite->parent)->designation;
				$array[$i]['idparent'] = $unite->parent;
			}
			$i++;
		}

		$data['unites'] = $array;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Liste';
		$data['page'] = "unite/liste";
		$data['menu'] = 'unite';
		$this->load->view($this->template, $data);
	}

	public function ajouter(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$unites2 = $this->unite_m->getRootUnities();
		$unites = $this->unite_m->get_all();
		$array = array();
		$i = 0;
		foreach ($unites as $unite) {
			$array[$i]['idunite'] = $unite->idunite;
			$array[$i]['designation'] = $unite->designation;
			$array[$i]['valeur'] = $unite->valeur;
			$array[$i]['etat'] = $unite->etat;

			if($unite->parent == 0){
				$array[$i]['parent'] = "-";
				$array[$i]['idparent'] = 0;
			}else{
				$array[$i]['parent'] = $this->unite_m->get($unite->parent)->designation;
				$array[$i]['idparent'] = $unite->parent;
			}
			$i++;
		}

		$data['unites'] = $array;
		$data['unites2'] = $unites2;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Ajouter une nouvelle unité de mesure';
		$data['page'] = "unite/ajouter";
		$data['menu'] = 'unite';
		$this->load->view($this->template, $data);
	}

	public function insert(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$this->form_validation->set_rules('designation','Désignation de l\'unité','required');
		$this->form_validation->set_rules('valeur','Valeur de l\'unité','required');

		//echo'<pre>'; die(print_r($reclamation));

		if($this->form_validation->run()){

			$datas = array(
				'designation' => $this->input->post('designation'),
				'parent' => $this->input->post('parent'),
				'valeur' => $this->input->post('valeur'),
				'etat' => 0,
				'token' => $this->input->post('token'),
			);

			if(!$this->unite_m->exist($this->input->post('token'))) {
				$this->unite_m->add_item($datas);
				$this->session->set_flashdata('message', "Unité ajoutée avec succès");
			}else{
				$this->session->set_flashdata('message', "Echec lors de l'ajout de l'unité");
			}
		}else{
			$this->session->set_flashdata('message', "Echec lors de l'ajout de l'unité");
		}
		redirect('unite/ajouter','refresh');
		$data['title'] = 'Ajouter une unité de mesure';
		$data['main_content'] = 'unite/index';
		$data['menu'] = 'unite';
		$this->load->view($this->template, $data);
	}

	public function edit($id){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}


		$unity = $this->unite_m->get($id);
		if($unity->designation == ""){
			redirect("unite/");
		}

		$unites2 = $this->unite_m->getRootUnities();
		$unites = $this->unite_m->get_all();
		$array = array();
		$i = 0;
		foreach ($unites as $unite) {
			$array[$i]['idunite'] = $unite->idunite;
			$array[$i]['designation'] = $unite->designation;
			$array[$i]['symbole'] = $unite->symbole;
			$array[$i]['valeur'] = $unite->valeur;
			$array[$i]['etat'] = $unite->etat;

			if($unite->parent == 0){
				$array[$i]['parent'] = "-";
			}else{
				$array[$i]['parent'] = $this->unite_m->get($unite->parent)->designation;
			}
			$i++;
		}

		$data['unites'] = $array;
		$data['unites2'] = $unites2;

		$data['unite'] = $unity;
		$data['titre'] = 'Modifier l\'unité de mesure '.$unite->designation;
		$data['page'] = "unite/modifier";
		$data['menu'] = 'unite';
		$this->load->view($this->template, $data);
	}

	public function update(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}


		$item = $this->unite_m->get($_POST['id']);
		if($item->designation == ""){
			redirect("unite/");
		}

		$this->form_validation->set_rules('designation','Désignation de l\'unité','required');
		$this->form_validation->set_rules('valeur','Valeur de l\'unité','required');

		//echo'<pre>'; die(print_r($_POST));

		if($this->form_validation->run()){

			$etat = 0;
			if(isset($_POST['etat'])){
				$etat = 1;
			}
			$datas = array(
				'designation' => $this->input->post('designation'),
				'parent' => $this->input->post('parent'),
				'valeur' => $this->input->post('valeur'),
				'etat' => $etat,
			);

			$this->unite_m->update($item->idunite, $datas);
			$this->session->set_flashdata('message', "Unité Modifiée avec succès");
		}else{
			$this->session->set_flashdata('message', "Echec lors de la modification de l'Unité");
		}
		redirect('unite/ajouter','refresh');
	}
}
