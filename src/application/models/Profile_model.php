<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile_model extends CI_Model{

	public function email_unique($email){
		$this->db->where('email', $email);
		$result = $this->db->get('user_contact');
		return $result->num_rows();
		
	}

	public function email_user($uname,$email){
		$this->db->where('username', $uname);
		$this->db->where('email', $email);
		$result = $this->db->get('user_contact');
		if($result->num_rows()==1){
			return true;
		}else{
			return false;
		}
	}
	
	public function insert($uname,$email,$gender,$dob,$date){
		$data = array(
			'username' => $uname,
			'email' => $email,
			'email_verified' => 0,
			'gender' => $gender,
			'DOB' => $dob,
			'DateRegistered' => $date
		);
		$query = $this->db->insert('user_contact', $data);

	}

	public function get($uname){
		$this->db->where('username', $uname);
		$query = $this->db->get('user_contact');
		return $query->result();
	}

	public function update($uname,$email,$gender,$dob){
		if($this->email_user($uname,$email)){
			$data = array(
				'gender' => $gender,
				'DOB' => $dob
			);
		}else{
			$data = array(
				'email' => $email,
				'email_verified' => 0,
				'gender' => $gender,
				'DOB' => $dob
			);
		}
		
		$this->db->where('username', $uname);
		$this->db->update('user_contact', $data);
	}



	public function VerifyEmail($email,$code){
		$this->db->where('email',$email);
		$this->db->where('verify_code',$code);
		$result=$this->db->get('user_contact');
		if($result->num_rows()==1){
			$data = array('email_verified' => 1);
			$this->db->where('email',$email);
			$this->db->update('user_contact', $data);
			return true;
		}else{
			return false;
		}
	}

	public function updateCode($email,$code){
		$data = array('verify_code' => $code);
		$this->db->where('email',$email);
		$this->db->update('user_contact', $data);
	}

	public function getUnameByEmail($email){
		$this->db->where('email',$email);
		$result = $this->db->get('user_contact');
		if ($result->num_rows() > 0){
        	$row = $result->row();
			$uname = $row->username;
			return $uname;
		}else{
			return NULL;
		}

	}

	public function getEmail($uname){
		$this->db->where('username',$uname);
		$result = $this->db->get('user_contact');
		if ($result->num_rows() > 0){
        	$row = $result->row();
			$email = $row->email;
			return $email;
		}else{
			return NULL;
		}
	}

	public function verified($uname){
		$this->db->where('username', $uname);
		$this->db->where('email_verified',1, FALSE);
		$result = $this->db->get('user_contact');
		if($result->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
}	
?>