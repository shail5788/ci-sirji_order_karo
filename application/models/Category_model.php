<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_model{

  public $errors=[];
  public $response=[];

   public function create_category($payload){

     
        $data=[
          'category_name'=>$payload['category_name'],
          "brand_id"=>$payload['brand_id'],
          "user_id"=>$payload['user_id']
    ];
    $is_exist=$this->is_exist($payload['user_id'],$payload['category_name']);
    if($is_exist){
      $res=$this->db->insert('category_tbl',$data);
      if($res){
        $current_brand_id=$this->db->insert_id();
        $response=$this->db->where(['id'=>$current_brand_id])
                   ->from("category_tbl")
                   ->get();
        $result=$response->result_array();
        $this->response['status']=true;
        $this->response['result']=$result;           
      }
    }else{
      $this->errors['error']=>"Category is already created by this user";
      $this->response['status']=false;
      $this->response['result']=$this->errors;
    }
    return $this->response;
   }
   public function get_category($category_id){
        $res=$this->db->where(['id'=>$category_id])
                ->from("category_tbl")
                ->get();
        $result=$res->result_array();
        
        return $this->response($result);        
   }
   public function get_all_categories($user_id,$brand_id){
      $query="select * from category_tbl where user_id=$user_id OR brand_id=$brand_id";
      $res=$this->db->query($query);
      $result=$res->result_array();
      return $this->response($result);         
   }
   public function is_exist($user_id,$brand_name){

        $res=$this->db->where(
                ['user_id'=>$user_id,"category_name"=>$brand_name])
                ->from("category_tbl")
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
