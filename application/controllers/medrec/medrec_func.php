<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medrec_func extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->model('m_ora_medrec', 'mr');
	}

    function getDataMR() {
        $mr = $this->input->post('medrec');
        $get = $this->mr->getMedrec($mr);
        
        $result = array (
            'MR' => $get->MR,
            'NAMA' => $get->NAMA
        );
        // $data = array (
        //     'nama' => $mr
        // );
        $data['medrec'] = $get->MR;
        echo json_encode($data['medrec']);
    }
}