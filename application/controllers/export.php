<?php defined('BASEPATH') OR die('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller {

     public function __construct()
     {
          parent::__construct();
          $this->load->model('m_ora_medrec', 'mr');
     }

     public function index()
     {
          $data['semua_pengguna'] = $this->export_model->getAll()->result();
          $this->load->view('export', $data);
     }

     public function export()
     {
          $semua_pengguna = $this->export_model->getAll()->result();

          $spreadsheet = new Spreadsheet;

          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('A1', 'No')
                      ->setCellValue('B1', 'Nama')
                      ->setCellValue('C1', 'Jenis Kelamin')
                      ->setCellValue('D1', 'Tanggal Lahir')
                      ->setCellValue('E1', 'Umur');

          $kolom = 2;
          $nomor = 1;
          foreach($semua_pengguna as $pengguna) {

               $spreadsheet->setActiveSheetIndex(0)
                           ->setCellValue('A' . $kolom, $nomor)
                           ->setCellValue('B' . $kolom, $pengguna->nama)
                           ->setCellValue('C' . $kolom, $pengguna->jenis_kelamin)
                           ->setCellValue('D' . $kolom, date('j F Y', strtotime($pengguna->tanggal_lahir)))
                           ->setCellValue('E' . $kolom, $pengguna->umur);

               $kolom++;
               $nomor++;

          }

          $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
	  header('Content-Disposition: attachment;filename="Latihan.xlsx"');
	  header('Cache-Control: max-age=0');

	  $writer->save('php://output');
     }
}