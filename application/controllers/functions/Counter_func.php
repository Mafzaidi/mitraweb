<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Counter_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_counter','mctr');
        $this->load->library('modal_variables');
        $this->load->library('pagination');
    }

    public function getDataPolimon($pageno = 0) 
	{
        $ctr_daftar = $this->input->post('ctr_daftar');
        $dr_selesai = $this->input->post('dr_selesai');
        $ctr_selesai = $this->input->post('ctr_selesai');
        $ctr_batal = $this->input->post('ctr_batal');
        $jml_dr = $this->input->post('jml_dr');
        $ada_resep = $this->input->post('ada_resep');
        $ada_lab = $this->input->post('ada_lab');
        $ada_rad = $this->input->post('ada_rad');
        $page_start = $this->input->post('page_start');
        $per_page = $this->input->post('per_page');
        $search = $this->input->post('search');

        if($pageno != 0) {
            $pageno = ($pageno-1) * $per_page;
        }
        
        $countrecords =  $this->mctr->getRowcountMonitor(
                                                        $ctr_daftar,
                                                        $dr_selesai,
                                                        $ctr_selesai,
                                                        $ctr_batal,
                                                        $jml_dr,
                                                        $ada_resep,
                                                        $ada_lab,
                                                        $ada_rad,
                                                        $search
                                                    );
        $records = $this->mctr->getMonitor(
                                            $ctr_daftar,
                                            $dr_selesai,
                                            $ctr_selesai,
                                            $ctr_batal,
                                            $jml_dr,
                                            $ada_resep,
                                            $ada_lab,
                                            $ada_rad,
                                            $page_start,
                                            $per_page,
                                            $search
                                    );

        foreach($records as $row ){
            $response[] = array(
                                "no"=>$row->RNUM, 
                                "medrec"=>$row->PID, 
                                "pasien"=>$row->PASIEN,
                                "dokter"=>$row->DOKTER,
                                "no_urut"=>$row->NO_URUT,
                                "no_struk"=>$row->NO_BUKTI,
                                "jam_daftar"=>$row->JAM_DAFTAR,
                                "ctr_batal"=>$row->COUNTER_BATAL,
                                "ctr_selesai"=>$row->COUNTER_SELESAI,
                                "dr_selesai"=>$row->DOKTER_SELESAI,
                                "status"=>$row->STATUS,
                                "mr"=>$row->MR,
                                "dokter_id"=>$row->DOKTER_ID
                            );
        }

        $config['base_url'] = base_url('functions/getDataPolimon/' . $pageno);
        $config['total_rows'] = $countrecords;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = $per_page;
        
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center" id="polimon-pagination">';
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
        // $num2 = $countrecords;
        // if($this->uri->segment(3) <> ''){
        //     if($this->uri->segment(4) <> ''){
        //         $num2 = ($per_page + $this->uri->segment(4));
        //     } else {
        //         $num2 = $countrecords;
        //     }
        // }
        echo json_encode(array("response" => $response, "count" => $countrecords, "pagination" => $this->pagination->create_links(), "start_from" => $num1, "end_to" =>$num2));
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

        $tb.= '<div class="tb-header bg-cool">';
        $tb.= '<div class="row">';
        $tb.= '<div class="col-md-3">MEDREC</div>';
        $tb.= '<div class="col-md-3">NAMA</div>';
        $tb.= '<div class="col-md-2">TGL LAHIR</div>';
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
            $tb.= '<div class="col-md-3 py-1">';
            $tb.= '<input class="input-single-check" type="checkbox" value="' . $row->MR . '" id="' . $row->MR . '"><label for="' . $row->MR . '">' . $row->MR . '</label>';
            $tb.= '</div>';
            $tb.= '<div class="col-md-3 py-1">' . $row->NAMA . '</div>';
            $tb.= '<div class="col-md-2 py-1">' . $row->TGL_LAHIR . '</div>';
            $tb.= '<div class="col-md-4 py-1">' . $row->ALAMAT . '</div>';
            $tb.= '</div>';
            $i++;
        }    
        $tb.= '</div>'; 

        $tb.= '</div>';

        $data['html'] = $tb;
        echo json_encode($data);
    }

    function getMedrec() 
	{
        $mr = $this->input->post('mr');
        $get = $this->mctr->getRowMedrec($mr);

        $result = array(
            'mr' => $get->MR,
            'nama' => $get->NAMA,
            'tempat_lahir' => $get->TEMPAT_LAHIR,
            'tgl_lahir' => $get->TGL_LAHIR,
            'telp' => $get->NO_TELP,
            'hp' => $get->NO_HP,
            'alamat' => $get->ALAMAT,
            'kota' => $get->KOTA,
            'kecamatan' => $get->KECAMATAN,
            'kelurahan' => $get->KELURAHAN
        );

        $data = $result;
        echo json_encode($data);
    }
}