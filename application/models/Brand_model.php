<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_model{

	public $errors=[];
	public $response=[];

   public function create_brand($payload){

     
        $data=[
        	'brand_name'=>$payload['brand_name'],
        	"sulg"=>$payload['slug'],
        	"user_id"=>$payload['user_id']
		];
		$is_exist=$this->is_exist($payload['user_id'],$payload['brand_name']);
		if($is_exist){
			$res=$this->db->insert('brand_tbl',$data);
			if($res){
				$current_brand_id=$this->db->insert_id();
				$response=$this->db->where(['id'=>$current_brand_id])
								   ->from("brand_tbl")
								   ->get();
				$result=$response->result_array();
				$this->response['status']=true;
				$this->response['result']=$result;				   
			}
		}else{
			$this->errors['error']=>"Brand is already created by this user";
			$this->response['status']=false;
			$this->response['result']=$this->errors;
		}
		return $this->response;
   }
   public function get_brand($brand_id){
        $res=$this->db->where(['id'=>$brand_id])
        			  ->from("brand_tbl")
        			  ->get();
        $result=$res->result_array();
        
        return $this->response($result);			  
   }
   public function get_all_brands($user_id){
   	$res=$this->db->where(['user_id'=>$user_id])
   				  ->from("brand_tbl")
   				  ->get();
    $result=$res->result_array();
     return $this->response($result);				  
   }
   public function is_exist($user_id,$brand_name){

   	    $res=$this->db->where(
   	    				['user_id'=>$user_id,"brand_name"=>$brand_name])
   	    			  ->from("brand_tbl")
   	    			  ->get();
   	    $result=$res->result_array();
   	    if(!empty($result)){
   	    	return false;
   	    }else{return true;}			  
   }
   public function response($result){
   	if(!empty($result)){
        	$this->response['status']=true;
        	$this->response['result']=$result;
        }else{
        	$this->response['status']=false;
        	$this->errors['errors']="Sorry! No record founds";
        	$this->response['result']=$this->errors;
        }
   }
   return $this->response;
}
