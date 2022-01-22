<?php
    $ctr_batal = '';
    $ctr_selesai= '';
    $jml_dr = 0;
    $dr_selesai = '';
    $ada_resep = '';
    $ada_lab = '';
    $ada_rad = '';
    $per_page = 10;
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $pagestart = $this->uri->segment(4) + 1;    
        } else {
            $pagestart = 1;
        }
    }
    $countrows =  $this->mctr->getRowcountMonitor(
                                                    $ctr_batal, 
                                                    $ctr_selesai, 
                                                    $jml_dr, 
                                                    $dr_selesai, 
                                                    $ada_resep, 
                                                    $ada_lab, 
                                                    $ada_rad
                                                );
    $rows = $this->mctr->getMonitor(
                                        $ctr_batal, 
                                        $ctr_selesai, 
                                        $jml_dr, 
                                        $dr_selesai, 
                                        $ada_resep, 
                                        $ada_lab, 
                                        $ada_rad, 
                                        $pagestart, 
                                        $per_page
                                    );
    
    $i= 0;
    $tb = '';
    $tb.= '<div class="tb">';

    $tb.= '<div class="tb-header bg-cool">';
    $tb.= '<div class="row">';
    $tb.= '<div class="col-md-1">NO.</div>';
    $tb.= '<div class="col-md-1">MEDREC</div>';
    $tb.= '<div class="col-md-2">PASIEN</div>';
    $tb.= '<div class="col-md-3">DOKTER</div>';
    $tb.= '<div class="col-md-1">NO URUT</div>';
    $tb.= '<div class="col-md-1">NO STRUK</div>';
    $tb.= '<div class="col-md-2">JAM DAFTAR</div>';
    $tb.= '<div class="col-md-1">DETAIL</div>';
    $tb.= '</div>';      
    $tb.= '</div>'; 

    $tb.= '<div class="tb-body">';
    foreach($rows as $pm) {
        $statuscls = '';
        if ($pm->COUNTER_BATAL == 'Y') {
            $statuscls = 'bg-danger-2';
        } else if ($pm->COUNTER_SELESAI == 'Y') {
            $statuscls = 'bg-success-2';
        } else if ($pm->DOKTER_SELESAI == 'Y') {
            $statuscls = 'bg-warning-2';
        } else {
            $statuscls = 'bg-primary-2';
        }
        $tb.= '<div class="row border-bottom ' . $statuscls . ' ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= '<div class="col-md-1">' . $pm->RNUM . '</div>';
        $tb.= '<div class="col-md-1">' . $pm->PID . '</div>';
        $tb.= '<div class="col-md-2">' . $pm->PASIEN . '</div>';
        $tb.= '<div class="col-md-3">' . $pm->DOKTER . '</div>';
        $tb.= '<div class="col-md-1">' . $pm->NO_URUT . '</div>';
        $tb.= '<div class="col-md-1">' . $pm->NO_BUKTI . '</div>';
        $tb.= '<div class="col-md-2">' . $pm->JAM_DAFTAR . '</div>';
        $tb.= '<div class="col-md-1"><button>LIHAT</button></div>';
        $tb.= '</div>';
        $i++;
    }   
    $tb.= '</div>'; 

    $tb.= '</div>';

    $config['base_url'] = base_url('counter/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $countrows;
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
    $num1 = $pagestart;
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $num2 = ($pagestart + $per_page)-1;
        } else {
            $num2 = $countrows;
        }
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $countrows;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['polimon'] = $tb;
?>