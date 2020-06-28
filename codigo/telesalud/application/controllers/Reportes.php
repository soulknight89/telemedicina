<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reportes_model');
	}

	function calidad($mes = null, $anio = null)
	{
		$data = [];
		if (!$mes) {
			$mes = date('m');
		}
		if (!$anio) {
			$anio = date('Y');
		}
		$data['mesActual']   = $mes;
		$data['anioActual']  = $anio;
		$data['meses']       = $this->leerMeses();
		$data['indicadores'] = $this->Reportes_model->calidad($mes, $anio);
		$this->layout->view("calidad", $data);
	}

	function entregas($mes = null, $anio = null)
	{
        $data = [];
        if (!$mes) {
            $mes = date('m');
        }
        if (!$anio) {
            $anio = date('Y');
        }
        $data['mesActual']   = $mes;
        $data['anioActual']  = $anio;
        $data['meses']       = $this->leerMeses();
        $data['indicadores'] = $this->Reportes_model->entregas($mes, $anio);
        $this->layout->view("entregas", $data);
	}

	public function leerMeses()
	{
		$data = [];
		for ($i = 1; $i < 13; $i++) {
			$data[] = (object) [
				'id'     => $i,
				'nombre' => $this->mesCorto($i),
			];
		}

		return $data;
	}

	public function mesCorto($m)
	{
		switch ($m) {
			case 1:
				$mes = 'Ene.';
				break;
			case 2:
				$mes = 'Feb.';
				break;
			case 3:
				$mes = 'Mar.';
				break;
			case 4:
				$mes = 'Abr.';
				break;
			case 5:
				$mes = 'May.';
				break;
			case 6:
				$mes = 'Jun.';
				break;
			case 7:
				$mes = 'Jul.';
				break;
			case 8:
				$mes = 'Ago.';
				break;
			case 9:
				$mes = 'Sep.';
				break;
			case 10:
				$mes = 'Oct.';
				break;
			case 11:
				$mes = 'Nov.';
				break;
			case 12:
				$mes = 'Dic.';
				break;
			default:
				$mes = 'Ene.';
				break;
		}

		return $mes;
	}

	public function calidadPDF($mes = null, $anio = null)
	{
		$data = [];
		if (!$mes) {
			$mes = date('m');
		}
		if (!$anio) {
			$anio = date('Y');
		}
		$data['mesActual']   = $this->mesCorto($mes);
		$data['anioActual']  = $anio;
		$data['indicadores'] = $this->Reportes_model->calidad($mes, $anio);
		$this->layout->setLayout('clear');
		$this->layout->view('calidadPDF', $data);
		$html = $this->output->get_output();
		$this->load->library('dompdf_gen');
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper('a4', 'portrait');
		$this->dompdf->render();
		$this->dompdf->set_base_path(base_url());
		$this->dompdf->stream('indicador-calidad_' . $mes . '-' . $anio . ".pdf");
	}

    public function entregasPDF($mes = null, $anio = null)
    {
        $data = [];
        if (!$mes) {
            $mes = date('m');
        }
        if (!$anio) {
            $anio = date('Y');
        }
        $data['mesActual']   = $this->mesCorto($mes);
        $data['anioActual']  = $anio;
        $data['indicadores'] = $this->Reportes_model->entregas($mes, $anio);
        $this->layout->setLayout('clear');
        $this->layout->view('entregasPDF', $data);
        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('a4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->set_base_path(base_url());
        $this->dompdf->stream('indicador-calidad_' . $mes . '-' . $anio . ".pdf");
    }
}
