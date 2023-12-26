<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use Com\Tecnick\Barcode\Barcode;
use Com\Tecnick\Barcode\Exception;
// use Com\Tecnick\Barcode\Type;

require_once APPPATH.'third_party/qrcode/Barcode.php';
require_once APPPATH.'third_party/qrcode/Exception.php';
// require_once APPPATH.'third_party/qrcode/Type.php';

class Qrcode_lib
{
    // public function __construct(){
    //     log_message('Debug', 'Qr class is loaded.');
    // }

    public function generate($code){


            $barcode = new Barcode();

            $targetPath = "./upload/qr-code/";
            $text = $code;
            $simple_string = $code;
            // Store the cipher method
            $ciphering = "AES-128-CTR";
            // Use OpenSSl Encryption method
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            // Non-NULL Initialization Vector for encryption
            $encryption_iv = '1234567891011121';
           // Store the encryption key
            $encryption_key = "dahliatech";
            // Use openssl_encrypt() function to encrypt the data
            $encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
            $url_text = base_url()."Assetmanagement/ViewAssetDetails?ref_no=".$encryption;
           if (! is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
            }
            $bobj = $qr->getBarcodeObj('QRCODE,H',$url_text ,-4,-4, 'black', array(
            - 2,
            - 2,
            - 2,
            - 2
            ))->setBackgroundColor('#f0f0f0');

            $imageData = $bobj->getPngData();
            ///$timestamp = time();
            file_put_contents($targetPath.$code.'.png', $imageData);
            $file = $code.'.png';

    }

  
}