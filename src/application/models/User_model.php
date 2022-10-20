<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{

	//Log in
	public function login($username, $password){
		//Validate
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$result = $this->db->get('user');

		if($result->num_rows() == 1){
			return 'true';
		} else {
			$this->db->where('username', $username);
			$result2 = $this->db->get('user');
			if($result2->num_rows() == 1){
				return 'password';
			}else{
				return 'username';
			}
		}
	}

	//Check username
	public function uname_unique($uname){
		$this->db->where('username', $uname);
		$result = $this->db->get('user');
		return $result->num_rows();
		
	}

	public function insert($uname,$pwd,$sq1,$sq1a,$sq2,$sq2a){
		$data = array(
			'username' => $uname,
			'password' => $pwd,
			'sq1_id' => $sq1,
			'sq1_answer' => $sq1a,
			'sq2_id' => $sq2,
			'sq2_answer' => $sq2a
		);
		$query = $this->db->insert('user', $data);
	}

	public function updateCode($uname,$vcode){
		$data = array('reset_code' => $vcode);
		$this->db->where('username',$uname);
		$this->db->update('user', $data);
	}

	public function get($uname){
		$this->db->where('username',$uname);
		$query = $this->db->get('user');
		return $query->result();
	}

	public function checkCode($uname, $vcode){
		$this->db->where('username', $uname);
		$this->db->where('reset_code', $vcode);
		$result = $this->db->get('user');
		if($result->num_rows()==1){
			return true;
		}else{
			return false;
		}
	}

	public function checkSq1Ans($uname,$ans){
		$this->db->where('username', $uname);
		$this->db->where('sq1_answer', $ans);
		$result = $this->db->get('user');
		if($result->num_rows()==1){
			return true;
		}else{
			return false;
		}
	}

	public function checkSq2Ans($uname,$ans){
		$this->db->where('username', $uname);
		$this->db->where('sq2_answer', $ans);
		$result = $this->db->get('user');
		if($result->num_rows()==1){
			return true;
		}else{
			return false;
		}
	}

	public function updatePwd($uname,$pwd){
		$data = array('password' => $pwd);
		$this->db->where('username',$uname);
		$this->db->update('user', $data);
	}

}	
?>
