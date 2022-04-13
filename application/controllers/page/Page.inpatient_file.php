<?php
    $per_page = 100;
    $page_start = 1;

    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $page_start = $this->uri->segment(4) + 1;
        } else {
            $page_start = 1;
        }
    }

    $row_count =  $this->mfa->getRowCountCurrentInpatient();
    $rows =  $this->mfa->getRowCurrentInpatient();
    echo "<script>console.log(" . json_encode($rows) . ");</script>";

    $i= 0;
    $tb = '';

    foreach($rows as $inp) {
        $tb.= '<div class="row tb-row border-bottom ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= '<div class="col-md-3 tb-cell"><div class="tb-num">' . $inp->RNUM . '</div>' . $inp->MEDREC . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $inp->PASIEN . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $inp->RUANG_ID . '</div>';
        $tb.= '<div class="col-md-2 tb-cell">' . $inp->NAMA_DEPT . '</div>';
        $tb.= '<div class="col-md-3 tb-cell">' . $inp->TGL_MASUK . '</div>';
        $tb.= '</div>';
        $i++;
        echo "<script>console.log(" . json_encode($inp) . ");</script>";
    }

    $config['base_url'] = base_url('counter/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $row_count;
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
    $num2 = $row_count;
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $num2 = ($per_page + $this->uri->segment(4));
        } else {
            $num2 = $row_count;
        }
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $row_count;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['tbrows'] = $tb;
?>