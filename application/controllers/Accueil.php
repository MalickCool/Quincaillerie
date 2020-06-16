<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('actioncaisse_m');
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

		$action = '';
		if(isset($_SESSION['caisse'])){
			$actionCaisse = $this->actioncaisse_m->arretCaisseDidExists($_SESSION['caisse']->idcaisse);

			if(!$actionCaisse){
				$action = 'ouverture';
				if(isset($_SESSION['arretCaisse']))
					unset($_SESSION['arretCaisse']);

			}else{
				$arretCaisse = $this->actioncaisse_m->getArretCaisse($_SESSION['caisse']->idcaisse);
				$arretCaisse = $arretCaisse[0];

				if($arretCaisse->etat == 0){
					$action = 'réouverture';
				}else{
					$action = 'Annuler';
				}

				if(isset($_SESSION['arretCaisse']))
					unset($_SESSION['arretCaisse']);

				$_SESSION['arretCaisse'] = $arretCaisse;
			}
		}else{
			redirect("auth/login");
		}

		//echo"<pre>"; die(print_r($_SESSION));

		$data['page'] = "welcome_message";
		$data['menu'] = 'home';
		$data['titre'] = 'Bienvenu';
		$data['script'] = 'filter1';

		$this->load->view($this->template, $data);
	}
}
