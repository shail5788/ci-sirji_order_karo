<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CategoryController extends API_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model("category_model",'category');
	
	}
	public function create_category(){

		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['POST'],
		  	'requireAuthorization' => true
		]);
        if(!empty($auth)){
        	$payload=json_decode($this->input->raw_input_stream, true);
		    $response=$this->category->create_category($payload);
		     $this->api_return(['status' => true,'result' =>$response],200);
		 }else{
		 	$this->api_return(['status' => true,'result' =>$auth],401);
		 }
		
	}
	public function get_category(){
		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['GET'],
		  	'requireAuthorization' => true
		]);
		if($auth['status']){
			$category_id=$this->uri->segment(3);
			$response=$this->brand->get_category($category_id);
			if($response['status']){
				$this->api_return(['status'=>true,'result'=>$response],200);
			}else{
				$this->api_return(['status'=>true,'result'=>$response],501);
			}

		}else{
			$this->api_return(['status'=>true,'result'=>$auth],401);
		}
	}
	public function get_all_categories(){

		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['GET'],
		  	'requireAuthorization' => true
		]);
		if($auth['status']){
			$user_id=$this->uri->segment(3);
			$brand_id=$this->uri->segment(4);
			$response=$this->brand->get_all_categories($brand_id,$user_id);
			if($response['status']){
				$this->api_return(['status'=>true,'result'=>$response],200);
			}else{
				$this->api_return(['status'=>true,'result'=>$response],501);
			}

		}else{
			$this->api_return(['status'=>true,'result'=>$auth],401);
		}
	}

}	
