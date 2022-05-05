<?php

    $per_page = 50;
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
    $nbsp = '';

    foreach($rows as $inp) {
        if(strlen($inp->MEDREC) == 6) {
            $nbsp = '&nbsp;&nbsp;';
        } else {
            $nbsp = '&nbsp;';
        }
        $tb.= '<div class="row tb-row hover border-hover hover-event border-bottom ' . ($i%2 ? 'odd-row':'even-row') . '">';
        $tb.= 
            '<div class="col-sm-12 col-md-9 tb-cell">
                <div class="row">
                    <div class="col-sm-12 col-md-5 p-0">
                        <div class="row">
                            <div class="w-35-px">' . $inp->RNUM . '</div>
                            <div class="col-sm-12 col-md-10 p-0"><b>' . $inp->MEDREC . '</b>&nbsp-&nbsp;' . $inp->PASIEN .'</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 p-0 "> Masuk tanggal&nbsp;' . $inp->TGL_MASUK . '&nbsp;-&nbsp;Ruang:&nbsp;'. $inp->RUANG_ID . '&nbsp;-&nbsp;NS:&nbsp;' . $inp->NAMA_DEPT . '</div>
                </div>
            </div>';
        $is_reg = '';
        $is_edit = '';
        if ($inp->REG_BERKAS <> ''){
            $is_reg = 'disabled';
            $is_edit = 'enabled';
        } else {
            $is_reg = 'enabled';
            $is_edit = 'disabled';
        }
        $tb.= 
            '<div class="col-sm-12 col-md-3 tb-cell p-0">
                <div class="row">
                    <div class="col-sm-12 col-md-4 p-0">
                    </div>
                    <div class="col-sm-12 col-md-8 p-0 font-weight-lighter hover show">' . substr_replace($inp->REKANAN_NAMA, '...', 20) . '</div>
                    <div class="col-sm-12 col-md-8 p-0 hover hide">
                        <div class="d-flex justify-content-center" reg-id="' . $inp->REG_ID . '">
                            <a class="i-wrapp" id="btnEditBerkas" data-toggle="tooltip" data-placement="bottom" title="Lihat"><i class="fas fa-file-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>';
        $tb.= '</div>';
        $i++;
    };

    
    // <a class="i-wrapp" id="btnAddBerkas" ' . $is_reg . ' data-toggle="tooltip" data-placement="bottom" title="Tambah data"><i class="fas fa-folder-plus"></i></a>
    // <a class="i-wrapp" id="btnEditBerkas" ' . $is_edit . ' data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-edit"></i></a>

    $config['base_url'] = base_url('counter/' . $this->uri->segment(2) . '/' . $this->uri->segment(3));
    $config['total_rows'] = $countrows;
    $config['per_page'] = $per_page;

    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end" id="inpatientFile-pagination">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['prev_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
    $config['prev_tag_close']  = '</span></li></li>';
    $config['num_tag_open']     = '<li class="page-item text-dark"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-dark">';
    $config['cur_tag_close']    = '</span></li>';
    $config['next_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
    $config['next_tag_close']  = '</span></li>';
    $config['first_tag_open']   = '<li class="page-item text-dark"><span class="page-link">';
    $config['first_tag_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item text-dark"><span class="page-link">';
    $config['last_tag_close']  = '</span></li>';

    $this->pagination->initialize($config);

    $num1 = $page_start;
    $num2 = $countrows;
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $num2 = ($per_page + $this->uri->segment(4));
        } else {
            if ($per_page <> ''){
                $num2 = $per_page; 
            } else{
                $num2 = $countrows;
            }
        }
    }
    $data['pagination'] = $this->pagination->create_links();
    $data['rows'] = $countrows;
    $data['num1'] = $num1;
    $data['num2'] = $num2;
    $data['tablerows'] = $tb;
?>