<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('data/dao_service_model');
		$this->load->model('data/dao_user_model');
		$this->load->model('data/dao_site_model');
	}

	public function index()
	{
		$answer['services'] = $this->dao_service_model->getAllServices();
		$answer['engineers'] = $this->dao_user_model->getAllEngineers();
		$answer['sites'] = $this->dao_site_model->getAllSites();

		$this->load->view('welcome_message');
	}
}
