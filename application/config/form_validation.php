<?php

$config = array
(
    /*
    INGRESO LOGIN
    */
    'login'
    => array
            (
                array
                    (
                        'field'=>'usuario',
                        'label'=>'USUARIO',
                        'rules'=>'required|is_string|xss_clean|trim'
                    ),
                array
                    (
                        'field'=>'pass',
                        'label'=>'PASSWORD',
                        'rules'=>'required|is_string|xss_clean|trim'
                    )
            ),
	/*
    INGRESO CATEGORIAS
    */
    'categorias/insert'
    => array
            (
                array
                    (
                        'field'=>'categoria',
                        'label'=>'Categoria',
                        'rules'=>'required|is_string|trim|callback_categoriaExiste'
                    )
            ),
	/*
    UPDATE CATEGORIAS
    */
    'categorias/update'
    => array
            (
                array
                    (
                        'field'=>'categoria',
                        'label'=>'Categoria',
                        'rules'=>'required|is_string|trim|callback_categoriaExisteUpdate'
                    )
            ),
	/*
    INGRESO PRODUCTO/CLIENTE
    */
    'productos/insert'
    => array
            (
                array
                    (
                        'field'=>'nombre',
                        'label'=>'Nombre',
                        'rules'=>'required|is_string|trim|callback_productoExiste'
                    ),
                array
                    (
                        'field'=>'categorias',
                        'label'=>'Categoria',
                        'rules'=>'callback_categoriaSelect'
                    )
            ),
	/*
    UPDATE PRODUCTO/CLIENTE
    */
    'productos/update'
    => array
            (
                array
                    (
                        'field'=>'nombre',
                        'label'=>'Nombre',
                        'rules'=>'required|is_string|trim|callback_productoExisteUpdate'
                    ),
				array
                    (
                        'field'=>'descripcion',
                        'label'=>'Descripción',
                        'rules'=>'is_string|trim'
                    ),
                array
                    (
                        'field'=>'categorias',
                        'label'=>'Categoria',
                        'rules'=>'callback_categoriaSelect'
                    )
            ),
	/*
    INGRESO TESTER
    */
    'usuario/inserttester'
    => array
            (
                array
                    (
                        'field'=>'ruttester',
                        'label'=>'RUT',
                        'rules'=>'required|is_string|trim|callback_rutTesterValido|callback_rutTesterExiste'
                    ),
                array
                    (
                        'field'=>'nombretester',
                        'label'=>'NOMBRE',
                        'rules'=>'required|is_string|trim'
                    )
            ),
	/*
    INGRESO PRODUCTO/SOCIO
    */
    'productosocios/insert'
    => array
            (
                array
                    (
                        'field'=>'nombre',
                        'label'=>'Nombre',
                        'rules'=>'required|is_string|trim'
                    ),
                array
                    (
                        'field'=>'fecha_cierre',
                        'label'=>'FECHA DE CIERRE',
                        'rules'=>'required|is_string|trim'
                    )
            )
);

?>