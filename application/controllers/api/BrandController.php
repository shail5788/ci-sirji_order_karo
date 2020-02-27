<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class BrandController extends API_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model("brand_model",'brand');
	
	}
	public function create_brand(){

		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['POST'],
		  	'requireAuthorization' => true
		]);
        if(!empty($auth)){
        	$payload=json_decode($this->input->raw_input_stream, true);
		    $response=$this->brand->create_brand($payload);
		     $this->api_return(['status' => true,'result' =>$response],200);
		 }else{
		 	$this->api_return(['status' => true,'result' =>$auth],401);
		 }
		
	}
	public function get_brand(){
		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['GET'],
		  	'requireAuthorization' => true
		]);
		if($auth['status']){
			$brand_id=$this->uri->segment(3);
			$response=$this->brand->get_brand($brand_id);
			if($response['status']){
				$this->api_return(['status'=>true,'result'=>$response],200);
			}else{
				$this->api_return(['status'=>true,'result'=>$response],501);
			}

		}else{
			$this->api_return(['status'=>true,'result'=>$auth],401);
		}
	}
	public function get_all_brand($user_id){

		header("Access-Control-Allow-Origin: *");	
		
		$auth=$this->_apiConfig([
		  	"methods"=>['POST'],
		  	'requireAuthorization' => true
		]);
		if($auth['status']){
			$brand_id=$this->uri->segment(3);
			$response=$this->brand->get_all_brands($brand_id);
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
