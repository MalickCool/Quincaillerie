<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Typedepense extends CI_Controller
{

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('typedepense_m');
	}

	public $template = 'templates/template';

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}
		$types = $this->typedepense_m->get_all();
		$data['types'] = $types;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Liste des Types de Sortie de Caisse';
		$data['page'] = "typedepense/liste";
		$data['menu'] = 'edition';
		$this->load->view($this->template, $data);
	}

	public function ajouter()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$types = $this->typedepense_m->get_all();
		$data['types'] = $types;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Créer un Type de Sortie de Caisse';
		$data['page'] = "typedepense/ajouter";
		$data['menu'] = 'config';
		$data['script'] = 'global';
		$this->load->view($this->template, $data);
	}

	public function insert()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$this->form_validation->set_rules('libelle', 'libelle', 'required');
		$this->form_validation->set_rules('token', 'token', 'required');

		if ($this->form_validation->run()) {

			$datas = array(
				'libelle' => $this->input->post('libelle'),
				'description' => $this->input->post('description'),
				'token' => $this->input->post('token'),
			);

			if (!$this->typedepense_m->exist($this->input->post('token'))) {
				$this->typedepense_m->add_item($datas);
			}
		}
		redirect('typedepense/ajouter', 'refresh');
	}

	public function edit($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}


		$type = $this->typedepense_m->get($id);
		if ($type->libelle == "") {
			redirect("typedepense/");
		}
		$types = $this->typedepense_m->get_all();
		$data['types'] = $types;

		$data['type'] = $type;

		$data['titre'] = 'Modifier le Type de dépense ' . $type->libelle;
		$data['page'] = "typedepense/modifier";
		$data['menu'] = 'config';
		$data['script'] = 'achat';
		$this->load->view($this->template, $data);
	}

	public function update()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$item = $this->typedepense_m->get($_POST['id']);
		if ($item->designation == "") {
			redirect("typedepense/");
		}

		$this->form_validation->set_rules('libelle', 'libelle', 'required');

		if ($this->form_validation->run()) {
			$datas = array(
				'libelle' => $this->input->post('libelle'),
				'description' => $this->input->post('description'),
			);

			$this->typedepense_m->update($item->idtypedepense, $datas);
		}
		redirect('typedepense/ajouter');
	}

	public function imprimer()
	{

		$message = "Liste des Types de Dépense";

		$types = $this->typedepense_m->get_all();
		$data['types'] = $types;
		$data['message'] = $message;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-P',
			'orientation' => 'P'
		]);
		$mpdf->SetTitle($message);
		$mpdf->SetAuthor('ESC Technologie');
		$mpdf->SetCreator('Malick Coulibaly');
		$html = $this->load->view('typedepense/print', $data, true);
		$mpdf->setFooter('{PAGENO} / {nb}');
		$mpdf->SetHTMLHeader('
            <page_header>
                <table style="border: none;">
                    <tr>
                        <td style="width: 20%;">
                        
                        </td>
                        <td style="width: 60%;  padding-left: 0px; border: none !important; text-align: center">
                            <img src="' . FCPATH . '/Uploads/logo.jpg" style="width: 100%;"  alt="">
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
                    <td width="33%" style="text-align: right;">' . $message . '</td>
                </tr>
            </table>');
		$mpdf->WriteHTML($html);
		$mpdf->Output($message . '.pdf', 'I');
	}
}
