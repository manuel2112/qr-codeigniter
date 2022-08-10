<?php
	
class parametro_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function getParametro()
    {
        $where = array(
                        "PARAMETRO_ID" => 1
                      );
        $query = $this->db
                        ->select("*")
                        ->from("parametros")
                        ->where($where)
                        ->get();
        return $query->row();       
    }

    public function updateParametro($iva, $zona, $transbank)
    {
      $array = array(
                      'PARAMETRO_IVA'           => $iva,
                      'PARAMETRO_ZONA_HORARIA'  => $zona,
                      'PARAMETRO_TRANSBANK'     => $transbank
                    );
      $this->db->where('PARAMETRO_ID', 1);
      $this->db->update('parametros', $array);
    }
	
} 