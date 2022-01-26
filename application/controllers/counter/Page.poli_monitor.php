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
    // $tb.= '<div class="tb" id="polimonTable">';

    // $tb.= '<div class="tb-header bg-cool text-light row">';
    // $tb.= '<div class="col-md-1 tb-label sort-col">NO.<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-1 tb-label sort-col">MEDREC<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-2 tb-label sort-col">PASIEN<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-3 tb-label sort-col">DOKTER<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-1 tb-label sort-col">URUT<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-1 tb-label sort-col">STRUK<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-2 tb-label sort-col">JAM<span class="sort-filter desc"></span></div>';
    // $tb.= '<div class="col-md-1 tb-label sort-col">DETAIL</div>';
    // $tb.= '</div>';

    // $tb.= '<div class="tb-body">';
    foreach($rows as $pm) {
        $statuscls = '';
        if ($pm->STATUS == 'COUNTER DAFTAR') {
            $statuscls = 'bg-primary-2';
        } else if ($pm->STATUS == 'DOKTER SELESAI') {
            $statuscls = 'bg-warning-2';
        } else if ($pm->STATUS == 'COUNTER SELESAI') {
            $statuscls = 'bg-success-2';
        } else if ($pm->STATUS == 'COUNTER BATAL') {
            $statuscls = 'bg-danger-2';
        } else {
        }
        $tb.= '<div class="row tb-row border-bottom ' . $statuscls . ' ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->RNUM . '</div>';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->PID . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $pm->PASIEN . '</div>';
        $tb.= '<div class="col-md-3 tb-cell">' . $pm->DOKTER . '</div>';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->NO_URUT . '</div>';
        $tb.= '<div class="col-md-1 tb-cell">' . $pm->NO_BUKTI . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $pm->JAM_DAFTAR . '</div>';
        $tb.= '<div class="col-md-1 tb-cell"><button type="button" class="btn btn-primary btn-sm btn-detail-polimon" mr="' . $pm->MR . '" dr="' . $pm->DOKTER_ID . '">Lihat</button></div>';
        $tb.= '</div>';
        $i++;
    }   
    // $tb.= '</div>'; 

    // $tb.= '</div>';

    //$config['base_url'] = base_url('functions/Counter_func/getDataPolimon');
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
    $data['polimon'] = $tb;
?>