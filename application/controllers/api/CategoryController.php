<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CategoryController extends API_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model("user_model",'User');
	
	}

}	
