<?php
    $ctr_daftar = '';
    $dr_selesai = '';
    $ctr_selesai= '';
    $ctr_batal = '';
    $jml_dr = 0;
    $ada_resep = '';
    $ada_lab = '';
    $ada_rad = '';
    $per_page = '';
    $page_start = 1;
    $search = '';
    $check_ctr_daftar = '';
    $check_dr_selesai = '';
    $check_ctr_selesai = '';
    $check_ctr_batal = '';

    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $page_start = $this->uri->segment(4) + 1;
        } else {
            $page_start = 1;
        }
    }
    // var_dump($this->uri->segment(5));
    $countrows =  $this->mctr->getRowcountMonitor(
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
    $rows = $this->mctr->getMonitor(
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
    
    $i= 0;
    $tb = '';

    foreach($rows as $pm) {
        $statuscls = '';
        if ($pm->STATUS == 'COUNTER DAFTAR') {
            $statuscls = 'bg-primary-2';
            $check_ctr_daftar = $pm->STATUS;
        } else if ($pm->STATUS == 'DOKTER SELESAI') {
            $statuscls = 'bg-warning-2';
            $check_dr_selesai = $pm->STATUS;
        } else if ($pm->STATUS == 'COUNTER SELESAI') {
            $statuscls = 'bg-success-2';
            $check_ctr_selesai = $pm->STATUS;
        } else if ($pm->STATUS == 'COUNTER BATAL') {
            $statuscls = 'bg-danger-2';
            $check_ctr_batal = $pm->STATUS;
        } else {
        }
        $tb.= '<div class="row tb-row border-bottom ' . $statuscls . ' ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->RNUM . '</div>';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->PID . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $pm->PASIEN . '</div>';
        $tb.= '<div class="col-md-3 tb-cell">' . $pm->DOKTER . '</div>';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->NO_URUT . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $pm->NO_BUKTI . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $pm->JAM_DAFTAR . '</div>';
        $tb.= '</div>';
        $i++;
    }   

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
    $num1 = $page_start;
    $num2 = $countrows;
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $num2 = ($per_page + $this->uri->segment(4));
        } else {
            $num2 = $countrows;
        }
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $countrows;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['val_ctr_daftar'] = $check_ctr_daftar;
    $data['val_dr_selesai'] = $check_dr_selesai;
    $data['val_ctr_selesai'] = $check_ctr_selesai;
    $data['val_ctr_batal'] = $check_ctr_batal;
    $data['polimon'] = $tb;
?>