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
            $tgl_janji_kembali = $this->input->post('tgl_janji_kembali');
            $catatan = $this->input->post('catatan');

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
                "tgl_janji_kembali"=>$tgl_janji_kembali,
                "catatan"=>$catatan,
                "trans_pinjam"=>$trans_pinjam
            );

            $insert = $this->mr->savePinjamMR( 
                                                $medrec,
                                                $nokar_peminjam,
                                                $keperluan,
                                                $dept_peminjam,
                                                $created_by,
                                                $diserahkan_oleh,
                                                $tgl_janji_kembali,
                                                $catatan,
                                                $trans_pinjam
                                            );
            echo json_encode($data);
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
            $receiveBy = $this->session->userdata('user_id');

            $update = $this->mr->updatePinjamMR( 
                $trans_pinjam,
                $returnBy,
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

}