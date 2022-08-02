<?php
defined('BASEPATH') or exit('No direct script access allowed');

class His_common_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_his_global','his');
        $this->load->library('modal_variables');
        $this->load->library('pagination');
    }

    public function getAllRekanan() {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            $records = $this->his->getRowsMsRekanan();

            foreach($records as $row ){
                $response[] = array(
                                    "rekanan_id"=>$row->REKANAN_ID, 
                                    "rekanan_nama"=>$row->REKANAN_NAMA
                                );
            }

            // $response[] = array(
            //     "rekanan_id"=>'test_id', 
            //     "rekanan_nama"=>'test_nama'
            // );
            $data = $response;
            echo json_encode($data);
        }
    }

}