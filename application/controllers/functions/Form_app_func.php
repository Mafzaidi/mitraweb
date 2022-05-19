<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_app_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_form_application','mfa');
        $this->load->library('modal_variables');
        $this->load->library('pagination');
    }

    public function loadInpatientFile($pageno = 0) 
	{
        $page_start = $this->input->post('page_start');
        $per_page = $this->input->post('per_page');

        if($pageno != 0) {
            $pageno = ($pageno-1) * $per_page;
        }
        
        $countrecords =  $this->mfa->getRowCountCurrentInpatient();
        $records = $this->mfa->getRowCurrentInpatient($page_start, $per_page);

        foreach($records as $row ){
            $response[] = array(
                                "no"=>$row->RNUM, 
                                "medrec"=>$row->MEDREC, 
                                "pasien"=>$row->PASIEN,
                                "ruang_id"=>$row->RUANG_ID,
                                "nama_dept"=>$row->NAMA_DEPT,
                                "nama_dr"=>$row->NAMA_DR,
                                "tgl_masuk"=>$row->TGL_MASUK,
                                "rekanan_nama"=>$row->REKANAN_NAMA,
                                "reg_id"=>$row->REG_ID,
                                "reg_berkas"=>$row->REG_BERKAS
                            );
        }

        $config['base_url'] = base_url('functions/Form_app_func/loadInpatientFile/' . $pageno);
        $config['total_rows'] = $countrecords;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = $per_page;
        
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end" id="inpatientFile-pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['prev_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li></li>';
        $config['num_tag_open']     = '<li class="page-item text-dark"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-dark">';
        $config['cur_tag_close']    = '</span></li>';
        $config['next_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
        $config['next_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item text-dark"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';

        
        $this->pagination->initialize($config);
        $num1 = $page_start;
        if ($per_page != '') { 
            $num2 = $page_start + $per_page;
        } else {
            $num2 = $countrecords;
        }
        echo json_encode(array("response" => $response, "count" => $countrecords, "pagination" => $this->pagination->create_links(), "start_from" => $num1, "end_to" =>$num2));
	}

    public function getInpatientFile() 
	{
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $reg_id = $this->input->post('reg_id');

            $get = $this->mfa->getDataCurrentInpatient($reg_id);
            $dropMenu = $this->mfa->getBerkas();

            $html = "";
            foreach($dropMenu as $row) {              
                $html.= '<a class="dropdown-item" id="' . $row->BERKAS_ID . '">' . $row->KETERANGAN . '</a>';
            }

            $result = array(
                'medrec' => $get->MEDREC,
                'pasien' => $get->PASIEN,
                'tgl_lahir' => $get->TGL_LAHIR,
                'umur' => $get->UMUR,
                'ruang_id' => $get->RUANG_ID,
                'nama_dept' => $get->NAMA_DEPT,
                'nama_dr' => $get->NAMA_DR,
                'tgl_masuk' => $get->TGL_MASUK,
                'rekanan_nama' => $get->REKANAN_NAMA,
                'dropmenu' => $html
            );

        $data = $result;
        echo json_encode($data);
        }
    }

    function checkPinjamMR()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $mr = $this->input->post('mr');
            $check = $this->mfa->getRowCountPinjamMr($mr);
            
        echo json_encode(array("check" => $check));
        }
    }

    function uploadBerkas(){

		if((isset($_POST['reg_id']) && $_POST['reg_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
            $reg_id = $_POST['reg_id'].'/';
			$berkas_id = $_POST['berkas_id'].'/';
		} else {
			$id = '';
		}
		
		if (!is_dir('assets/images/docs/'.$reg_id.$berkas_id)) {
			mkdir('assets/images/docs/'.$reg_id.$berkas_id, 0777, TRUE);
		}
		
		$config['upload_path'] = 'assets/images/docs/'.$reg_id.$berkas_id;
		$config['allowed_types'] = 'gif|jpg|png|pdf';

        $count_files=0;
        $ite=new RecursiveDirectoryIterator($config['upload_path']);

        foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
            $count_files++;
        }

        $new_name = $_POST['reg_id'] .'-'.$_POST['berkas_id'].'-'.($count_files > 0) ? $count_files : null;
        $config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->do_upload('imageFile');
		
		$upload = $this->upload->data();		
		$data['path'] = $config['upload_path'].$upload['file_name'];
		$data['imgUrl'] = 'assets/images/docs/'.$upload['file_name'];
		echo json_encode($data);
	}

}