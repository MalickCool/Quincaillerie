<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 20/12/2018
 * Time: 10:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Typecommercial extends CI_Controller
{

	public function __construct($value = "")
	{
		parent::__construct();
		$this->load->model('typecommercial_m');
		$this->load->model('commercial_m');
	}

	public $template = 'templates/template';

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}
		$types = $this->typecommercial_m->get_all();
		$data['types'] = $types;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Liste des Types de Commerciaux';
		$data['page'] = "typecomm/liste";
		$data['menu'] = 'edition';
		$this->load->view($this->template, $data);
	}

	public function ajouter()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$types = $this->typecommercial_m->get_all();
		$data['types'] = $types;
		//echo"<pre>"; die(print_r($types));
		$data['titre'] = 'Ajouter un Type de Commercial';
		$data['page'] = "typecomm/ajouter";
		$data['menu'] = 'commerciale';
		$data['script'] = 'global';
		$this->load->view($this->template, $data);
	}

	public function insert()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$this->form_validation->set_rules('designation', 'Designation', 'required');
		$this->form_validation->set_rules('pourcentage', 'Pourcentage', 'required');

		if ($this->form_validation->run()) {

			$datas = array(
				'designation' => $this->input->post('designation'),
				'pourcentage' => $this->input->post('pourcentage'),
				'token' => $this->input->post('token'),
			);

			$lastInsertedId = 0;

			if (!$this->typecommercial_m->exist($this->input->post('token'))) {
				$lastInsertedId = $this->typecommercial_m->add_item($datas);
			}
		}
		redirect('typecommercial/ajouter', 'refresh');
	}

	public function edit($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}


		$type = $this->typecommercial_m->get($id);
		if ($type->designation == "") {
			redirect("typecommercial/");
		}
		$types = $this->typecommercial_m->get_all();
		$data['types'] = $types;

		$data['type'] = $type;

		$data['titre'] = 'Modifier le Type de commercial ' . $type->designation;
		$data['page'] = "typecomm/modifier";
		$data['menu'] = 'commerciale';
		$data['script'] = 'global';
		$this->load->view($this->template, $data);
	}

	public function update()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect("auth/login");
		}

		$item = $this->typecommercial_m->get($_POST['id']);
		if ($item->designation == "") {
			redirect("typecommercial/");
		}

		$this->form_validation->set_rules('designation', 'Designation', 'required');
		$this->form_validation->set_rules('pourcentage', 'Pourcentage', 'required');

		if ($this->form_validation->run()) {

			$etat = 0;
			if (isset($_POST['etat'])) {
				$etat = 1;
			}

			$datas = array(
				'designation' => $this->input->post('designation'),
				'pourcentage' => $this->input->post('pourcentage'),
				'etat' => $etat,
			);

			$this->typecommercial_m->update($item->idType, $datas);
		}
		redirect('typecommercial/ajouter');
	}

	public function imprimer()
	{

		$message = "Liste des Types de Commerciaux";

		$types = $this->typecommercial_m->get_all();
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
		$html = $this->load->view('typecomm/print', $data, true);
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
