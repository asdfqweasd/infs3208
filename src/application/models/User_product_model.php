<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_product_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        //load product_model
        $this->load->model('product_model');
    }

    //wishlist
    public function getWish($uname){
        $this->db->where('username',$uname);
        $query = $this->db->get('wish');
        if($query->num_rows()>0){
            $result = array();
            foreach($query->result() as $row){
                $add = array(
                    "uname" => $row->username,
                    "pID" => $row->productID
                );
                $product = $this->product_model->get($row->productID);
                $add = $add + $product;
                $result[] = $add;
            }
            return $result;
        }else{
            return false;
        }
    }

    public function checkExist($uname, $product){
        $this->db->where('username',$uname);
        $this->db->where('productID',$product,FALSE);
        $result = $this->db->get('wish');
        if($result->num_rows()==1){
            return true;
        }else{
            return false;
        }
    }
    
    public function delete($uname,$product){
        $this->db->where('username',$uname);
        $this->db->where('productID',$product,FALSE);
        $this->db->delete('wish');
    }

    public function add($uname,$product){
        $data = array(
            'username' => $uname,
            'productID' => $product
        );
        $this->db->insert('wish',$data);
    }
}	
?>
