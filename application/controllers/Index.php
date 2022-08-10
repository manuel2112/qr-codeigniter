<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct()
	{		
		parent::__construct();
		redirect(base_url('home'));
		return;
	}
	
	public function index()
	{
		$this->layout->view('index');
	}
	
}
