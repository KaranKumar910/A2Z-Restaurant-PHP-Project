<?php
	class Login_model extends CI_Model{

		function login ($user,$pass){
			return $this->db->where(['username' => $user,'password'=>$pass])->get('admins');
		}

	
	}
?>