<?php
	
class login_model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
  }
	
	public function editPassAdmin($password)
  {
    $array = array(
              'EMPRESA_PASS' => $password
              );
    $this->db->where('EMPRESA_ADMIN', TRUE);
    $this->db->update('empresa', $array);
  }
  
	public function getLoginRow($user,$pass)
  {
    $where = array(
                    "EMPRESA_EMAIL" => $user, 
                    "EMPRESA_PASS"  => $pass
                   );		    
    $query = $this->db
                  ->select("*")
                  ->from("empresa")
                  ->where($where)
                  ->get();
    return $query->row();
  }

}