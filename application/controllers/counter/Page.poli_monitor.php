<?php
    $batal = '';
    $jml_dr = 0;
    $resep = '';
    $selesai = '';
    $rows = $this->mctr->getMonitor($batal, $jml_dr, $resep, $selesai);
    $numrows =  count($this->mctr->getMonitor($batal, $jml_dr, $resep, $selesai));
    
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

    $config['base_url'] = 'http://example.com/index.php/test/page/';
    $config['total_rows'] = $numrows;
    $config['per_page'] = 20;

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = '&lt;';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '</span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tag_close']  = '</span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close']  = '</span></li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tag_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tag_close']  = '</span></li>';
    
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    $data['polimon'] = $tb;
?>