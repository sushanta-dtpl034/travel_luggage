<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class phpspreadsheet_lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PhpOffice/PhpSpreadsheet/Spreadsheet.php';
        require_once APPPATH.'third_party/PhpOffice/PhpSpreadsheet/Writer/Xlsx.php';
        $sheet = new PHPSpreadsheet;
        return $sheet;
    }
}