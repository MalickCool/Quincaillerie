<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Versement extends CI_Controller {

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('versement_m');
		$this->load->model('depense_m');
	}

	public $template = 'templates/template';

	public function index(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}
		$link = '';
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$message = "Historique des Approvisionnements Caisse du ".date("d/m/Y");

				$debut = date('Y-m-d');
				$fin = date('Y-m-d');
				$link = 'today';
			}else{
				$debut = $_POST['debut'];
				$fin = $_POST['fin'];
				$link = $debut.'_'.$fin;

				$message = "Historique des Approvisionnements Caisse Du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
			}
		}else{
			$message = "Historique des Approvisionnements Caisse du ".date("d/m/Y");

			$debut = date('Y-m-d');
			$fin = date('Y-m-d');
			$link = 'today';
		}

		$versements = $this->versement_m->getAPeriodeListeVersement($debut, $fin);

		$data['versements'] = $versements;
		$data['message'] = $message;
		$data['link'] = $link;
		//echo"<pre>"; die(print_r($versements));
		$data['titre'] = $message;
		$data['script'] = "filter1";
		$data['page'] = "versement/liste";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function getADayVente($day){
		$paiements = $this->paiement_m->getByPeriode($day, $day, 'datepaiement');
		$somme = $this->paiement_m->sum($paiements, 'montant');
		return $somme;
	}

	public function getADayVersement($day){
		$somme = $this->versement_m->getADayVersement($day);
		return $somme;
	}

	public function getADayDepense($day){
		$somme = $this->depense_m->getADayDepense($day);
		return $somme;
	}

	public function getADayDepenseAchat($day){
		$somme = $this->depense_m->getADayDepense2($day, 1);
		return $somme;
	}

	public function getADayDepenseBanque($day){
		$somme = $this->depense_m->getADayDepense22($day, 2);
		return $somme;
	}

	public function getADayDepenseIntervention($day){
		$somme = $this->depense_m->getADayDepense22($day, 3);
		return $somme;
	}

	public function getADayDepenseExploitation($day){
		$somme = $this->depense_m->getADayDepense22($day, null);
		return $somme;
	}

	public function ajouter(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$versements = $this->versement_m->get_all();
		$data['depenses'] = $versements;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Ajouter un Versement';
		$data['page'] = "versement/ajouter";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function insert(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$this->form_validation->set_rules('motifversement','Desc Versement','required');
		$this->form_validation->set_rules('montant','Montant du Versement','required');

		//echo'<pre>'; die(print_r($reclamation));

		if($this->form_validation->run()){

			$datas = array(
				'motifversement' => $this->input->post('motifversement'),
				'dateversement' => date('Y-m-d'),
				'iduser' => $this->session->userdata('user_id'),
				'montant' => $this->input->post('montant'),
				'token' => $this->input->post('token'),
			);

			if(!$this->versement_m->exist($this->input->post('token'))) {
				$this->versement_m->add_item($datas);
			}
		}
		redirect('versement/index','refresh');
	}

	public function edit($id){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}


		$versement = $this->versement_m->get($id);
		if($versement->motifversement == ""){
			redirect("compte/");
		}
		$versements = $this->versement_m->get_all();
		$data['versements'] = $versements;

		$data['versement'] = $versement;

		$data['titre'] = 'Modifier un Versement';
		$data['page'] = "versement/modifier";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function update(){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$item = $this->versement_m->get($_POST['id']);
		if($item->motifversement == ""){
			redirect("versement/");
		}

		$this->form_validation->set_rules('motifversement','Desc Versement','required');
		$this->form_validation->set_rules('montant','Montant du Versement','required');

		//echo'<pre>'; die(print_r($_POST));

		if($this->form_validation->run()){

			$datas = array(
				'motifversement' => $this->input->post('motifversement'),
				'iduser' => $this->session->userdata('user_id'),
				'montant' => $this->input->post('montant'),
			);

			$this->versement_m->update($item->idversement, $datas);

		}
		redirect('versement/index','refresh');
		$data['titre'] = 'Ajouter un nouveau Versement';
		$data['page'] = "versement/ajouter";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function historique(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}
		$link = '';
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$message = "Mouvements de Caisse du ".date("d/m/Y");

				$debut = strtotime(date('Y-m-d'));
				$fin = strtotime(date('Y-m-d'));
				$link = 'today';
			}else{
				$debut = strtotime($_POST['debut']);
				$fin = strtotime($_POST['fin']);
				$link = $debut.'_'.$fin;

				$message = "Mouvements de Caisse du ".date("d/m/Y", $debut)." au ".date("d/m/Y", $fin);
			}
		}else{
			$message = "Mouvements de Caisse du ".date("d/m/Y");

			$debut = strtotime(date('Y-m-d'));
			$fin = strtotime(date('Y-m-d'));
			$link = 'today';
		}

		$k = 0;
		for ($currentDate = $debut; $currentDate <= $fin; $currentDate += (86400)) {
			$theDate = date('Y-m-d', $currentDate);
			$vente = self::getADayVente($theDate);

			if(!is_numeric($vente))
				$vente = 0;

			$versement = self::getADayVersement($theDate);
			if(!is_numeric($versement))
				$versement = 0;

			$depense = self::getADayDepense($theDate);
			if(!is_numeric($depense))
				$depense = 0;


			$depenseAchat = self::getADayDepenseAchat($theDate);
			if(!is_numeric($depenseAchat))
				$depenseAchat = 0;


			$depenseBanque = self::getADayDepenseBanque($theDate);

			$depBanque = array();
			foreach ($depenseBanque as $item) {
				$depBanque[$item->iddepense]['motif'] = $item->motifdepense;
				$depBanque[$item->iddepense]['somme'] = $item->montant;
			}

			$depenseExploitation = self::getADayDepenseExploitation($theDate);

			$depExp = array();
			foreach ($depenseExploitation as $item) {
				$depExp[$item->iddepense]['motif'] = $item->motifdepense;
				$depExp[$item->iddepense]['somme'] = $item->montant;
			}

			$depenseIntervention = self::getADayDepenseIntervention($theDate);

			$depInt = 0;
			foreach ($depenseIntervention as $item) {
				//$depInt[$item->iddepense]['motif'] = $item->motifdepense;
				$depInt += $item->montant;
			}

			//echo"<pre>"; die(print_r($depExp));

			$liste[$k]['Date'] = $theDate;
			$liste[$k]['Versement'] = $versement;

			$liste[$k]['Recette'] = $vente;

			$liste[$k]['Depense'] = $depense;

			$liste[$k]['DepenseAchat'] = $depenseAchat;
			$liste[$k]['DepenseBanque'] = $depBanque;
			$liste[$k]['DepenseExploitation'] = $depExp;
			$liste[$k]['DepenseIntervention'] = $depInt;

			$k++;
		}
		//echo"<pre>"; die(print_r($liste));
		foreach ($liste as $key => $item) {
			if($item['Versement'] == 0 AND $item['Recette'] == 0 AND $item['Depense'] == 0){
				unset($liste[$key]);
			}
		}

		//echo"<pre>"; die(print_r($liste));

		$data['listes'] = $liste;
		$data['message'] = $message;
		$data['periode'] = '';
		$data['link'] = $link;
		//echo"<pre>"; die(print_r($liste));
		$data['titre'] = $message;
		$data['script'] = "filter1";
		$data['page'] = "versement/historique";
		$data['menu'] = 'compte';
		$this->load->view($this->template, $data);
	}

	public function imprimerListe($param){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($param)){
			if($param == 'today'){
				$message = "Historique des Versements du ".date('d-m-Y');

				$debut = date('Y-m-d');
				$fin = date('Y-m-d');
			}else{
				$temp = explode('_', $param);

				$debut = $temp[0];
				$fin = $temp[1];

				$message = "Historique des Versements du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
			}
		}else{
			$message = "Historique des Versements du ".date('d-m-Y');

			$debut = date('Y-m-d');
			$fin = date('Y-m-d');
		}
		$versements = $this->versement_m->getAPeriodeListeVersement($debut, $fin);
		//echo"<pre>"; die(print_r($bigarray));
		$data['details'] = $versements;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'orientation' => 'L'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('versement/printHistorique', $data, true);
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

	public function imprimerMvt($param){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($param)){
			if($param == 'today'){
				$message = "Historique des mouvements de caisse du ".date('d-m-Y');

				$debut = strtotime(date('Y-m-d'));
				$fin = strtotime(date('Y-m-d'));
			}else{
				$temp = explode('_', $param);

				$debut = $temp[0];
				$fin = $temp[1];

				$message = "Historique des mouvements de caisse du ".date("d/m/Y", $debut)." au ".date("d/m/Y", $fin);
			}
		}else{
			$message = "Historique des mouvements de caisse du ".date('d-m-Y');

			$debut = strtotime(date('Y-m-d'));
			$fin = strtotime(date('Y-m-d'));
		}

		$k = 0;
		for ($currentDate = $debut; $currentDate <= $fin; $currentDate += (86400)) {
			$theDate = date('Y-m-d', $currentDate);
			$vente = self::getADayVente($theDate);

			if(!is_numeric($vente))
				$vente = 0;

			$versement = self::getADayVersement($theDate);
			if(!is_numeric($versement))
				$versement = 0;

			$depense = self::getADayDepense($theDate);
			if(!is_numeric($depense))
				$depense = 0;


			$depenseAchat = self::getADayDepenseAchat($theDate);
			if(!is_numeric($depenseAchat))
				$depenseAchat = 0;


			$depenseBanque = self::getADayDepenseBanque($theDate);

			$depBanque = array();
			foreach ($depenseBanque as $item) {
				$depBanque[$item->iddepense]['motif'] = $item->motifdepense;
				$depBanque[$item->iddepense]['somme'] = $item->montant;
			}

			$depenseExploitation = self::getADayDepenseExploitation($theDate);

			$depExp = array();
			foreach ($depenseExploitation as $item) {
				$depExp[$item->iddepense]['motif'] = $item->motifdepense;
				$depExp[$item->iddepense]['somme'] = $item->montant;
			}

			$depenseIntervention = self::getADayDepenseIntervention($theDate);

			$depInt = 0;
			foreach ($depenseIntervention as $item) {
				//$depInt[$item->iddepense]['motif'] = $item->motifdepense;
				$depInt += $item->montant;
			}

			//echo"<pre>"; die(print_r($depExp));

			$liste[$k]['Date'] = $theDate;
			$liste[$k]['Versement'] = $versement;

			$liste[$k]['Recette'] = $vente;

			$liste[$k]['Depense'] = $depense;

			$liste[$k]['DepenseAchat'] = $depenseAchat;
			$liste[$k]['DepenseBanque'] = $depBanque;
			$liste[$k]['DepenseExploitation'] = $depExp;
			$liste[$k]['DepenseIntervention'] = $depInt;

			$k++;
		}
		//echo"<pre>"; die(print_r($liste));
		foreach ($liste as $key => $item) {
			if($item['Versement'] == 0 AND $item['Recette'] == 0 AND $item['Depense'] == 0){
				unset($liste[$key]);
			}
		}

		//echo"<pre>"; die(print_r($liste));

		$data['details'] = $liste;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'orientation' => 'L'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('versement/printHistoriqueMvt', $data, true);
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
		$mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'. $message .'</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message.'.pdf', 'I');
	}


	public function point(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$link = date('Y-m-d');
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$message = "Point de la caisse à la date du ".date('d-m-Y');

				$date = date('Y-m-d');

				$link = $date;

				$bigArray[1]['depense'] = $this->depense_m->getDepenseGauche($date);
				$bigArray[1]['versement'] = $this->versement_m->getVersementGauche($date);
				$bigArray[1]['paiement'] = $this->paiement_m->getPaiementGauche0($date);

			}else{
				$date = $_POST['debut'];

				$link = $date;

				$message = "Point de la caisse à la date du ".date('d-m-Y', strtotime($date));

				$bigArray[1]['depense'] = $this->depense_m->getDepenseGauche($date);
				$bigArray[1]['versement'] = $this->versement_m->getVersementGauche($date);
				$bigArray[1]['paiement'] = $this->paiement_m->getPaiementGauche0($date);
			}
		}else{
			$message = "Point de la caisse à la date du ".date('d-m-Y');

			$date = date('Y-m-d');

			$link = $date;

			$bigArray[1]['depense'] = $this->depense_m->getDepenseGauche($date);
			$bigArray[1]['versement'] = $this->versement_m->getVersementGauche($date);
			$bigArray[1]['paiement'] = $this->paiement_m->getPaiementGauche0($date);
		}

		$data['listes'] = $bigArray;
		$data['message'] = $message;
		$data['link'] = $link;
		//echo"<pre>"; die(print_r($bigArray));
		$data['titre'] = $message;
		$data['script'] = "filter2";
		$data['page'] = "versement/point";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function imprimerPoint($param){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		if(isset($param)){
			$date = $param;

			$message = "Point de la caisse à la date du ".date('d-m-Y', strtotime($date));

			$bigArray[1]['depense'] = $this->depense_m->getDepenseGauche($date);
			$bigArray[1]['versement'] = $this->versement_m->getVersementGauche($date);
			$bigArray[1]['paiement'] = $this->paiement_m->getPaiementGauche0($date);
		}else{
			redirect("versement/point");
		}



		$data['details'] = $bigArray;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'orientation' => 'L'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('versement/printPoint', $data, true);
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
		$mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'. $message .'</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message.'.pdf', 'I');
	}

	public function banque(){
		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$link = '';
		if(isset($_POST['periode'])){
			if($_POST['periode'] == 'today'){
				$message = "Situation Banque du ".date("d/m/Y");

				$debut = strtotime(date('Y-m-d'));
				$fin = strtotime(date('Y-m-d'));
				$link = 'today';
			}else{
				$debut = strtotime($_POST['debut']);
				$fin = strtotime($_POST['fin']);
				$link = $debut.'_'.$fin;

				$message = "Situation Banque du ".date("d/m/Y", $debut)." au ".date("d/m/Y", $fin);
			}
		}else{
			$message = "Situation Banque du ".date("d/m/Y");

			$debut = strtotime(date('Y-m-d'));
			$fin = strtotime(date('Y-m-d'));
			$link = 'today';
		}

		$listes = $this->depense_m->getSituationBanque($debut, $fin);

		//echo"<pre>"; die(print_r($listes));

		$data['depenses'] = $listes;

		$data['link'] = $link;

		//echo"<pre>"; die(print_r($depenses));
		$data['titre'] = $message;
		$data['script'] = "filter1";
		$data['page'] = "depense/situation";
		$data['menu'] = 'caisse';
		$this->load->view($this->template, $data);
	}

	public function imprimerSituation($params){

		if(!$this->ion_auth->logged_in()){
			redirect("auth/login");
		}

		$message = "";

		if(isset($params)){
			if($params == 'today'){
				$message = "Liste des Versements Banque du ".date('d/m/Y');

				$depenses = $this->depense_m->getADayListeDepense(date('Y-m-d'));
			}else{
				$temp = explode("_", $params);

				$debut = $temp[0];
				$fin = $temp[1];

				$message = "Liste des Versements Banque du ".date("d/m/Y", $debut)." au ".date("d/m/Y", $fin);
			}
		}else{
			$debut = strtotime(date('Y-m-d'));
			$fin = strtotime(date('Y-m-d'));

			$message = "Liste des Versements Banque du ".date('d/m/Y');
		}

		$depenses = $this->depense_m->getSituationBanque($debut, $fin);

		//echo"<pre>"; die(print_r($depenses));


		$data['depenses'] = $depenses;

		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',

			'orientation' => 'L'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('depense/printSituation', $data, true);
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
		$mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">'. $message .'</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message.'.pdf', 'I');
	}
}
