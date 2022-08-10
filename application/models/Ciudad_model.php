<?php
	
class ciudad_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
    public function getCiudad()
    {
        $query = $this->db
                        ->select("*")
                        ->from("geo_comunas")
                      	->order_by("comuna ASC")
                        ->get();
        return $query->result();       
    }
    
    public function getCiudadPorRegion($idRegion)
    {
        $where = array(
              "geo_regiones.id" => $idRegion
            );
        $query = $this->db
                        ->select("*")
                        ->from("geo_regiones ")
					              ->join('geo_provincias', 'geo_provincias.region_id = geo_regiones.id')
					              ->join('geo_comunas', 'geo_comunas.provincia_id = geo_provincias.id')
                        ->where($where)
                      	->order_by("geo_comunas.comuna ASC")
                        ->get();
        return $query->result();       
    }
    
    public function getRegion()
    {
        $query = $this->db
                        ->select("*")
                        ->from("geo_regiones")
                      	->order_by("id ASC")
                        ->get();
        return $query->result();       
    }
	
} 