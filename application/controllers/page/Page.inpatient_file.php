<?php

    $per_page = 10;
    $page_start = 1;

    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $page_start = $this->uri->segment(4) + 1;
        } else {
            $page_start = 1;
        }
    }

    $countrows =  $this->mfa->getRowCountCurrentInpatient();
    $rows = $this->mfa->getRowCurrentInpatient($page_start, $per_page);

    $i= 0;
    $tb = '';

    foreach($rows as $inp) {
        $tb.= '<div class="row tb-row hover border-hover hover-event border-bottom ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= 
            '<div class="col-md-8 tb-cell">
                <div class="row">
                    <div class="col-sm-12 col-md-1 p-0">' . $inp->RNUM . '</div>
                    <div class="col-sm-12 col-md-2 p-0 font-weight-bolder">' . $inp->MEDREC . '</div>
                    <div class="col-sm-12 col-md-3 p-0 font-weight-bolder">' . $inp->PASIEN . '</div>
                    <div class="col-sm-12 col-md-2 p-0">' . $inp->RUANG_ID . '</div>
                    <div class="col-sm-12 col-md-2 p-0">' . $inp->NAMA_DEPT . '</div>
                    <div class="col-sm-12 col-md-2 p-0">' . $inp->TGL_MASUK . '</div>
                </div>
            </div>';
        $tb.= 
            '<div class="col-md-4 tb-cell p-0">
                <div class="row">
                    <div class="col-sm-12 col-md-4 p-0"></div>
                    <div class="col-sm-12 col-md-8 p-0 font-weight-lighter hover show">' . substr_replace($inp->REKANAN_NAMA, '...', 20) . '</div>
                    <div class="col-sm-12 col-md-8 p-0 hover hide">
                        <div class="d-flex justify-content-center">
                            <a class="i-wrapp"><i class="fas fa-folder-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>';
        $tb.= '</div>';
        $i++;
    };

    // 

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
    $data['tablerows'] = $tb;
?>