<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UserController extends API_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model("UserModel",'User');
	
	}
	public function register(){
		
		header("Access-Control-Allow-Origin: *");
		$this->_apiConfig(["methods"=>['post']]);
          
		$payload = json_decode($this->input->raw_input_stream, true);      
        $response=$this->User->user_register($payload);
        
        if(isset($response['user'])){
        	
	          $otp=$this->generate_otp($response['user'][0]['id']);
	          $status=$this->send_email($response['user'][0]['email'],$otp);
	            if($status){
	             	$this->api_return([
		                'status' => true,
		                'result' =>$response['user'][0]['id'],
		                "message"=>"please check you email to one time password"
		            ],200);
	             }else{
	             	$this->api_return(['status' => false,"message"=>"some thing wrong"],500);
	             }
	    }else{
	        
	        $this->api_return(['status' => false,'result' =>$response,],500);
	    }

	}
	public function login(){
		
		header("Access-Control-Allow-Origin: *");	
		
		$this->_apiConfig([
		  	"methods"=>['post']
		]);
	    $payload = json_decode($this->input->raw_input_stream, true);
	    $response=$this->User->login($payload);
         if($response['user']){
   			  $otp=$this->generate_otp($response['user'][0]['id']);
	          $status=$this->send_email($response['user'][0]['email'],$otp);
	          if($status){
	          		$this->api_return(['status' => true,'result' =>$response['user'],"message"=>"Password has been send to your email"],200);
	          }else{
	          	$this->api_return(['status' => false,"message"=>"something in happend during mail send"],500);
	          }
		       
		 }else{
		 	$this->api_return(['status' => false,'result' =>$response,],500);
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
	public function generate_otp($user_id){

		$otp=mt_rand(1000,5000);
		$expire_time=strtotime("+30 minutes");
		$data= [
          "otp_code"=>$otp,
          "expire_in"=>$expire_time,
          "user_id"=>$user_id
		];
		$response=$this->User->otp_generate($data);
		$data['status']=$response;
		return $data;

	}
	public function send_email($email,$data){

		 $subject="Otp Verification";
		 $from="codingss5788@gmail.com";
		  $emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"><img src="http://codingmantra.co.in/assets/logo/logo.png" width="300px" vspace=10 /></td></tr>';
		    $emailContent .='<tr><td style="height:20px"></td></tr>';


    $emailContent .= "Your One time password is here - ".$data['otp_code']."have been expired within 15 minutes";  //   Post message available here


    $emailContent .='<tr><td style="height:20px"></td></tr>';
    $emailContent .= "<tr><td style='background:#000000;color: #999999;padding: 2%;text-align: center;font-size: 13px;'><p style='margin-top:1px;'><a href='http://codingmantra.co.in/' target='_blank' style='text-decoration:none;color: #60d2ff;'>www.codingmantra.co.in</a></p></td></tr></table></body></html>";

    	$config['protocol']    = 'smtp';
    $config['smtp_host']    = 'ssl://smtp.gmail.com';
    $config['smtp_port']    = '465';
    $config['smtp_timeout'] = '60';

    $config['smtp_user']    = 'codingss5788@gmail.com';    //Important
    $config['smtp_pass']    = 'shail5788';  //Important

    $config['charset']    = 'utf-8';
    $config['newline']    = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validation'] = TRUE; // bool whether to validate email or not 

     

    $this->email->initialize($config);
    $this->email->set_mailtype("html");
    $this->email->from($from);
    $this->email->to($email);
    $this->email->subject($subject);
    $this->email->message($emailContent);
    $status=$this->email->send();
 	return $status;
	}
	public function otpVerification(){
        
       
		$this->_apiConfig(["methods"=>['POST']]);
        $payload = json_decode($this->input->raw_input_stream, true);   
		$opt=$payload['otp'];
		$user_id=$payload['user_id'];

		$response=$this->User->otp_verification($opt,$user_id);
            if($response){
            	$access_token=$this->get_access_token($user_id,$opt);
            	 $this->api_return(['status' => true,'result' =>$access_token], 200); 
            }else{
            	$this->api_return(['status' => false,'result' =>"Otp Either used or expired"], 400); 
            } 
            
       

	}
	public function get_access_token($user_id,$otp){

         $user=$this->User->get_user($user_id);
		 $this->load->library('authorization_token');
	     $token = $this->authorization_token->generateToken($user);
	     $response['user']=$user;
	     $response['token']=$token;
	     $status=$this->User->deleteOtp($user,$otp);
		 return $response;
	}
	public function re_send_otp(){
		
		$payload = json_decode($this->input->raw_input_stream, true);
		$mobile=$payload['mobile'];  
		$user=$this->User->isExist("user_tbl",$mobile); 
	
		$otp=$this->generate_otp($user[0]['id']);
	    $status=$this->send_email($user[0]['email'],$otp);

	    if($status){
	    	$this->api_return([
		                'status' => true,
		                "message"=>"please check you email for one time password"
		            ],200);
	    }else{
	       $this->api_return(['status' => false,"message"=>"some thing wrong"],500);
	    }
	
	}
	public function get_users(){
		
		$auth=$this->_apiConfig(["methods"=>['GET'],'requireAuthorization' => true]);
		if(empty($auth)){
	      $this->api_return(['status' => false,"result"=>$auth],401);     		
		}else{
			    
			    try{
					$response=$this->User->get_all_user();
					$this->api_return(['status' => true,"result"=>$response],200);
				}catch(Exception $e){
					$this->api_return(['status' => true,"result"=>$e->getMessage()],500);
				}
		}

	}
	
}