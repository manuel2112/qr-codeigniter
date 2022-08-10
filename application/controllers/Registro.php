<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->layout->view('index');
	}

	public function ingreso()
	{
		$data  				= array();
		$data['ok'] 		= false;
		$data['errormail'] 	= false;

        $request    	= json_decode(file_get_contents('php://input'));
		$nombre	    	= $request->registro->nombre;
		$direccion  	= !empty($request->registro->direccion) ? $request->registro->direccion : null ;
		$ciudad	    	= $request->registro->ciudad;
		$fono	    	= $request->registro->fono;
		$email	    	= $request->registro->email;
		$pass	    	= md5($request->registro->pass01);
		$referido		= $request->registro->referido;
		$responsable	= $request->registro->responsable;

		$slug		= slugify($nombre);
		$slug		= $this->existeSlug($slug);
		$ingreso 	= fechaNow();
		$isAdmin	= false;
		$membresia	= true;
		$codReg		= generaRandom();

		$existeEmail = existeEmailRegistro($email);

		if( !$existeEmail ){
			
			//INGRESAR Y VALIDAR DATOS
			$idEmpresa = $this->empresa_model->insertEmpresa($nombre,$direccion,$fono,$email,$pass,$slug,$ciudad,$ingreso,$isAdmin,$membresia,$codReg,$referido,$responsable);
	
			//CREATE QR
			create_qr($idEmpresa);
	
			//INSTANCIAR MENÚ
			$this->instanciarMenu($idEmpresa);
	
			//REGALAR PLAN PLATA
			instanciarPlan($idEmpresa,$ingreso,2);
	
			//ENVIAR EMAIL PARA DAR EL ALTA
			$urlCodReg = urlAdmin()."login?cod=".$codReg;
			email_registro($nombre,$email,$urlCodReg);

			$data['ok'] = true;

		}else{
			$data['errormail'] = true;
		}

        echo json_encode($data);
	}

	public function existeEmail()
	{
		$data  		= array();
        $request    = json_decode(file_get_contents('php://input'));
		$email	    = $request->email;
		
		$data['existe'] = existeEmailRegistro($email);

        echo json_encode($data);

	}
	
	public function existeSlug($slug)
	{
		$query	= $this->empresa_model->getEmpresaExisteCampo('EMPRESA_SLUG',$slug);
		$existe = $query > 0 ? true : false;

		if( $existe ){
			$i = 1;
			while( $i <= 100 ){
				$newSlug = $slug.'-'.$i++;
				$query2	= $this->empresa_model->getEmpresaExisteCampo('EMPRESA_SLUG',$newSlug);
				$existe2 = $query2 > 0 ? true : false;

				if( !$existe2 ){
					return $newSlug;
				}
			}
		}

		return $slug;

	}
	
	public function nuevoSlug($slug,$i)
	{
		$newSlug = $slug.$i;
		existeSlug($slug,++$i);
	}
	
	public function instanciarMenu($idEmpresa)
	{
		//INSTANCIAR MENÚ
		$json = menuInstanciar();
		$data = json_decode($json,true);

		foreach($data as $item) {

			$imgGrupo = $item['imagen'] ? $item['imagen'] : null;
			$idGrupo = $this->menu_model->insertGrupo($idEmpresa,$item['grupo'],$item['imagen']);

			foreach( $item['producto'] as $producto ){
				
				$idProducto = $this->menu_model->insertProductoInt($idGrupo,$producto['nombre'],$producto['detalle'],$producto['descripcion'],$producto['link'],$producto['show']);

				foreach( $producto['precios'] as $precio ){					
					$this->menu_model->insertVariacionProductoIns($idProducto,$precio['nombre'],$precio['valor'],$precio['base'],$precio['show']);
				}

				foreach( $producto['imagenes'] as $imagen ){
					$this->menu_model->insertProductoImg($idProducto,$imagen['imagen']);
				}

			}

		}

	}	
	
}
