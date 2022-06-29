<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Medrec_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_ora_medrec', 'mr');
        $this->load->library('modal_variables');
        $this->load->library('pagination');
        $this->load->helper('download');
    }

    function getDataMR()
    {
        $mr = $this->input->post('mr');
        $get = $this->mr->getMedrec($mr);

        $result = array(
            'MR' => $get->MR,
            'NAMA' => $get->NAMA,
            'TEMPAT_LAHIR' => $get->TEMPAT_LAHIR,
            'TGL_LAHIR' => $get->TGL_LAHIR,
            'ALAMAT' => $get->ALAMAT
        );

        $data = $result;
        echo json_encode($data);
    }

    function getDataEmployee()
    {
        $search = $this->input->post('search');
        $records = $this->mr->getEmployee($search);

        foreach($records as $row ){
            $response[] = array("id"=>'PLAY_' . $row->NO_KAR, "nokar"=>$row->NO_KAR, "dept"=>$row->BAGIAN, "label"=>$row->NAMA_KAR);
        }
        $data = $response;
        echo json_encode($data);
    }

    function saveMrBorrow()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $lokasi_id = $this->session->userdata('lokasi_id');
            $medrec = $lokasi_id . $this->input->post('medrec');
            $nokar_peminjam = $this->input->post('nokar_peminjam');
            $keperluan = $this->input->post('keperluan');
            $dept_peminjam = $this->input->post('dept_peminjam');

            $created_by = $this->input->post('created_by');
            $diserahkan_oleh = $this->input->post('diserahkan_oleh');
            $tgl_peminjaman = $this->input->post('tgl_peminjaman');
            $tgl_janji_kembali = $this->input->post('tgl_janji_kembali');

            $get = $this->mr->getTransPinjamMR();
            $result = array(
                'TRANSID' => 'TR' . $get->NOMOR
            );
            $trans_pinjam = $result['TRANSID'];
            $data[] = array(
                "medrec"=>$medrec,
                "nokar_peminjam"=>$nokar_peminjam,
                "keperluan"=>$keperluan,
                "dept_peminjam"=>$dept_peminjam,
                "created_by"=>$created_by,
                "diserahkan_oleh"=>$diserahkan_oleh,
                "tgl_peminjaman"=>$tgl_peminjaman,
                "tgl_janji_kembali"=>$tgl_janji_kembali,
                "trans_pinjam"=>$trans_pinjam
            );

            $insert = $this->mr->savePinjamMR( 
                                                $medrec,
                                                $nokar_peminjam,
                                                $keperluan,
                                                $dept_peminjam,
                                                $created_by,
                                                $diserahkan_oleh,
                                                $tgl_peminjaman,
                                                $tgl_janji_kembali,
                                                $trans_pinjam
                                            );
            echo json_encode($data);
        }else{
            redirect(base_url('auth'));
        }
    }

    function loadPinjamMR($pageno = 0)
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $page_start = $this->input->post('page_start');
            $per_page = $this->input->post('per_page');
            $showitem = $this->input->post('showitem');
            $status = $this->input->post('status');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');           
            $keyword = $this->input->post('keyword'); ;
            $trans_id = $this->input->post('trans_id'); ;

            $showitem = 1;
            if($pageno != 0) {
                $pageno = ($pageno-1) * $per_page;
            }

            $countrecords =  $this->mr->getRowCountPinjamMR($showitem, $status, $from_date, $to_date);
            $records = $this->mr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $from_date, $to_date, $keyword, $trans_id);
          
            foreach($records as $row ){
                $response[] = array(
                                    "no"=>$row->RNUM, 
                                    "medrec"=>$row->MEDREC, 
                                    "pasien"=>$row->PASIEN,
                                    "peminjam"=>$row->PEMINJAM,
                                    "tgl_janji_kembali"=>$row->TGL_JANJI_KEMBALI,
                                    "tgl_pinjam"=>$row->TGL_PINJAM,
                                    "trans_pinjam"=>$row->TRANS_PINJAM_MR
                                );
            }

            $config['base_url'] = base_url('functions/loadPinjamMR/' . $pageno);
            $config['total_rows'] = $countrecords;
            $config['use_page_numbers'] = TRUE;
            $config['per_page'] = $per_page;
            
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center" id="mrReturn-pagination">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tag_close']  = '</span></li></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tag_close']  = '</span></li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tag_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            
            $this->pagination->initialize($config);
            $num1 = $page_start;
            if ($per_page != '') { 
                $num2 = $page_start + $per_page;
            } else {
                $num2 = $countrecords;
            }
            
            echo json_encode(array("response" => $response, "count" => $countrecords, "pagination" => $this->pagination->create_links(), "start_from" => $num1, "end_to" =>$num2));
            // echo json_encode(array("response" => $response, "page_start" => $page_start, "per_page" => $per_page, "showitem" => $showitem, "countrecords" => $countrecords));
        }else{
            redirect(base_url('auth'));
        }
    }

    public function createExcelPinjamMR() {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $page_start = $this->input->post('page_start');
            $per_page = $this->input->post('per_page');
            $showitem = $this->input->post('showitem');
            $status = $this->input->post('status');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $keyword = "";
            $trans_id = "";

            // $fileName = "Laporan" . $from_date . "-" . $to_date . ".xlsx";   
            $records = $this->mr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $from_date, $to_date, $keyword, $trans_id);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'NO');
            $sheet->setCellValue('B1', 'MEDREC');
            $sheet->setCellValue('C1', 'NAMA PASIEN');
            $sheet->setCellValue('D1', 'NAMA PEMINJAM');
            $sheet->setCellValue('E1', 'TGL PINJAM');   
            $sheet->setCellValue('F1', 'TGL JANJI KEMBALI');
            $sheet->setCellValue('G1', 'KEPERLUAN');
            $sheet->setCellValue('H1', 'DISERAHKAN OLEH');
            $sheet->setCellValue('I1', 'TGL PENGEMBALIAN');
            $sheet->setCellValue('J1', 'DIKEMBALIKAN OLEH');
            $sheet->setCellValue('K1', 'TRANS ID');
            $numrows = 2;
            foreach ($records as $row){
                $sheet->setCellValue('A' . $numrows, $row->RNUM);
                $sheet->setCellValue('B' . $numrows, $row->MEDREC);
                $sheet->setCellValue('C' . $numrows, $row->PASIEN);
                $sheet->setCellValue('D' . $numrows, $row->PEMINJAM);
                $sheet->setCellValue('E' . $numrows, $row->TGL_PINJAM);
                $sheet->setCellValue('F' . $numrows, $row->TGL_JANJI_KEMBALI);
                $sheet->setCellValue('G' . $numrows, $row->KEPERLUAN);
                $sheet->setCellValue('H' . $numrows, $row->DISERAHKAN_OLEH);
                $sheet->setCellValue('I' . $numrows, $row->TGL_AKHIR_KEMBALI);
                $sheet->setCellValue('J' . $numrows, $row->DIKEMBALIKAN_OLEH);
                $sheet->setCellValue('K' . $numrows, $row->TRANS_PINJAM_MR);
                $numrows++;
            } 

            $writer = new Xlsx($spreadsheet);
            $fileName = "Laporan Peminjaman " . $from_date . "-" . $to_date . ".xlsx";
            $url = "assets/upload/";

            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0'); 

            $writer->save("assets/upload/".$fileName);
            // $this->downloadSpreadsheet($url, $fileName);
            // $writer->save('php://output');
            $url = base_url("assets/upload/".$fileName);
            // redirect(base_url("assets/upload"));
            echo json_encode(array("url" => $url));  
        }else{
            redirect(base_url('auth'));
        }     
    }
    
    public function createPDFPinjamMR() {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $page_start = $this->input->post('page_start');
            $per_page = $this->input->post('per_page');
            $showitem = $this->input->post('showitem');
            $status = $this->input->post('status');
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $keyword = "";
            $trans_id = "";

            // $fileName = "Laporan" . $from_date . "-" . $to_date . ".xlsx";   
            $records = $this->mr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $from_date, $to_date, $keyword, $trans_id);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'NO');
            $sheet->setCellValue('B1', 'MEDREC');
            $sheet->setCellValue('C1', 'NAMA PASIEN');
            $sheet->setCellValue('D1', 'NAMA PEMINJAM');
            $sheet->setCellValue('E1', 'TGL PINJAM');   
            $sheet->setCellValue('F1', 'TGL JANJI KEMBALI');
            $sheet->setCellValue('G1', 'KEPERLUAN');
            $sheet->setCellValue('H1', 'DISERAHKAN OLEH');
            $sheet->setCellValue('I1', 'TGL PENGEMBALIAN');
            $sheet->setCellValue('J1', 'DIKEMBALIKAN OLEH');
            $sheet->setCellValue('K1', 'TRANS ID');
            $numrows = 2;
            foreach ($records as $row){
                $sheet->setCellValue('A' . $numrows, $row->RNUM);
                $sheet->setCellValue('B' . $numrows, $row->MEDREC);
                $sheet->setCellValue('C' . $numrows, $row->PASIEN);
                $sheet->setCellValue('D' . $numrows, $row->PEMINJAM);
                $sheet->setCellValue('E' . $numrows, $row->TGL_PINJAM);
                $sheet->setCellValue('F' . $numrows, $row->TGL_JANJI_KEMBALI);
                $sheet->setCellValue('G' . $numrows, $row->KEPERLUAN);
                $sheet->setCellValue('H' . $numrows, $row->DISERAHKAN_OLEH);
                $sheet->setCellValue('I' . $numrows, $row->TGL_AKHIR_KEMBALI);
                $sheet->setCellValue('J' . $numrows, $row->DIKEMBALIKAN_OLEH);
                $sheet->setCellValue('K' . $numrows, $row->TRANS_PINJAM_MR);
                $numrows++;
            } 

            $reader = new Pdf($spreadsheet);
            $fileName = "Laporan Peminjaman " . $from_date . "-" . $to_date . ".pdf";
            $url = "assets/upload/";

            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0'); 

            // $this->downloadSpreadsheet($url, $fileName);
            // $writer->save('php://output');
            $url = base_url("assets/upload/".$fileName);
            // redirect(base_url("assets/upload"));
            echo json_encode(array("url" => $url));  
        }else{
            redirect(base_url('auth'));
        }     
    }

    function getPinjamMR()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $trans_pinjam_mr = $this->input->post('trans_pinjam_mr');

            $get = $this->mr->getDataPinjamMR($trans_pinjam_mr);

            $result = array(
                'mr' => $get->MR,
                'medrec' => $get->MEDREC,
                'pasien' => $get->PASIEN,
                'tempat_lahir' => $get->TEMPAT_LAHIR,
                'tgl_lahir' => $get->TGL_LAHIR,
                'no_hp' => $get->NO_HP,
                'alamat' => $get->ALAMAT,
                'peminjam' => $get->PEMINJAM,
                'pemberi_pinjam' => $get->DISERAHKAN_OLEH,
                'keperluan' => $get->KEPERLUAN,
                'tgl_pinjam' => $get->TGL_PINJAM,
                'tgl_janji_kembali' => $get->TGL_JANJI_KEMBALI

            );

        $data = $result;
        echo json_encode($data);
        }
    }

    function updateReturnMR()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {        
            $trans_pinjam = $this->input->post('trans_pinjam');
            $returnBy = 'PLAY_' . $this->input->post('returnBy');
            $returnDesc = $this->input->post('returnDesc');
            $receiveBy = $this->session->userdata('user_id');

            $update = $this->mr->updatePinjamMR( 
                $trans_pinjam,
                $returnBy,
                $returnDesc,
                $receiveBy
            );

            $data[] = array(
                "trans_pinjam"=>$trans_pinjam,
                "returnBy"=>$returnBy,
                "receiveBy"=>$receiveBy
            );
            echo json_encode($data);
        }else{
            redirect(base_url('auth'));
        }
    }

    function deleteReturnMR()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {        
            $trans_pinjam = $this->input->post('trans_pinjam');
            $deleteBy = $this->session->userdata('user_id');

            $delete = $this->mr->deletePinjamMR( 
                $trans_pinjam,
                $deleteBy
            );

            $data[] = array(
                "trans_pinjam"=>$trans_pinjam,
                "deleteBy"=>$deleteBy
            );
            echo json_encode($data);
        }else{
            redirect(base_url('auth'));
        }
    }

    public function downloadSpreadsheet($url = NULL, $filename = NULL) {
        // read file contents
        $data = file_get_contents(base_url($url.$filename));
        force_download($filename, $data);
    }

    function getAutoMrReturn()
    {
        $page_start = 1;
        $per_page = "";
        $showitem = 1;
        $status = "not return";
        $from_date = "";
        $to_date = "";
        $keyword = $this->input->post('keyword');
        $trans_id = "";

        $records = $this->mr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $from_date, $to_date, $keyword, $trans_id);

        foreach($records as $row ){
            $response[] = array("id"=>$row->TRANS_PINJAM_MR, "label"=>$row->MEDREC . ' - ' . $row->PASIEN);
        }
        $data = $response;
        echo json_encode($data);
    }

}