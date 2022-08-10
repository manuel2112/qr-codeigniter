<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('email_registro'))
{
	function email_registro($nombre,$email,$urlCodReg)
	{
		$asunto = 'REGISTRO FACILBAK QR';
		$info = email_body_registro($nombre,$urlCodReg);
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_pago'))
{
	function email_pago($buyOrder)
	{
		$ci = &get_instance();
		$ci->load->model('pago_model','empresa_model');
		$mdlPago 	= $ci->pago_model->getPagoRow( 'PAGO_ORDEN', $buyOrder );
		$mdlRequest = $ci->pago_model->getPagoRequestRow( 'PAGO_REQ_BUY_ORDER', $buyOrder );
		$mdlEmpresa = $ci->empresa_model->getEmpresaTblRow($mdlPago->EMPRESA_ID);
		$emailDestino = $mdlEmpresa->EMPRESA_EMAIL;

		$asunto = 'COMPROBANTE DE PAGO #'.$buyOrder;

		$mensaje  = email_header($buyOrder);
		$mensaje .= email_data('Orden en Compra', $buyOrder);
		$mensaje .= email_data('Plan',$mdlPago->MEMBRESIA_NOMBRE);
		$mensaje .= email_data('Meses',$mdlPago->PAGO_CANTIDAD);
		$mensaje .= email_data('Fecha',$mdlPago->PAGO_FECHA);
		$mensaje .= email_data('Método de pago','Webpay plus');
		$mensaje .= email_data('Tipo de Pago',tipoPago($mdlRequest->PAGO_REQ_PAY_TYPE_CODE));
		$mensaje .= email_data('Tarjeta N°','**** **** **** '.$mdlRequest->PAGO_REQ_CARD_NUMBER);
		$mensaje .= email_monto('Monto Neto',formatoDinero($mdlPago->PAGO_NETO));
		$mensaje .= email_monto('IVA',formatoDinero($mdlPago->PAGO_IVA));
		$mensaje .= email_monto('Monto Total',formatoDinero($mdlPago->PAGO_TOTAL));
		$mensaje .= email_aviso();
		$mensaje .= email_footer();
				
		return email_atributos($emailDestino,'',$asunto,$mensaje);
	}
}

if(!function_exists('email_formulario'))
{
	function email_formulario($nombre,$email,$plan,$mensaje,$asunto)
	{		
		$info = "<table border='1'>
					<tr><td>Empresa</td><td>".$nombre."</td></tr>
					<tr><td>Plan</td><td>".$plan."</td></tr>
					<tr><td>Email</td><td>".$email."</td></tr>
					<tr><td>Asunto</td><td>".$asunto."</td></tr>
					<tr><td>Mensaje</td><td>".$mensaje."</td></tr>
				</table>";				
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('formulario_contacto'))
{
	function formulario_contacto($nombre,$email,$mensaje)
	{
		$asunto = 'FORMULARIO DE CONTACTO';
		$info 	= "<table border='1'>
					<tr><td>Nombre</td><td>".$nombre."</td></tr>
					<tr><td>Email</td><td>".$email."</td></tr>
					<tr><td>Mensaje</td><td>".$mensaje."</td></tr>
					</table>";				
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_recuperaracion'))
{
	function email_recuperaracion($email,$nombre,$urlRec)
	{
		$asunto = 'RECUPERAR CONTRASEÑA';
		$info = email_recuperar_pass($nombre,$urlRec);
		return email_atributos($email,$nombre,$asunto,$info);
	}
}

if(!function_exists('email_atributos'))
{
	function email_atributos($email,$nombre,$asunto,$mensaje)
	{
		$attr = attEmail();
		$mail = new PHPMailer();
		$mail->CharSet  = "UTF-8";
		$mail->Encoding = 'base64';
		$mail->Host		= $attr->host;
		$mail->SMTPAuth = true;
		$mail->Username = $attr->username;
		$mail->Password = $attr->password;
		$mail->From		= $attr->from;
		$mail->FromName	= $attr->from;
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->AddAddress($email, $nombre);
		$mail->AddBCC($attr->from);
		$mail->AddBCC('manuel2112@hotmail.com');
		$mail->Subject	= $asunto;
		$mail->Body    	= $mensaje;
		$mail->AltBody 	= "Favor configurar su correo para leer HTML.";
		return $mail->Send();
	}
}