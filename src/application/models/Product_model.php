<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model{

	public function get($product_id){
        $this->db->where('id',$product_id);
        $query = $this->db->get('product');

        if($query->num_rows() == 1){
            foreach ($query->result() as $row){
                $name = $row->name;
                $color = $row->color;
                $brand = $row->brand;
                $des = $row->description;
                $category1 = $row->category1;
                $category2 = $row->category2;
                $img = $row->img_path;
            }
            if($brand!=NULL){
                $brand = $this->getBrandName($brand);
            }
            if($category1 != NULL){
                $category1 = $this->getCatName($category1);
            }
            if($category2 != NULL){
                $category2 = $this->getCatName($category2);
            }
            $result = array(
                'id' => $product_id,
                'name' => $name,
                'color' => $color,
                'brand' => $brand,
                'des' => $des,
                'category1' => $category1,
                'category2' => $category2,
                'img_path' => $img
            );
            return $result;
        }else{
            return false;
        }
    }

    public function search($keyword){
        if($keyword == ""){
            $query = $this->db->get('product');
            if($query->num_rows()>0){
                return $query->result();
            } else{
                return 'no result';
            }
        }else{
            $this->db->where('id >=',0); //to have a where before or_where
            $brandR = $this->getBrandId($keyword);
            $catR = $this->getCatId($keyword);
            if($brandR != NULL){
                foreach($brandR as $row){
                    $id = $row;
                    $this->db->or_where('brand',$id, FALSE);
                }
            }
            if($catR != NULL){
                foreach($catR as $row){
                    $id = $row;
                    $this->db->or_where('category1',$id, FALSE);
                    $this->db->or_where('category2',$id, FALSE);
                }
            }
            $this->db->or_like('name', $keyword);
            $this->db->or_like('color', $keyword);
            $result = $this->db->get('product');
            if($result->num_rows()>0){
                return $result->result();
            }else{
                return 'no result';
            }
        }
    }

    public function searchCat($id){
        if($id == NULL)
        {
            return 'invalid';
        }else{
            $this->db->where('category1', $id, FALSE);
            $this->db->or_where('category2', $id, FALSE);
            $this->db->order_by('name', 'DESC');
            $result = $this->db->get('product');
            if($result->num_rows()!=0){
                return $result->result();
            } else{
                return 'no result';
            }
        }
    }

    //brand and category supporting functions

    public function getBrandName($id){
        $this->db->select('b_name');
        $this->db->where('id',$id, FALSE);
        $result = $this->db->get('brand');
        return $result->row()->b_name;
    }

    public function getCatName($id){
        $this->db->select('category');
        $this->db->where('id',$id, FALSE);
        $result = $this->db->get('product_category');
        foreach ($result->result() as $row){
            $name = $row->category;
        }
        return $name;
    }

    public function getBrandId($keyword){
        $this->db->like('b_name',$keyword);
        $result = $this->db->get('brand');
        if($result->num_rows()>0){
            $ids = array();
            foreach ($result->result() as $row){
                $id = $row->id;
                $ids[]= $id;
            }
        }else{
            $ids = NULL;
        }
        return $ids;
    }

    public function getCatId($keyword){
        $this->db->like('category',$keyword);
        $result = $this->db->get('product_category');
        if($result->num_rows()>0){
            $ids = array();
            foreach ($result->result() as $row){
                $id = $row->id;
                $ids[]= $id;
            }
        }else{
            $ids = NULL;
        }
        return $ids;
    }

    //Ratings

    public function getOverallRating($product_id){
        $this->db->select_avg('overall');
        $this->db->where('product',$product_id,FALSE);
        $query = $this->db->get('rating');
        if ($query->num_rows() > 0)   {
            return $query->row()->overall;
        }else{
            return null;
        }
    }

    public function getEasyRating($product_id){
        $this->db->select_avg('easy');
        $this->db->where('product',$product_id,FALSE);
        $query = $this->db->get('rating');
        if ($query->num_rows() > 0)   {
            return $query->row()->easy;
        }else{
            return null;
        }
    }

    public function getSmellRating($product_id){
        $this->db->select_avg('smell');
        $this->db->where('product',$product_id,FALSE);
        $query = $this->db->get('rating');
        if ($query->num_rows() > 0)   {
            return $query->row()->smell;
        }else{
            return null;
        }
    }

    public function getUserRating($product_id, $uname){
        $this->db->where('username',$uname);
        $this->db->where('product',$product_id, FALSE);
        $query = $this->db->get('rating');
        if($query->num_rows() == 1){
            foreach ($query->result() as $row){
                $uname = $row->username;
                $product = $row->product;
                $easy = $row->easy;
                $smell = $row->smell;
                $overall = $row->overall;
            }
            $result = array(
                'uname' => $uname,
                'product' => $product,
                'easy' =>$easy,
                'smell' =>$smell,
                'overall' =>$overall
            );
            return $result;
        }else{
            return false;
        }
    }

    public function insertRating($uname, $product_id,$easy, $smell, $overall){
        $this->db->set('username', $uname);
        $this->db->set('product', $product_id,FALSE);
        $this->db->set('easy',$easy, FALSE);
        $this->db->set('smell',$smell, FALSE);
        $this->db->set('overall',$overall, FALSE);
        $query = $this->db->insert('rating');
    }

    public function updateRating($uname, $product_id,$easy, $smell, $overall){
        $this->db->set('easy',$easy, FALSE);
        $this->db->set('smell',$smell, FALSE);
        $this->db->set('overall',$overall, FALSE);
        $this->db->where('username', $uname);
        $this->db->where('product', $product_id, FALSE);
        $query = $this->db->update('rating');
    }

    //Review

    public function insertReview($product, $uname, $content){
        $this->db->set('product',$product, FALSE);
        $this->db->set('user', $uname);
        $this->db->set('timestamp', 'NOW()', FALSE);
        $this->db->set('content', $content);
        $this->db->insert('review');
        if($this->db->affected_rows() ==1){
            $this->db->select('id');
            $this->db->where('product',$product, FALSE);
            $this->db->where('user', $uname);
            $this->db->where('content', $content);
            $result = $this->db->get('review');
            return $result->row()->id;
        }else{
            return false;
        }
    }

    public function insertRImg($id, $img){
        $this->db->set('reviewID',$id, FALSE);
        $this->db->set('img',$img);
        $this->db->insert('review_img');
    }

    public function updateReview($id, $content){
        $this->db->set('content', $content);
        $this->db->where('id', $id, FALSE);
        $this->db->update('review');
    }

    public function deleteReview($id){
        $this->db->where('id',$id, FALSE);
        $this->db->delete('review');
        $this->db->where('reviewID',$id, FALSE);
        $this->db->delete('review_img');
    }

    public function getReview($product,$limit,$start){
        $this->db->where('product',$product, FALSE);
        $this->db->order_by('timestamp', "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get('review');
        if ($query->num_rows()>0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function getRImg($id){
        $this->db->where('reviewId',$id,FALSE);
        $img = $this->db->get('review_img');
        if($img->num_rows()>0){
            return $img->result();
        }else{
            return false;
        }
    }

    public function getSpecificReview($id){
        $this->db->where('id', $id, FALSE);
        
    }

    //Homepage top three reviewed product
    public function topReviewed(){
        $this->db->select('product, COUNT(timestamp) AS numReview');
        $this->db->from('review');
        $this->db->group_by('product');
        $this->db->order_by("numReview","desc");
        $this->db->limit(3);
        $query = $this->db->get();
        return $query->result();
    }

    //Search Box Autocompletion
    public function searchAuto($keyword){
        $result = array();
        $this->db->like('b_name', $keyword);
        $this->db->limit(3);
        $brand = $this->db->get('brand');
        if($brand->num_rows()>0){
            foreach($brand->result() as $b){
                $result[] = $b->b_name;
            }
        }
        $this->db->like('category',$keyword);
        $this->db->limit(3);
        $cat = $this->db->get('product_category');
        if($cat->num_rows()>0){
            foreach($cat->result() as $c){
                $result[] = $c->category;
            }
        }
        //color
        $this->db->like('color', $keyword);
        $this->db->limit(3);
        $color = $this->db->get('product');
        if($color->num_rows()>0){
            foreach($color->result() as $co){
                $result[] = $co->color;
            }
        }
        $this->db->like('name',$keyword);
        $this->db->limit(3);
        $name = $this->db->get('product');
        if($name->num_rows()>0){
            foreach($name->result() as $n){
                $result[] = $n->name;
            }
        }
        return $result;
    }

    //Adding product
    public function getBrands(){
        return $this->db->get('brand')->result();
    }

    public function getCats(){
        return $this->db->get('product_category')->result();
    }

    public function getNames($brandID){
        $this->db->distinct();
        $this->db->select('name');
        $this->db->where('brand',$brandID, FALSE);
        $query = $this->db->get('product');
        if($query->num_rows()>0){
            $result=array();
            foreach($query->result() as $n){
                $name = $n->name;
                $id=$this->getIDbyName($name);
                $add=array(
                    'id'=>$id,
                    'name'=>$name
                );
                $result[]=$add;
            }
            return $result;
        }else{
            return false;
        }
    }

    public function getIDbyName($name){
        $this->db->select('id');
        $this->db->where('name',$name);
        $this->db->limit(1);
        return $this->db->get('product')->row()->id;
    }

    public function getName($productID){
        $this->db->select('id, name');
        $this->db->where('id',$productID, FALSE);
        return $this->db->get('product')->row();
    }

    public function getColors($brandID,$name){
        $this->db->select('id, color');
        $this->db->where('brand',$brandID, FALSE);
        $this->db->where('name',$name);
        return $this->db->get('product')->result();
    }

    public function insertBrand($bname){
        $this->db->set('b_name',$bname);
        $this->db->insert('brand');
        $this->db->where('b_name',$bname);
        return $this->db->get('brand')->row()->id;
    }

    public function getProductDetail($brandID,$pname){
        $this->db->select('description, category1, category2');
        $this->db->where('brand',$brandID, FALSE);
        $this->db->where('name',$pname);
        return $this->db->get('product')->row();
    }

    public function addProduct($brand, $name, $color, $des, $cat1, $cat2){
        $this->db->set('brand', $brand);
        $this->db->set('name', $name);
        $this->db->set('color', $color);
        $this->db->set('description', $des);
        $this->db->set('category1', $cat1);
        if(isset($cat2)){
            $this->db->set('category2', $cat2);
        }
        $this->db->insert('product');

        $this->db->where('brand', $brand);
        $this->db->where('name', $name);
        $this->db->where('color', $color);
        $query = $this->db->get('product');
        return $query->row()->id;
    }
    
    public function insertPImg($id,$img){
        $this->db->where('id',$id,FALSE);
        $this->db->set('img_path',$img);
        $this->db->update('product');
    }
}	
?>
