<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {

	public function __construct($value = "")
	{
		parent::__construct();
		//$this->load->model('depense_m');
	}

	public $template = 'templates/template';

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$data['page'] = "welcome_message";
		$data['menu'] = 'home';
		$data['titre'] = 'Bienvenu ';
		$data['script'] = 'filter1';
		$this->load->view($this->template, $data);
	}
}
