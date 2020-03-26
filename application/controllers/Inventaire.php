<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaire extends CI_Controller {

    public function __construct($value = "")
    {
        parent::__construct();
        $this->load->model('inventaire_m');
        $this->load->model('produit_m');
        $this->load->model('entrepot_m');
        $this->load->model('stock_m');
        $this->load->model('detailinventaire_m');
    }

    public $template = 'templates/template';

    public function index(){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $link = '';
        if(isset($_POST['periode'])){
            if($_POST['periode'] == 'today'){
                $periode = "Historique au ".date("d/m/Y");

                $inventaires = $this->inventaire_m->getTodayInventairesWithDetails();

                $link = 'today';
            }else{
                $debut = $_POST['debut'];

                $fin = $_POST['fin'];

                $periode = "Historique des Inventaires du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));

                $inventaires = $this->inventaire_m->getInventairesWithDetailsByPeriode($debut, $fin);

                $link = $debut.'_'.$fin;
            }
        }else{
            $periode = "Historique au ".date("d/m/Y");
            $inventaires = $this->inventaire_m->getTodayInventairesWithDetails();
            $link = 'today';
        }

        $data['inventaires'] = $inventaires;
        $data['link'] = $link;
        //echo"<pre>"; die(print_r($inventaires));
        $data['titre'] = $periode;
        $data['page'] = "inventaire/historique";
        $data['menu'] = 'edition';
        $data['script'] = "filter1";
        $this->load->view($this->template, $data);
    }

    public function entrepot(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $entrepots = $this->entrepot_m->getActivated();
        $data['entrepots'] = $entrepots;
        //echo"<pre>"; die(print_r($types));
        $data['titre'] = 'Selection d\'un entrepot pour l\'inventaire';
        $data['page'] = "inventaire/select";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function ajouter($id){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $produits = $this->produit_m->getActivated();

        if(isset($id)){
            $entrepot = $this->entrepot_m->get($id);

            if($entrepot->designation == ""){
                redirect("inventaire/entrepot");
            }

            $stocks = array();
            foreach ($produits as $produit) {
                $stocks[$produit->idproduit]['id'] = $produit->idproduit;
                $stocks[$produit->idproduit]['designation'] = $produit->designation;
                $qte = $this->stock_m->getProductsByEntrepotWithDetails($produit->idproduit, $id);
                if(!is_numeric($qte))
                    $qte = 0;
                $stocks[$produit->idproduit]['Qte'] = $qte;
            }
        }else{
            redirect("inventaire/entrepot");
        }

        $data['stocks'] = $stocks;
        $data['entrepot'] = $entrepot;
        //echo"<pre>"; die(print_r($data));
        $data['titre'] = 'Nouvel Inventaire du stock pour le lieu de stockage '.$entrepot->designation;
        $data['page'] = "inventaire/liste";
        $data['menu'] = 'stock';
        $this->load->view($this->template, $data);
    }

    public function insert(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $this->form_validation->set_rules('entrepot','Entrepot','required');

        //echo'<pre>'; die(print_r($_POST));

        if($this->form_validation->run()){

            $datas = array(
                'identrepot' => $this->input->post('entrepot'),
                'dateinventaire' => date('Y-m-d'),
                'heureinventaire' => date('H:i:s'),
                'iduser' => $this->session->userdata('user_id'),
                'token' => $this->input->post('token'),
            );

            $idEntrepot = $this->input->post('entrepot');

            if(!$this->inventaire_m->exist($this->input->post('token'))) {
                $idInventaire = $this->inventaire_m->add_item($datas);
                $new = $_POST['new'];
                foreach ($_POST['old'] as $key => $item) {

                    $datax = array(
                        'idproduit' => $key,
                        'qteavant' => $item,
                        'qteapres' => $new[$key],
                        'idinventaire' => $idInventaire,
                    );

                    $this->detailinventaire_m->insert($datax);
                    if($item != $new[$key]){
                        $lines = $this->stock_m->getProductsLineByEntrepotWithDetails($key, $idEntrepot);

                        if(!empty($lines)){
                            if ($item > $new[$key]){ // Nous devons retirer du Stock
                                $aRetirer = $item - $new[$key];
                                foreach ($lines as $line) {
                                    if($line->qte > 0){
                                        if($aRetirer > 0){
                                            if($aRetirer >= $line->qte){
                                                $aRetirer -= $line->qte;
                                                $dataz = array(
                                                    'qte' => 0,
                                                );
                                                $this->stock_m->update($line->idstock ,$dataz);
                                            }else{
                                                $nvxQte = $line->qte - $aRetirer;
                                                $aRetirer = 0;

                                                $dataz = array(
                                                    'qte' => $nvxQte,
                                                );
                                                $this->stock_m->update($line->idstock ,$dataz);
                                            }

                                        }
                                    }
                                }
                            }else{ // Nous devons ajouter du Stock

                                $ajouter = $new[$key] - $item;
                                foreach ($lines as $line) {
                                    if($ajouter > 0){
                                        $nvxQte = $line->qte + $ajouter;
                                        $ajouter = 0;

                                        $dataz = array(
                                            'qte' => $nvxQte,
                                        );
                                        $this->stock_m->update($line->idstock ,$dataz);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        redirect('stock/entrepot','refresh');
    }

    public function afficher($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $inventaire = $this->inventaire_m->get($id);

        if($inventaire->token == ''){
            redirect("inventaire/index");
        }

        $lignes = $this->detailinventaire_m->getAllByInventaireId($inventaire->idinventaire);

        $entrepots = $this->entrepot_m->get($inventaire->identrepot);

        $data['inventaire'] = $inventaire;
        $data['entrepot'] = $entrepots;
        $data['details'] = $lignes;

        $data['titre'] = 'Détail Inventaire N°'.$inventaire->idinventaire." du ".date('d-m-Y', strtotime($inventaire->dateinventaire));
        $data['page'] = "inventaire/detail";
        $data['menu'] = 'edition';
        $this->load->view($this->template, $data);
    }

    public function historiquedetaille(){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $link = '';
		$lieux = null;
        if(isset($_POST['periode'])){
            if($_POST['periode'] == 'today'){

                if($_POST['lieux'] == 'all'){
                    $lieux = null;
                    $data['stockage'] = "Tous les Magasins";

                    $link = 'today_all';
                }else{
                    $lieux = $_POST['lieux'];
                    $data['stockage'] = $this->entrepot_m->get($_POST['lieux'])->designation;

                    $link = 'today_'.$_POST['lieux'];
                }

                $periode = "Historique au ".date("d/m/Y");

                $inventaires = $this->inventaire_m->getTodayInventairesWithDetails2($lieux);
            }else{
                $debut = $_POST['debut'];

                $fin = $_POST['fin'];

                if($_POST['lieux'] == 'all'){
                    $lieux = null;
                    $data['stockage'] = "Tous les Magasins";

                    $link = $debut.'x'.$fin.'_all';
                }else{
                    $lieux = $_POST['lieux'];
                    $data['stockage'] = $this->entrepot_m->get($_POST['lieux'])->designation;

                    $link = $debut.'x'.$fin.'_'.$_POST['lieux'];
                }

                $periode = "Historique du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));

                $inventaires = $this->inventaire_m->getInventairesWithDetailsByPeriode2($debut, $fin, $lieux);
            }
        }else{
            $data['stockage'] = "Tous les Magasins";
            $periode = "Historique au ".date("d/m/Y");
            $inventaires = $this->inventaire_m->getTodayInventairesWithDetails2(null);

            $link = 'today_all';
        }

        $entrepots = $this->entrepot_m->getActivated();
        $data['details'] = $inventaires;
        $data['link'] = $link;
        $data['selectedEnt'] = $lieux;
        $data['entrepots'] = $entrepots;
        //echo"<pre>"; die(print_r($inventaires));
        $data['titre'] = $periode;
        $data['page'] = "inventaire/hdetail";
        $data['menu'] = 'edition';
        $data['script'] = "filter1";
        $this->load->view($this->template, $data);
    }

    public function imprimerHistorique($param){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }
        $link = '';
        if(isset($param)){
            if($param == 'today'){
                $periode = "Historique des Inventaires du ".date("d/m/Y");

                $inventaires = $this->inventaire_m->getTodayInventairesWithDetails();
            }else{
                $temp = explode('_', $param);
                $debut = $temp[0];
                $fin = $temp[1];

                $periode = "Historique des Inventaires du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));
                $inventaires = $this->inventaire_m->getInventairesWithDetailsByPeriode($debut, $fin);
            }
        }else{
            $periode = "Historique des Inventaires du ".date("d/m/Y");
            $inventaires = $this->inventaire_m->getTodayInventairesWithDetails();

        }

        $message = $periode;

        $data['inventaires'] = $inventaires;
        $data['message'] = $message;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('inventaire/printHistorique', $data, true);
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

    public function imprimerAfficher($id){
        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $inventaire = $this->inventaire_m->get($id);

        if($inventaire->token == ''){
            redirect("inventaire/index");
        }

        $lignes = $this->detailinventaire_m->getAllByInventaireId($inventaire->idinventaire);

        $entrepots = $this->entrepot_m->get($inventaire->identrepot);

        $message = 'Détail Inventaire N°'.$inventaire->idinventaire." du ".date('d-m-Y', strtotime($inventaire->dateinventaire));;

        $data['message'] = $message;
        $data['inventaire'] = $inventaire;
        $data['entrepot'] = $entrepots;
        $data['details'] = $lignes;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('inventaire/printHistoriqueD', $data, true);
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

    public function printHdetail($param){

        if(!$this->ion_auth->logged_in()){
            redirect("auth/login");
        }

        $temp1 = explode('_', $param);

        if(isset($temp1[0])){
            if($temp1[0] == 'today'){

                if(isset($temp1[1]) AND $temp1[1] != 'all'){
                    $lieux = $temp1[1];
                    $data['stockage'] = $this->entrepot_m->get($temp1[1])->designation;
                }else{
                    $lieux = null;
                    $data['stockage'] = "Toutes les Salles de Stockage";
                }

                $periode = "Historique des Inventaires du ".date("d/m/Y");

                $inventaires = $this->inventaire_m->getTodayInventairesWithDetails2($lieux);
            }else{

                $temp2 = explode('x', $temp1[0]);

                $debut = $temp2[0];

                $fin = $temp2[1];

                if(isset($temp1[1]) AND $temp1[1] != 'all'){
                    $lieux = $temp1[1];
                    $data['stockage'] = $this->entrepot_m->get($temp1[1])->designation;
                }else{
                    $lieux = null;
                    $data['stockage'] = "Toutes les Salles de Stockage";
                }

                $periode = "Historique des Inventaires du ".date("d/m/Y", strtotime($debut))." au ".date("d/m/Y", strtotime($fin));

                $inventaires = $this->inventaire_m->getInventairesWithDetailsByPeriode2($debut, $fin, $lieux);
            }
        }else{
            $data['stockage'] = "Toutes les Salles de Stochage";
            $periode = "Historique des Inventaires du ".date("d/m/Y");
            $inventaires = $this->inventaire_m->getTodayInventairesWithDetails2(null);
        }

        $message = $periode;

        $data['message'] = $message;
        $entrepots = $this->entrepot_m->getActivated();
        $data['details'] = $inventaires;
        $data['entrepots'] = $entrepots;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        $mpdf->SetTitle($message);
        $mpdf->SetAuthor('ESC Technologie');
        $mpdf->SetCreator('Malick Coulibaly');
        $html = $this->load->view('inventaire/printHistoriqueDetail', $data, true);
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
