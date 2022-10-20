<?php
class Forgot_model extends CI_Model
{
    function got_password($user_email,$question,$answer)
    {
        $this->db->where('email', $user_email);
        $this->db->where('r_question', $question);
        $this->db->where('r_answer', $answer);
        $query =$this->db->get('register');

        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function Update_User_Password($user_email,$data)
    {
        $this->db->set($data);
        $this->db->where('email',$user_email);
        $this->db->update('register');

        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }






}

?>