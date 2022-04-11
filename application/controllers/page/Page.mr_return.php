<?php
    $per_page = 10;
    $page_start = 1;
    $showitem = 1;
    $status = "not return";
    $fromDate = "";
    $toDate = "";
    
    $countrows =  $this->mmr->getRowCountPinjamMR($showitem, $status, $fromDate, $toDate);
    $rows = $this->mmr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $fromDate, $toDate);
    
    $i= 0;
    $tb = '';

    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $page_start = $this->uri->segment(4) + 1;
        } else {
            $page_start = 1;
        }
    }

    foreach($rows as $dt) {
        $tb.= '<div class="row tb-row border-bottom ' . ($i%2 ? 'odd':'even') . ' enabled" trans_id="' . $dt->TRANS_PINJAM_MR . '">';
        $tb.= '<div class="col-md-1 tb-cell p-rem-50">' . $dt->RNUM . '</div>';
        $tb.= '<div class="col-md-2 tb-cell p-rem-50">' . $dt->MEDREC . '</div>';
        $tb.= '<div class="col-md-4 tb-cell p-rem-50">' . $dt->PASIEN . '</div>';
        $tb.= '<div class="col-md-2 tb-cell p-rem-50">' . $dt->TGL_JANJI_KEMBALI . '</div>';
        $tb.= '<div class="col-md-3 tb-cell p-rem-50 text-center">
                    <button class="btn bg-primary btn-sm mx-1 text-white edit"></button>
                    <button class="btn btn-danger btn-sm mx-1 text-white delete"></button>
                </div>';
        $tb.= '</div>';
        $i++;
    } 

    $config['base_url'] = base_url('medrec/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $countrows;
    $config['per_page'] = $per_page;

    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center" id="mrReturn-pagination">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['first_link']       = '<i class="fa-solid fa-angles-left"></i>';
    $config['last_link']        = '<i class="fa-solid fa-angles-right"></i>';
    $config['next_link']        = '<i class="fa-solid fa-angle-right"></i>';
    $config['prev_link']        = '<i class="fa-solid fa-angle-left"></i>';
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
        $num2 = $per_page;
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $countrows;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['datarow'] = $tb;
?>