<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'third_party/endroid_qrcode/autoload.php';
		
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;

if(!function_exists('create_qr'))
{    
	function create_qr($idEmpresa)
	{
        $ci = &get_instance();
        $ci->load->model('empresa_model');
        $empresa    = $ci->empresa_model->getEmpresaRow($idEmpresa);
        $urlQR      = urlQR().$empresa->EMPRESA_SLUG;
        $logo       = $empresa->EMPRESA_LOGOTIPO;
        
        $qrCode = new QrCode($urlQR);
        $qrCode->setSize(480);
        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        if( $logo ){
            $qrCode->setLogoPath($logo);
            $qrCode->setLogoWidth(sizeLogoQr($logo));
        }
        $qrCode->setValidateResult(false);

        //CREAR DIRECTORIO SI NO EXISTE
        $directorio = "upload/empresas/".$idEmpresa."/qr/";
        createDir($directorio);

        // Save it to a file
        $aleatorio	= generaRandom();
        $urlImg 	= $directorio."qr_".$aleatorio.".png";        
        $qrCode->writeFile($urlImg);

        //INSERT/UPDATE IN DATABASE
        $ci->empresa_model->updateEmpresaQRCampo($idEmpresa, 'EMP_QR_FLAG', FALSE);
        $ci->empresa_model->insertEmpresaQR($idEmpresa,$urlImg,fechaNow());
        
        return $urlImg;
	}
}