<?php
    $batal = 'N';
    $jml_dr = 0;
    $resep = 'N';
    $selesai = 'N';
    $per_page = '';
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $pagestart = $this->uri->segment(4) + 1;
        } else {
            $pagestart = 1;
        }
    }
    $countrows =  $this->mctr->getRowcountMonitor($batal, $jml_dr, $resep, $selesai);
    $rows = $this->mctr->getMonitor($batal, $jml_dr, $resep, $selesai, $pagestart, $per_page);
    
    $i= 0;
    $tb = '';
    $tb.= '<div class="tb">';

    $tb.= '<div class="tb-header">';
    $tb.= '<div class="row">';
    $tb.= '<div class="col-md-1">NO.</div>';
    $tb.= '<div class="col-md-1">MEDREC</div>';
    $tb.= '<div class="col-md-3">PASIEN</div>';
    $tb.= '<div class="col-md-3">DOKTER</div>';
    $tb.= '<div class="col-md-1">NO URUT</div>';
    $tb.= '<div class="col-md-1">NO STRUK</div>';
    $tb.= '<div class="col-md-2">JAM</div>';
    $tb.= '</div>';      
    $tb.= '</div>'; 

    $tb.= '<div class="tb-body">';
    foreach($rows as $pm) {
    $tb.= '<div class="row border-bottom ' . ($i%2 ? 'odd':'even') . '">';
    $tb.= '<div class="col-md-1">' . $pm->RNUM . '</div>';
    $tb.= '<div class="col-md-1">' . $pm->PID . '</div>';
    $tb.= '<div class="col-md-3">' . $pm->PASIEN . '</div>';
    $tb.= '<div class="col-md-3">' . $pm->DOKTER . '</div>';
    $tb.= '<div class="col-md-1">' . $pm->NO_URUT . '</div>';
    $tb.= '<div class="col-md-1">' . $pm->NO_BUKTI . '</div>';
    $tb.= '<div class="col-md-2">' . $pm->JAM . '</div>';
    $tb.= '</div>';
    $i++;
    }   
    $tb.= '</div>'; 

    $tb.= '</div>';

    $config['base_url'] = base_url('counter/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $countrows;
    $config['per_page'] = $per_page;

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close']  = '</span></li></li>';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
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