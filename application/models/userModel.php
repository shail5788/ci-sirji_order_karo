<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_model{

	public $errors=[];
	public $response=[];

       public function user_register($data){
       	 $mobile_no=$data['mobile_no'];
         if(empty($this->isExist("user_tbl",$mobile_no))){
     		 $res=$this->db->insert("user_tbl",$data);
	       	 if($res){
	       	 	$inserted=$this->db->insert_id();
	       	 	$user=$this->db->where(['id'=>$inserted])
	       	 				   ->select("*")
	       	 				   ->from("user_tbl")
	       	 				   ->get();
	       	 	$newUser=$user->result_array();
	       	 	$this->response['user']=$newUser;			   
	       	 }else{
      	      $this->errors['status']=500;
      				$this->errors['error']="Something went wrong while insert";
      				$this->response['errors']=$errors;	
           }
         }else{
    			$this->errors['status']=501;
    			$this->errors['error']="mobile no is already exist!";	     
    			$this->response['errors']=$this->errors; 
            
         }
       	 
         return $this->response;
       }
       public function login($data){
            
            $user=$this->db->where(['mobile_no'=>$data['mobile_no']])
                            ->select("*")
                            ->from("user_tbl")
                            ->get();
            $users=$user->result_array();
            
            if(!empty($users)){
               $this->response['user']=$users;         	
            }else{
            	$this->errors['status']=501;
            	$this->errors['error']="Sorry! wrong mobile no is incorrect";
                $this->response["errors"]=$this->errors;
            } 
           return $this->response;                             
   
       }
       public function isExist($table,$mobile){
             
        $response=$this->db->where(['mobile_no'=>$mobile])
                           ->select("*")
                           ->from($table)
                           ->get();
         return $response->result_array();                  

       }
       public function isEmpty($table){
               
       $response=$this->db->select("*")
                          ->from("tbl_users")
                          ->get();
        return $response->result_array();                  
       }
       public function otp_generate($data){
       	   
           $res=$this->db->insert("tbl_otp",$data);
           if($res){
            $this->response['status']=200;
            $this->response['message']="Otp has been genereted successfully";
           }else{
            $this->response['status']=500;
            $this->response['errors']="internal server errors";
           }
           return $this->response;
       }
}