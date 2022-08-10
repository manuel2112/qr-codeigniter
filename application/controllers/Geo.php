<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geo extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function ciudadPorRegion()
	{
		$data  		= array();
        $request	= json_decode(file_get_contents('php://input'));
		$idRegion	= $request->region;

        $data['ciudades'] = $this->ciudad_model->getCiudadPorRegion($idRegion);

        echo json_encode($data);
	}
	
}
