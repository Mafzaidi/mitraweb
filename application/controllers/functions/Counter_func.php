<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Counter_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_counter','mctr');
        $this->load->library('modal_variables');
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

    function searchMedrec() 
	{
        $mr = $this->input->post('mr');
        $name = $this->input->post('name');
        $birth_date = $this->input->post('birth_date');
        $telp = $this->input->post('telp');
        $address = $this->input->post('address');
        $parent = $this->input->post('parent');

        $records = $this->mctr->getRecordsMedrec($mr, $name, $birth_date, $telp, $address, $parent);
        
        $i= 0;
        $tb = '';
        $tb.= '<div class="tb">';

        $tb.= '<div class="tb-header">';
        $tb.= '<div class="row">';
        $tb.= '<div class="col-md-2">MEDREC</div>';
        $tb.= '<div class="col-md-2">NAMA</div>';
        $tb.= '<div class="col-md-2">TGL LAHIR</div>';
        $tb.= '<div class="col-md-2">NO HP</div>';
        $tb.= '<div class="col-md-4">ALAMAT</div>';;
        $tb.= '</div>';      
        $tb.= '</div>'; 

        $tb.= '<div class="tb-body">';
        foreach($records as $row ){
            // $response[] = array(
            //                 "mr"=>$row->MR, 
            //                 "name"=>$row->NAMA, 
            //                 "birth_date"=>$row->TGL_LAHIR,
            //                 "telp"=>$row->NO_HP,
            //                 "address"=>$row->ALAMAT,
            //                 "city"=>$row->KOTA,
            //                 "district"=>$row->KECAMATAN,
            //                 "village"=>$row->KELURAHAN
            //             );
            $tb.= '<div class="row border-bottom ' . ($i%2 ? 'odd':'even') . '">';
            $tb.= '<div class="col-md-2">' . $row->MR . '</div>';
            $tb.= '<div class="col-md-2">' . $row->NAMA . '</div>';
            $tb.= '<div class="col-md-2">' . $row->TGL_LAHIR . '</div>';
            $tb.= '<div class="col-md-2">' . $row->NO_HP . '</div>';
            $tb.= '<div class="col-md-4">' . $row->ALAMAT . '</div>';
            $tb.= '</div>';
            $i++;
        }    
        $tb.= '</div>'; 

        $tb.= '</div>';

        $data['html'] = $tb;
        echo json_encode($data);
    }
}