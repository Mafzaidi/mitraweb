<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_app_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_form_application','mfa');
        $this->load->model('m_his_global','his');
		$this->load->model('m_user', 'mu');
        $this->load->library('modal_variables');
        $this->load->library('pagination');
        $this->load->helper('file');
    }

    public function loadInpatientFile($pageno = 0) 
	{
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {         
            $page_start = $this->input->post('page_start');
            $per_page = $this->input->post('per_page');
            $keyword = $this->input->post('keyword');;
            $reg_id = $this->input->post('reg_id');

            if($pageno != 0) {
                $pageno = ($pageno-1) * $per_page;
            }
            
            $countrecords =  $this->mfa->getRowCountCurrentInpatient($keyword, $reg_id);
            $records = $this->mfa->getRowCurrentInpatient($page_start, $per_page, $keyword, $reg_id);

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
                                    "reg_berkas" => $row->REG_BERKAS,
                                    "list_reg" => $row->LIST_REG,
                                    "high_priority" => $row->HIGH_PRIORITY,
                                    "medium_priority" => $row->MEDIUM_PRIORITY,
                                    "low_priority" => $row->LOW_PRIORITY,
                                    "list_rek_templ" => $row->LIST_REK_TEMPL,
                                    "list_def_templ" => $row->LIST_DEF_TEMPL
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
                $num2 = ($page_start -1) + $per_page;
            } else {
                $num2 = $countrecords;
            }
            echo json_encode(array("response" => $response, "count" => $countrecords, "pagination" => $this->pagination->create_links(), "start_from" => $num1, "end_to" =>$num2, "per_page" =>$per_page));
        }
	}

    public function getInpatientFile() 
	{
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $reg_id = $this->input->post('reg_id');

            $get = $this->mfa->getDataCurrentInpatient($reg_id);
            $listRegBerkas = $this->mfa->getListRegBerkas($reg_id);
            // $dropMenu = $this->mfa->getBerkas();

            // $html = "";
            // foreach($dropMenu as $row) { 
            //     $response[] = array(
            //         "berkas_id"=>$row->BERKAS_ID,
            //         "keterangan"=>$row->KETERANGAN
            //     );  
            //     // $berkas = $row->BERKAS_ID;       
            //     // $html.= '<a class="dropdown-item" id="' . $row->BERKAS_ID . '"><i class="far fa-file-alt fa-sm fa-fw mr-2 text-gray-400"></i>' . $row->KETERANGAN . '</a>';
            // }

            // foreach($listTemplBerkas as $rowTempl) {
            //     $responseTempl[] = array(
            //         "berkas_id"=>$rowTempl->BERKAS_ID,
            //         "rekanan_id"=>$rowTempl->REKANAN_ID,
            //         "rekanan_nama"=>$rowTempl->REKANAN_NAMA,
            //         "url"=>$rowTempl->URL,
            //         "file_name"=>$rowTempl->FILE_NAME
            //     );
            // }

            foreach($listRegBerkas as $row) { 
                $response[] = array(
                    "berkas_id"=>$row->BERKAS_ID,
                    "keterangan"=>$row->KETERANGAN,
                    "template"=>$row->TEMPLATE,
                    "jenis"=>$row->JENIS,
                    "uploaded"=>$row->UPLOADED,
                    "uploaded_default"=>$row->UPLOADED_DEFAULT,
                    "uploaded_rekanan"=>$row->UPLOADED_REKANAN,
                    "list_rekid_tmpl"=>$row->LIST_REKID_TMPL,
                    "list_rekname_tmpl"=>$row->LIST_REKNAME_TMPL,
                    "list_template"=> $this->mfa->getTemplateBerkas($reg_id, $row->BERKAS_ID),
                    "registered"=>$row->REGISTERED,
                    "list_berkas_reg"=>$row->LIST_BERKAS_REG,
                    "file_name"=>$row->FILE_NAME,
                    "url"=>$row->URL,
                    "trans_id"=>$row->TRANS_ID,
                    "reg_id"=>$row->REG_ID
                );  
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
                'rekanan_id' => $get->REKANAN_ID,
                'rekanan_nama' => $get->REKANAN_NAMA,
                'reg_id' => $get->REG_ID,
                'listBerkas' => $response
                // ,'dropmenu' => $html
            );

        $data = $result;
        echo json_encode($data);
        }
    }

    function getAutoInpatientFile()
    {
        $page_start = 1;
        $per_page = "";
        $reg_id = "";
        $keyword = $this->input->post('keyword');

        $records = $this->mfa->getRowCurrentInpatient($page_start, $per_page, $keyword, $reg_id);

        foreach($records as $row ){
            $response[] = array("id"=>$row->REG_ID, "label"=>$row->MEDREC . ' - ' . $row->PASIEN);
        }
        $data = $response;
        echo json_encode($data);
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

    function checkTemplate()
    {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            // $thumb = new Imagick('http://10.101.4.99/mitraweb/assets/upload/templates/DEFAULT/2/LAPDIR_LAB.jpg');
            

            $reg_id = $this->input->post('reg_id');
            $berkas_id = $this->input->post('berkas_id');

            $records = $this->his->getRowsMsRekanan();
            $records2 = $this->mfa->getTemplateBerkas($reg_id, $berkas_id);
            

            foreach($records as $row ){
                $rekanan[] = array(
                                    "rekanan_id"=>$row->REKANAN_ID, 
                                    "rekanan_nama"=>$row->REKANAN_NAMA
                                );
            }

            if (empty($records2)) {
                $template = []; 
            } else {
                foreach($records2 as $row2 ){
                    $template[] = array(
                                        "berkas_id"=>$row2->BERKAS_ID,
                                        "rekanan_id"=>$row2->REKANAN_ID, 
                                        "rekanan_nama"=>$row2->REKANAN_NAMA
                                    );
                }
            }    

            echo json_encode(array("rekanan" => $rekanan, "template" => $template));
        }
    }

    function uploadTemplateTemp(){
        if((isset($_POST['rekanan_id']) && $_POST['rekanan_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
            $rekanan_id = $_POST['rekanan_id'];
            $rekanan_url = $_POST['rekanan_id'].'/';
			$berkas_id = $_POST['berkas_id'];
            $berkas_url = $_POST['berkas_id'].'/';
		} else {
			$rekanan_id = '';
            $berkas_id = '';
		}
		
		if (!is_dir('assets/upload/temp/'.$rekanan_url.$berkas_url)) {
			mkdir('assets/upload/temp/'.$rekanan_url.$berkas_url, 0777, TRUE);
		}
		
		$config['upload_path'] = 'assets/upload/temp/'.$rekanan_url.$berkas_url;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|xls|docx|xlsx';

		$this->load->library('upload', $config);
		$this->upload->do_upload('imageFile');
		
		$upload = $this->upload->data();		
		$data['path'] = $config['upload_path'];
		$data['imgUrl'] = 'assets/upload/temp/'.$upload['file_name'];
        
        $directory = 'assets/upload/temp/'.$rekanan_url.$berkas_url;
        $filecount = 0;
        $files = glob($directory . "*");
        if ($files){
            $filecount = count($files);
        }

        $data['filecount'] = $filecount;
        $data['fileName'] = $upload['file_name'];
        $data['rekanan_id'] = $rekanan_id;
        $data['berkas_id'] = $berkas_id;
		echo json_encode($data);
    }

    function uploadTemplate(){

		if((isset($_POST['rekanan_id']) && $_POST['rekanan_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
            $rekanan_id = $_POST['rekanan_id'];
            $rekanan_url = $_POST['rekanan_id'].'/';
			$berkas_id = $_POST['berkas_id'];
            $berkas_url = $_POST['berkas_id'].'/';
		} else {
			$rekanan_id = '';
            $berkas_id = '';
		}
		
		if (!is_dir('assets/upload/templates/'.$rekanan_url.$berkas_url)) {
			mkdir('assets/upload/templates/'.$rekanan_url.$berkas_url, 0777, TRUE);
		}
		
		$config['upload_path'] = 'assets/upload/templates/'.$rekanan_url.$berkas_url;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|xls|docx|xlsx';

		$this->load->library('upload', $config);
		$this->upload->do_upload('imageFile');
		
		$upload = $this->upload->data();		
		$data['path'] = $config['upload_path'];
		$data['imgUrl'] = 'assets/upload/templates/'.$upload['file_name'];
        $real_name = $_FILES['imageFile']['name'];
        
        $directory = 'assets/upload/templates/'.$rekanan_url.$berkas_url;
        $filecount = 0;
        $files = glob($directory . "*");
        if ($files){
            $filecount = count($files);
        }

        $data['filecount'] = $filecount;
        $data['fileName'] = $upload['file_name'];
        $data['rekanan_id'] = $rekanan_id;
        $data['berkas_id'] = $berkas_id;
        $data['real_name'] = $real_name;
		echo json_encode($data);
	}

    function uploadBerkasTemp(){

		if((isset($_POST['reg_id']) && $_POST['reg_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
            $reg_id = $_POST['reg_id'];
            $reg_url = $_POST['reg_id'].'/';
			$berkas_id = $_POST['berkas_id'];
            $berkas_url = $_POST['berkas_id'].'/';
		} else {
			$reg_id = '';
            $berkas_id = '';
		}
		
		if (!is_dir('assets/upload/temp/'.$reg_url.$berkas_url)) {
			mkdir('assets/upload/temp/'.$reg_url.$berkas_url, 0777, TRUE);
		}
		
		$config['upload_path'] = 'assets/upload/temp/'.$reg_url.$berkas_url;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|xls|docx|xlsx';

		$this->load->library('upload', $config);
		$this->upload->do_upload('imageFile');
		
		$upload = $this->upload->data();		
		$data['file_path'] = $config['upload_path'];
		$data['file_url'] = 'assets/upload/temp/'.$upload['file_name'];
        $real_name = $_FILES['imageFile']['name'];
        
        $directory = 'assets/upload/temp/'.$reg_url.$berkas_url;
        $filecount = 0;
        $files = glob($directory . "*");
        if ($files){
            $filecount = count($files);
        }

        $data['file_count'] = $filecount;
        $data['file_name'] = $upload['file_name'];
        $data['reg_id'] = $reg_id;
        $data['berkas_id'] = $berkas_id;
        $data['real_name'] = $real_name;
		echo json_encode($data);
	}

    function uploadBerkas(){

		if((isset($_POST['reg_id']) && $_POST['reg_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
            $reg_id = $_POST['reg_id'];
            $reg_url = $_POST['reg_id'].'/';
			$berkas_id = $_POST['berkas_id'];
            $berkas_url = $_POST['berkas_id'].'/';
		} else {
			$reg_id = '';
            $berkas_id = '';
		}
		
		if (!is_dir('assets/upload/docs/'.$reg_url.$berkas_url)) {
			mkdir('assets/upload/docs/'.$reg_url.$berkas_url, 0777, TRUE);
		}
		
		$config['upload_path'] = 'assets/upload/docs/'.$reg_url.$berkas_url;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|xls|docx|xlsx';

		$this->load->library('upload', $config);
		$this->upload->do_upload('imageFile');
		
		$upload = $this->upload->data();		
		$data['path'] = $config['upload_path'];
		$data['imgUrl'] = 'assets/upload/docs/'.$upload['file_name'];
        $real_name = $_FILES['imageFile']['name'];
        
        $directory = 'assets/upload/docs/'.$reg_url.$berkas_url;
        $filecount = 0;
        $files = glob($directory . "*");
        if ($files){
            $filecount = count($files);
        }

        $data['filecount'] = $filecount;
        $data['imgName'] = $upload['file_name'];
        $data['reg_id'] = $reg_id;
        $data['berkas_id'] = $berkas_id;
        $data['real_name'] = $real_name;
		echo json_encode($data);
	}

    function removeBerkas()
	{

		$directory = $_POST['currentPath'];
		$data = array(
			'fileName' => $_POST['currentFile'],
			'filePath' => $_POST['currentPath'],
			'req' => $_POST['requested'],
			'errMessage' => ''
		);
		if(is_dir($directory))
        {
            if (isset($data['fileName'])) {
                $files = glob($directory . "*");   
                if (count($files) > 0) {
                    if (unlink($data['filePath'].$data['fileName'])) {
                        $data['errMessage'] = 'file deleted';
                    } else {
                        $data['errMessage'] = 'error' . $data['fileName'];
                    }
                } else {   
                    rmdir($directory); // Delete the folder
                }
            }
        }
		
		echo json_encode($data);
	}

    function removeTemplBerkas()
	{

        $directory = $_POST['currentPath'];
		$data = array(
			'fileName' => $_POST['currentFile'],
			'filePath' => $_POST['currentPath'],
			'req' => $_POST['requested'],
			'errMessage' => ''
		);

        if(is_dir($directory))
        {
            if (isset($data['fileName'])) {
                $files = glob($directory . "*");   
                if (count($files) > 0) {
                    if (unlink($data['filePath'].$data['fileName'])) {
                        $data['errMessage'] = 'file deleted';
                    } else {
                        $data['errMessage'] = 'error' . $data['fileName'];
                    }
                } else {   
                    rmdir($directory); // Delete the folder
                }
            }
        }
		
		echo json_encode($data);
	}

    function saveBerkasMS(){
        $sess_id = $this->session->userdata('user_id');
        $user_id = $this->session->userdata('id');

        if(!empty($sess_id))
        {          
            $userOra = $this->mu->getDataOra('MS_KARYAWAN', ['NO_KAR' => $user_id])->row_array();
            if ($userOra) {
                $reg_id = $this->input->post('reg_id');

                $check = $this->mfa->CountRegiteredBerkas($reg_id);
                if ($check >= 1) 
                {                             
                    $generate = $this->mfa->getTransIdRegisteredBerkas($reg_id);
                } else {
                    $generate = $this->mfa->getTransRegBerkas();
                }
                $get = $this->mfa->getDataCurrentInpatient($reg_id);

                $trans_id = $generate->TRANS_ID;
                $mr = $get->MR;
                $created_date = "SYSDATE";
                $created_by = $this->session->userdata('user_id');
                $status = "1";
                $show_item = "1";

                $result = array(
                    "trans_id"=> $generate->TRANS_ID,
                    "mr"=> $get->MEDREC,
                    "reg_id"=> $get->REG_ID,
                    "created_by"=> $this->session->userdata('user_id')
                );

                if ($check >= 1) 
                {   
                } else {
                    $insert = $this->mfa->saveMsRegBerkas(
                        $trans_id,
                        $reg_id,
                        $mr,
                        $created_date,
                        $created_by,
                        $status,
                        $show_item
                    );
                }

                $data = $result;
                echo json_encode($data);
            } else {
                $data = new StdClass();
                $data->err = "002";
                $data->errMsg = "authorization for oracle user!";
                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('role_id');
                $this->session->unset_userdata('dept_id');
                $this->session->set_userdata('status','logout');
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                    User tidak berhak, gunakan user lain!
                    </div>');
                echo json_encode($data);
            }
        } else {
            $data = new StdClass();
            $data->err = "001";
            $data->errMsg = "session expired";
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Session anda telah habis, silahkan login kembali!
                </div>');
            echo json_encode($data);
        }
    }

    function saveBerkasDT(){
        $sess_id = $this->session->userdata('user_id');
        $user_id = $this->session->userdata('id');

        if(!empty($sess_id))
        {          
            $userOra = $this->mu->getDataOra('MS_KARYAWAN', ['NO_KAR' => $user_id])->row_array();
            if ($userOra) {         
                if((isset($_POST['reg_id']) && $_POST['reg_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
                    $reg_id = $this->input->post('reg_id');
                    $berkas_id = $this->input->post('berkas_id'); 
                    $trans_id = $this->input->post('trans_id');
                    $queue_item = $this->input->post('queue_item');
                    $created_date = "SYSDATE";
                    $created_by = $this->session->userdata('user_id');                            
                    $show_item = "1";
                    $status = "1";                 
                    $template = $this->input->post('template');

                    if((isset($_POST['template']) && $_POST['template'] != "")) {
                        if ($template === "Y") {
                            
                            $reg_url = $_POST['reg_id'].'/';
                            $berkas_url = $_POST['berkas_id'].'/';                 
                            $temp_file_path = $this->input->post('file_path');
                            $temp_file_name = $this->input->post('file_name');
                            $temp_real_name = $this->input->post('real_name');
                            $temp_url = $this->input->post('url');

                            $source_path = $temp_url;
                            $destination_path =  'assets/upload/docs/'.$reg_url.$berkas_url;

                            if (!is_dir('assets/upload/docs/'.$reg_url.$berkas_url)) {
                                mkdir('assets/upload/docs/'.$reg_url.$berkas_url, 0777, TRUE);
                            }
                            
                            if(!copy($source_path, $destination_path.$temp_file_name)) {
                                $result = array(
                                    "err" => "copy error!"
                                );                
                            }  
                            else {                
                                $file_path = $destination_path;
                                $url = $destination_path.$temp_file_name;
                                $file_name = $temp_file_name;
                                $real_name = $temp_real_name;
                                
                                // $result = array(
                                //     'TRANSID' => $generate->TRANS_ID
                                // );
                                // $trans_reg_berkas = $result['TRANSID'];
            
                                $result = array(
                                    "reg_id" => $reg_id,
                                    "trans_id"=> $trans_id,
                                    "berkas_id"=> $berkas_id,
                                    "queue_item"=> $queue_item,
                                    "file_path"=> $file_path,
                                    "file_name"=> $file_name,
                                    "real_name"=> $real_name,
                                    "url"=> $url,
                                    "created_date"=> $created_date,
                                    "created_by" => $created_by,
                                    "show_item" => $show_item,
                                    "status" => $status,
                                    "template" => $template
                                );
            
                                $insert = $this->mfa->saveDtRegBerkas(
                                    $trans_id,
                                    $berkas_id,
                                    $queue_item,
                                    $file_path,
                                    $file_name,
                                    $url,
                                    $created_date,
                                    $created_by,
                                    $show_item,
                                    $status,
                                    $real_name
                                );
                                // $data[] = array(
                                //     "trans_reg_berkas"=> $trans_reg_berkas,
                                //     "reg_id"=> $reg_id,
                                //     "mr"=> $get->MEDREC,
                                //     "created_by"=> $this->session->userdata('user_id')
                                // );
                                
                                $data = $result;
                                echo json_encode($data); 
                            }
                        } else {
                            $real_name = "";
                            $result = array(
                                "reg_id" => $reg_id,
                                "trans_id"=> $trans_id,
                                "berkas_id"=> $berkas_id,
                                "queue_item"=> $queue_item,
                                "file_path"=> "",
                                "file_name"=> "",
                                "url"=> "",
                                "created_date"=> $created_date,
                                "created_by" => $created_by,
                                "show_item" => $show_item,
                                "status" => $status,
                                "template" => $template
                            );
        
                            $insert = $this->mfa->saveDtRegBerkas(
                                $trans_id,
                                $berkas_id,
                                $queue_item,
                                "",
                                "",
                                "",
                                $created_date,
                                $created_by,
                                $show_item,
                                $status,
                                $real_name
                            );
        
                            $data = $result;
                            echo json_encode($data); 
                        }
                    } else {
                        $result = array(
                            "err" => "data error!"
                        ); 
                    }          
                } else {
                    $result = array(
                        "err" => "data error!"
                    );  
                }
            } else {
                $data = new StdClass();
                $data->err = "002";
                $data->errMsg = "authorization for oracle user!";
                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('role_id');
                $this->session->unset_userdata('dept_id');
                $this->session->set_userdata('status','logout');
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                    User tidak berhak!
                    </div>');
                echo json_encode($data);
            }
        } else {
            $data = new StdClass();
            $data->err = "001";
            $data->errMsg = "session expired";
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Session anda telah habis!
                </div>');
            echo json_encode($data);
        }
    }

    function saveBerkasTemplate(){
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {          
            if((isset($_POST['rekanan_id']) && $_POST['rekanan_id'] != "") && (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){

                $rekanan_id = $this->input->post('rekanan_id');
                $rekanan_nama = $this->input->post('rekanan_nama');
                $berkas_id = $this->input->post('berkas_id');
                $berkas_name = $this->input->post('berkas_name');
                $temp_file_path = $this->input->post('file_path');
                $temp_file_name = $this->input->post('file_name');
                $temp_url = $this->input->post('url');
                $rekanan_url = $rekanan_id.'/';
                $berkas_url = $berkas_id.'/';
                $tittle = "TEMPLATE ".$berkas_name." ".$rekanan_nama;
                $desc = $this->input->post('desc');

                $source_path = $temp_url;
                $destination_path =  'assets/upload/templates/'.$rekanan_url.$berkas_url;
                
                $show_item = '1';
                
                $countrecords =  $this->mfa->countTemplateBerkas($berkas_id, $rekanan_id);
            } 
            
            if (!is_dir('assets/upload/templates/'.$rekanan_url.$berkas_url)) {
                mkdir('assets/upload/templates/'.$rekanan_url.$berkas_url, 0777, TRUE);
            }

            if(!copy($source_path, $destination_path.$temp_file_name)) {
                $result = array(
                    "err" => "copy error!"
                );                
            }  
            else {  
                $file_path = $destination_path;
                $url = $destination_path.$temp_file_name;
                $file_name = $temp_file_name;
                $created_date = "SYSDATE";
                $created_by = $this->session->userdata('user_id');

                if ($countrecords > 0) {
                    $update = $this->mfa->updateDtBerkasTemplate_notActive($berkas_id, $rekanan_id);
                    if ($update["errMess"] == "") {
                        $insert = $this->mfa->saveDtBerkasTemplate(
                            $berkas_id,
                            $rekanan_id,
                            $tittle,
                            $file_path,
                            $file_name,
                            $url,
                            $created_date,
                            $created_by,
                            $show_item
                        );
                        $result = array(
                            "rekanan_id" => $rekanan_id,
                            "rekanan_nama" => $rekanan_nama,
                            "berkas_id"=> $berkas_id,
                            "berkas_name"=> $berkas_name,
                            "tittle"=> $tittle,
                            "desc"=> $desc,
                            "file_path"=> $file_path,
                            "file_name"=> $file_name,
                            "url"=> $url,
                            "destinationPath" => $destination_path
                        );
                    }
                } else {
                    $insert = $this->mfa->saveDtBerkasTemplate(
                        $berkas_id,
                        $rekanan_id,
                        $tittle,
                        $file_path,
                        $file_name,
                        $url,
                        $created_date,
                        $created_by,
                        $show_item
                    );
                    $result = array(
                        "rekanan_id" => $rekanan_id,
                        "rekanan_nama" => $rekanan_nama,
                        "berkas_id"=> $berkas_id,
                        "berkas_name"=> $berkas_name,
                        "tittle"=> $tittle,
                        "desc"=> $desc,
                        "file_path"=> $file_path,
                        "file_name"=> $file_name,
                        "url"=> $url,
                        "destinationPath" => $destination_path
                    );
                }
                
            } 
            
            $data = $result;
            echo json_encode($data);
        } else {

        }
    }

    function getRegBerkasDetail()
    {
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {   
            if(
                (isset($_POST['reg_id']) && $_POST['reg_id'] != "") && 
                (isset($_POST['trans_id']) && $_POST['trans_id'] != "") && 
                (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")
            ){
                $reg_id = $this->input->post('reg_id');
                $trans_id = $this->input->post('trans_id');
                $berkas_id = $this->input->post('berkas_id');
                
                $width = $this->input->post('width');
                $height = $this->input->post('height');
                $startX = $this->input->post('startX');
                $startY = $this->input->post('startY');

                $get = $this->mfa->getRegisteredBerkas($reg_id, $trans_id, $berkas_id);
                
                $im = new imagick($_SERVER['DOCUMENT_ROOT'] ."/mitraweb/" . $get->URL . "[0]");    
                // $im->resizeImage(200,0,1,0);
                // $im->cropImage($width, $height, $startX, $startY);
                $im->cropThumbnailImage( 200, 150 );
                $im->setImageFormat('jpg'); 
                $im->setbackgroundcolor('rgb(64, 64, 64)');
                $im->setImageCompression(Imagick::COMPRESSION_JPEG); 
                $im->setImageCompressionQuality(100);
                $im->unsharpMaskImage(0.5 , 1 , 1 , 0.05);  

                ob_start();
                $thumbnail = $im->getImageBlob();
                $contents =  ob_get_contents();
                ob_end_clean();
                $thumb = "<img class='mx-auto d-block rounded-top border border-bottom-0 pt-1 pr-1 pl-1 pb-0' src='data:image/jpg;base64,".base64_encode($thumbnail)."' />";

                $result = array(
                    "trans_id"=> $get->TRANS_ID,
                    "reg_id"=> $get->REG_ID,
                    "berkas_id"=> $get->BERKAS_ID,
                    "file_path"=> $get->FILE_PATH,
                    "file_name"=> $get->FILE_NAME,
                    "real_name"=> $get->REAL_FILE_NAME,
                    "url"=> $get->URL,
                    "upload_date"=> $get->UPLOAD_DATE,
                    "upload_by"=> $get->UPLOAD_BY,
                    "img"=> $im,
                    "thumb"=> $thumb
                );

                $data = $result;
                echo json_encode($data);
            }
        } else {
            redirect(base_url('auth'));
        }
    }

    function updateUploadedBerkas()
    {
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {   
            if((isset($_POST['trans_id']) && $_POST['trans_id'] != "") &&  (isset($_POST['berkas_id']) && $_POST['berkas_id'] != "")){
                $trans_id = $this->input->post('trans_id');
                $berkas_id = $this->input->post('berkas_id');
            }
        } else {
            redirect(base_url('auth'));
        }
    }


}