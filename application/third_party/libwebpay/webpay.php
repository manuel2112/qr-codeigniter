<?php

/**
 * @author     Allware Ltda. (http://www.allware.cl)
 * @copyright  2015 Transbank S.A. (http://www.tranbank.cl)
 * @date       Jan 2015
 * @license    GNU LGPL
 * @version    2.0.2
 */

// require_once( APPPATH.'/third_party/libwebpay/soap/soap-wsse.php');
// require_once( APPPATH.'/third_party/libwebpay/soap/soap-validation.php');
// require_once( APPPATH.'/third_party/libwebpay/soap/soapclient.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/SoapValidation.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/WSSESoap.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/WSSecuritySoapClient.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/XMLSecurityKey.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/XMLSecurityDSig.php');
require_once( APPPATH.'/third_party/libwebpay/soap2/XMLSecEnc.php');

include( APPPATH.'/third_party/libwebpay/configuration.php');
include( APPPATH.'/third_party/libwebpay/webpay-normal.php');
include( APPPATH.'/third_party/libwebpay/webpay-mall-normal.php');
include( APPPATH.'/third_party/libwebpay/webpay-nullify.php');
include( APPPATH.'/third_party/libwebpay/webpay-capture.php');
include( APPPATH.'/third_party/libwebpay/webpay-oneclick.php');
include( APPPATH.'/third_party/libwebpay/webpay-complete.php');

class Webpay {

    var $configuration, $webpayNormal, $webpayMallNormal, $webpayNullify, $webpayCapture, $webpayOneClick, $webpayCompleteTransaction;

    function __construct($params) {

        $this->configuration = $params;
    }

    public function getNormalTransaction() {
        if ($this->webpayNormal == null) {
            $this->webpayNormal = new WebPayNormal($this->configuration);
        }
        return $this->webpayNormal;
    }

    public function getMallNormalTransaction() {
        if ($this->webpayMallNormal == null) {
            $this->webpayMallNormal = new WebPayMallNormal($this->configuration);
        }
        return $this->webpayMallNormal;
    }

    public function getNullifyTransaction() {
        if ($this->webpayNullify == null) {
            $this->webpayNullify = new WebpayNullify($this->configuration);
        }
        return $this->webpayNullify;
    }

    public function getCaptureTransaction() {
        if ($this->webpayCapture == null) {
            $this->webpayCapture = new WebpayCapture($this->configuration);
        }
        return $this->webpayCapture;
    }

    public function getOneClickTransaction() {
        if ($this->webpayOneClick == null) {
            $this->webpayOneClick = new WebpayOneClick($this->configuration);
        }
        return $this->webpayOneClick;
    }

    public function getCompleteTransaction() {
        if ($this->webpayCompleteTransaction == null) {
            $this->webpayCompleteTransaction = new WebpayCompleteTransaction($this->configuration);
        }
        return $this->webpayCompleteTransaction;
    }

}

class baseBean {
    
}

class getTransactionResult {

    var $tokenInput; //string

}

class getTransactionResultResponse {

    var $return; //transactionResultOutput

}
