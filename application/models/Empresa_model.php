<?php
	
class empresa_model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
  }

	public function insertEmpresa($nombre,$direccion,$fono,$email,$pass,$slug,$ciudad,$ingreso,$isAdmin,$membresia,$codReg,$referido,$responsable)
  {
    $data = array(
            'EMPRESA_NOMBRE'	      => $nombre,
            'EMPRESA_DIRECCION'	    => $direccion,
            'EMPRESA_FONO'		      => $fono,
            'EMPRESA_EMAIL'		      => $email,
            'EMPRESA_PASS'		      => $pass,
            'EMPRESA_SLUG'		      => $slug,
            'CIUDAD_ID'			        => $ciudad,
            'EMPRESA_INGRESO'	      => $ingreso,
            'EMPRESA_ADMIN'		      => $isAdmin,
            'EMPRESA_MEMBRESIA'	    => $membresia,
            'EMPRESA_COD_REG'	      => $codReg,
            'EMPRESA_REFERIDO'      => $referido,
            'EMPRESA_RESPONSABLE'   => $responsable
          );
    $this->db->insert('empresa', $data);
    return $this->db->insert_id();
  }

	public function getEmpresaExisteCampo($campo,$valor)
  {
      $where = array(
          $campo => $valor
          );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->num_rows();
	}

	public function getEmpresaExisteCampoRow($campo,$valor)
  {
      $where = array(
          $campo => $valor
          );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->row();
	}

  public function updateEmpresaExisteCampo($idEmpresa,$campo,$valor)
  {
      $where = array(
                      'EMPRESA_ID !=' => $idEmpresa,
                      $campo => $valor
          );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->num_rows();
	}

	public function updateEmpresaPermiso($codigo)
  {
    $array = array(
            'EMPRESA_STATUS' => true
              );
    $this->db->where('EMPRESA_COD_REG', $codigo);
    $this->db->update('empresa', $array);
  }

  public function getEmpresaRow($idEmpresa)
  {
      $where = array(
          "EMPRESA_ID" => $idEmpresa
          );
      $query = $this->db
                    ->select("*")
                    ->from("empresa")
                    ->join('geo_comunas', 'geo_comunas.id = empresa.CIUDAD_ID')
                    ->where($where)
                    ->get();
      return $query->row();
	}

  public function getEmpresas()
  {
      $where = array(
                      "EMPRESA_STATUS" => TRUE
                    );
      $query = $this->db
                    ->select("*")
                    ->from("empresa")
                    ->where($where)
                    ->order_by('EMPRESA_NOMBRE ASC')
                    ->get();
      return $query->result();
	}

  public function getEmpresaSlugRow($slug)
  {
      $where = array(
          "EMPRESA_SLUG" => $slug
          );
      $query = $this->db
                    ->select("*")
                    ->from("empresa")
					->join('geo_comunas', 'geo_comunas.id = empresa.CIUDAD_ID')
                    ->where($where)
                    ->get();
      return $query->row();
	}

  public function getEmpresaTblRow($idEmpresa)
  {
      $where = array(
          "EMPRESA_ID" => $idEmpresa
          );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->row();
  }

	public function updateDatosEmpresa($idEmpresa,$nombre,$fono,$direccion,$descripcion,$comuna,$slug)
  {
    $array = array(
            'EMPRESA_NOMBRE'		=> $nombre,
            'EMPRESA_DIRECCION'		=> $direccion,
            'EMPRESA_FONO'		    => $fono,
            'EMPRESA_DESCRIPCION'   => $descripcion,
            'CIUDAD_ID'		        => $comuna,
            'EMPRESA_SLUG'	        => $slug
              );
    $this->db->where('EMPRESA_ID', $idEmpresa);
    $this->db->update('empresa', $array);
  }

  public function updateRedesEmpresa($idEmpresa,$whatsapp,$web,$facebook,$instagram)
  {
    $array = array(
            'EMPRESA_WHATSAPP'  => $whatsapp,
            'EMPRESA_WEB'       => $web,
            'EMPRESA_FACEBOOK'  => $facebook,
            'EMPRESA_INSTAGRAM' => $instagram,
              );
    $this->db->where('EMPRESA_ID', $idEmpresa);
    $this->db->update('empresa', $array);
  }

  public function updateEmpresaCampo($idEmpresa, $campo, $valor)
  {
    $array = array(
                        $campo => $valor
              );
    $this->db->where('EMPRESA_ID', $idEmpresa);
    $this->db->update('empresa', $array);
  }  

  public function getEmpresaNewPass($email,$hash)
  {
      $where = array(
                      "EMPRESA_EMAIL"     => $email,
                      "EMPRESA_REC_PASS"  => $hash
                    );
      $query = $this->db
                      ->select("*")
                      ->from("empresa")
                      ->where($where)
                      ->get();
      return $query->row();
  }

	/*=============================================
	QR
	=============================================*/ 
    
  public function getEmpresaQRRow($idEmpresa)
  {
      $where = array(
          "EMPRESA_ID" 	=> $idEmpresa,
          "EMP_QR_FLAG"	=> TRUE
          );
      $query = $this->db
                      ->select("*")
                      ->from("empresa_qr")
                      ->where($where)
                      ->get();
      return $query->row();
	}

	public function insertEmpresaQR($idEmpresa,$urlImg,$date)
  {
    $data = array(
            'EMPRESA_ID'	=> $idEmpresa,
            'EMP_QR_IMG'	=> $urlImg,
            'EMP_QR_DATE'	=> $date
          );
    $this->db->insert('empresa_qr', $data);
    }

    public function updateEmpresaQRCampo($idEmpresa, $campo, $valor)
    {
    $array = array(
                        $campo => $valor
              );
    $this->db->where('EMPRESA_ID', $idEmpresa);
    $this->db->update('empresa_qr', $array);
  }

} 