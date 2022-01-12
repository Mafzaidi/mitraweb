<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Counter_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->libaries('Modal_variables', 'mv');
        $this->load->model('m_counter','mctr');
    }

    public function getDataPolimon() 
	{
        $batal = $this->input->post('batal');
        $jml_dr = $this->input->post('jml_dr');
        $resep = $this->input->post('resep');
        $selesai = $this->input->post('selesai');
        $pagestart = $this->input->post('pagestart');
        $per_page = $this->input->post('per_page');
        
        $records = $this->mctr->getMonitor($batal, $jml_dr, $resep, $selesai, $pagestart, $per_page);

        foreach($records as $row ){
            $response[] = array("id"=>$row->NO_KAR, "dept"=>$row->BAGIAN, "label"=>$row->NAMA_KAR);
        }

        $data = $response;
        echo json_encode($data);
	}
}