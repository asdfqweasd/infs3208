<?php if
( ! defined('BASEPATH')) exit('No direct script access
allowed');
 //put your code here 
class User_model extends CI_Model{
    public function can_login($user_email, $password){
        // construct sql query
        $this->db->where('email', $user_email);
        // $this->db->where('password', $password);
        // making query
        $query = $this->db->get('register');
        $record = $query->row_array();
        $d_password = $record['password'];


        if($query->num_rows() >0 & password_verify($password,$d_password)){
            return true;
        } else {
           
            return false;
        }
    }

    public function get_infor($user_email)
    {
        $this->db->where('email', $user_email);
        $query = $this->db->get('register');

        if($query->num_rows() >0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function Update_User_Data($user_id,$data)
    {
        $this->db->set($data);
        $this->db->where('u_id',$user_id);
        $this->db->update('register');

        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }
}

?>