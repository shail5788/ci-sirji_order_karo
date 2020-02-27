<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UserController extends API_Controller{

	public function __construct(){
		
		parent::__construct();
		$this->load->model("user_model",'User');
		// $this->load->library('authorization_token');
	}
	public function register(){
		
		header("Access-Control-Allow-Origin: *");
		$this->_apiConfig(["methods"=>['post']]);
          
		$payload = json_decode($this->input->raw_input_stream, true);      
        $response=$this->User->user_register($payload);
        
        if(isset($response['user'])){
        	
	          $otp=$this->generate_otp($response['user'][0]['id']);
	          $status=$this->send_otp($response['user'][0]['mobile_no'],$otp['otp_code'],$otp['expire_in']);
	           
	            if($status){
	             	$this->api_return([
		                'status' => true,
						'result' =>"Please check you registerd mobile not for OTP",
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

         	  $get_current_otp =$this->User->get_otp($response['user'][0]['id']);
	    	  $isNotExpired    =$this->User->is_otp_expired($get_current_otp[0]['created_at']);
	    	  if(!empty($get_current_otp ) && $isNotExpired){
	    	  	$otp=$get_current_otp[0]['otp_code'];
	    	  }else{
	    	  	$otp_data=$this->generate_otp($response['user'][0]['id']);
	    	  	$otp=$otp_data['otp_code'];
	    	  	$expire_in=$otp_data['expire_in'];
	    	  }
	    	  $dataset['id']=$response['user'][0]['id'];
	    	  $dataset['mobile']=$response['user'][0]['mobile_no'];
   			  
	          $status=$this->send_otp($response['user'][0]['mobile_no'],$otp,$expire_in);
	          if($status){
	          		$this->api_return(['status' => true,'result' =>$dataset,"message"=>"OTP has been sent to your mobile no"],200);
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
		   date_default_timezone_set('Asia/Kolkata');
           $now=date("Y-m-d:h:m:s"); 
           $current_time =strtotime("now");
		$data= [
          "otp_code"=>$otp,
          "expire_in"=>'15min',
          "user_id"=>$user_id,
          "created_at"=>$current_time
		];
		$resp=$this->User->otp_generate($data);
		$data['status']=$resp;
		return $data;

	}
	public function send_otp($mobile,$otp,$expire_time){

        $message_string="your one time password is-".$otp." it will be expired after 15 minutes";
        $message = urlencode($message_string);
       
	    $sender = 'SIRJIL'; 
	    $token = 'b0246bf843b55528a998202e95994288';
	    $route='1';
	    $baseurl = 'http://msg.wemonde.com/api/sendSMS?token='.$token;

	    $url = $baseurl.'&token='.$token.'&senderid='.$sender.'&route='.$route.'&number='.$mobile.'&message='.$message;    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, false);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    if($response){
	    	return true;
	    }else{
	    	return false;
	    }

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
            	$this->api_return(['status' => false,'res'=>$response,'result' =>"Otp Either used or expired"], 400); 
            } 
            
       

	}
	public function get_access_token($user_id,$otp){

         $user=$this->User->get_user($user_id);
		 $this->load->library('Authorization_Token');
	     $token = $this->authorization_token->generateToken($user);
	     $response['user']=$user;
	     $response['token']=$token;
	     $status=$this->User->deleteOtp($user,$otp);
		 return $response;
	}
	public function re_send_otp(){
		$this->_apiConfig(["methods"=>['POST']]);
		$payload = json_decode($this->input->raw_input_stream, true);
		$mobile=$payload['mobile'];  
		$user=$this->User->isExist("user_tbl",$mobile); 
	    $get_current_otp =$this->User->get_otp($user[0]['id']);
	    $isNotExpired    =$this->User->is_otp_expired($get_current_otp[0]['created_at']);
	    if($isNotExpired){
           $otp=$get_current_otp[0]['otp_code'];
	    }else{
	    	$otpdata=$this->generate_otp($user[0]['id']);
	    	$otp=$otpdata[0]['otp_code'];
	    }

		

	    $status=$this->send_otp($user[0]['mobile_no'],$otp,15);

	    if($status){
	    	$this->api_return([
		                'status' => true,
		                "message"=>"Otp has been re-sent on your registered mobile no"
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