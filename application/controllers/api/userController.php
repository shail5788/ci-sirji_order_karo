<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UserController extends API_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model("UserModel",'User');
	}
	// public function get_users(){

	// };
	public function register(){
		
		header("Access-Control-Allow-Origin: *");
		header('content-type:application/json; charset=UTF-8');
		$this->_apiConfig([
		  	"methods"=>['post']
		]);
          
		$payload = json_decode($this->input->raw_input_stream, true);      
        $response=$this->User->user_register($payload);
        
        if($response['user']){
        	 $this->load->library('authorization_token');
			 $token = $this->authorization_token->generateToken($response['user']);
		}
      
        $this->api_return(
            [
                'status' => true,
                'result' =>$response,
                "access_token"=>$token
                
            ],
        200);

	}
	public function login(){
		
		header("Access-Control-Allow-Origin: *");	
		
		$this->_apiConfig([
		  	"methods"=>['post']
		]);
	    $payload = json_decode($this->input->raw_input_stream, true);
	    $response=$this->User->login($payload);
         if($response['user']){
         	 $this->load->library('authorization_token');
			 $token = $this->authorization_token->generateToken($response['user']);

		        $this->api_return(
		            [
		                'status' => true,
		                'result' =>$response,
		                "access_token"=>$token
		                
		            ],
		        200);
		 }else{
		 	$this->api_return(
		            [
		                'status' => false,
		                'result' =>$response,
		                
		                
		            ],
		        501);
		 }

	

          
	}
	public function get_user(){
		header("Access-Control-Allow-Origin: *");
	
		$auth=$this->_apiConfig([
		  	"methods"=>['GET'],
		  	'requireAuthorization' => true
		]);
       
         $this->api_return(
            [
                'status' => true,
                'result' =>$auth,
            ],
        200);   

	}
	public function generate_otp(){

		
	}
	
}