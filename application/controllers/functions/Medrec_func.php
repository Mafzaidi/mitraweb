<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medrec_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_ora_medrec', 'mr');
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
            $response[] = array("id"=>'PLAY_' . $row->NO_KAR, "dept"=>$row->BAGIAN, "label"=>$row->NAMA_KAR);
        }
        $data = $response;
        echo json_encode($data);
    }

    function saveMrBorrow()
    {
        $medrec = $this->input->post('medrec');
        $nokar_peminjam = $this->input->post('nokar_peminjam');
        $keperluan = $this->input->post('keperluan');
        $dept_peminjam = $this->input->post('dept_peminjam');

        $created_by = $this->input->post('created_by');
        $diserahkan_oleh = $this->input->post('diserahkan_oleh');
        $tgl_janji_kembali = $this->input->post('tgl_janji_kembali');
        $catatan = $this->input->post('catatan');

        $trans_id = $this->mr->getTransPinjamMR();
    }

}