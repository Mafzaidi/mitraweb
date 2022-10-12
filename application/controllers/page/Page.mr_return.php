<?php
    $per_page = 10;
    $page_start = 1;
    $showitem = 1;
    $status = "not return";
    $fromDate = "";
    $toDate = "";
    $keyword = "";
    $trans_id = "";
    $status_return = "";
    $status_notreturn = "not return";
    
    $countrows =  $this->mmr->getRowCountPinjamMR($showitem, $status, $fromDate, $toDate, $status_return, $status_notreturn);
    $rows = $this->mmr->getRowPinjamMR($page_start, $per_page, $showitem, $status, $fromDate, $toDate, $keyword, $trans_id, $status_return, $status_notreturn);
    
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
        $btnReturn ="";
        $btnEdit ="";
        if ($dt->TGL_AKHIR_KEMBALI <> "" && $dt->TGL_AKHIR_KEMBALI <> "-") {
            $btnReturn ="";
        } else {        
            $btnReturn = '<button class="btn bg-primary btn-sm mx-1 text-white file-alt btn-return" data-toggle="tooltip" data-placement="bottom" title="Pilih" dt="' . $dt->TGL_AKHIR_KEMBALI . '"></button>';
        }
        if ($dt->TGL_AKHIR_KEMBALI <> "" && $dt->TGL_AKHIR_KEMBALI <> "-") {
            $btnEdit = '<button class="btn bg-success btn-sm mx-1 text-white edit btn-update" data-toggle="tooltip" data-placement="bottom" title="Ubah"></button>';
        } else {        
            $btnEdit = '';
        }
        $tb.= '<div class="row tb-row border-bottom ' . ($i%2 ? 'odd':'even') . ' enabled" trans_id="' . $dt->TRANS_PINJAM_MR . '">';
        $tb.= '<div class="col-md-1 col-lg-1 tb-cell p-rem-50">' . $dt->RNUM . '</div>';
        $tb.= '<div class="col-md-4 col-lg-2 tb-cell p-rem-50">' . $dt->MEDREC . '</div>';
        $tb.= '<div class="col-md-7 col-lg-5 tb-cell p-rem-50">' . $dt->PASIEN . '</div>';
        $tb.= '<div class="col-md-12 col-lg-4 tb-cell p-rem-50 text-right">' . $btnReturn .
                    '<button class="btn btn-danger btn-sm mx-1 text-white delete btn-delete" data-toggle="tooltip" data-placement="bottom" title="Hapus"></button>'
                    . $btnEdit .
                '</div>';
        $tb.= '</div>';
        $i++;
    } 

    $config['base_url'] = base_url('medrec/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $countrows;
    $config['per_page'] = $per_page;

    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center" id="mrReturn-pagination">';
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
        $num2 = $per_page;
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $countrows;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['datarow'] = $tb;
?>