<?php

    $per_page = 50;
    $page_start = 1;
    $keyword = "";
    $reg_id = "";
    $rawat = "Y";
    $from_date = ""; 
    $to_date = "";
    $B001 =""; 
    $B002 = "";
    $B003 = ""; 
    $B004 = "";
    $B005 = ""; 
    $B006 = "";
    $B007 = "";
    $max_count = "";
    if($this->uri->segment(3) <> ''){
        if($this->uri->segment(4) <> ''){
            $page_start = $this->uri->segment(4) + 1;
        } else {
            $page_start = 1;
        }
    }

    $countrows =  $this->mfa->getRowCountCurrentInpatient($keyword, $reg_id, $rawat, $from_date, $to_date, $B001, $B002, $B003, $B004, $B005, $B006, $B007, $max_count);
    $rows = $this->mfa->getRowCurrentInpatient($page_start, $per_page, $keyword, $reg_id, $rawat, $from_date, $to_date, $B001, $B002, $B003, $B004, $B005, $B006, $B007);
    $berkas = $this->mfa->getBerkas("Y");
    $berkas_all = $this->mfa->getBerkas();

    $i= 0;
    $tb = '';
    $nbsp = '';

    function in_array_any($needles, $haystack) {
        return !empty(array_intersect($needles, $haystack));
    }

    foreach($rows as $inp) {

        $flag = "";
        if(strlen($inp->MEDREC) == 6) {
            $nbsp = '&nbsp;&nbsp;';
        } else {
            $nbsp = '&nbsp;';
        }
        if ($inp->REG_BERKAS == 'N'){
            $flag = 'bg-danger-2';
        } else {
            $listRegArr = explode(',',$inp->LIST_REG);
            $highArr = explode(',',$inp->HIGH_PRIORITY);
            $mediumArr = explode(',',$inp->MEDIUM_PRIORITY);
            $lowArr = explode(',',$inp->LOW_PRIORITY);

            if (in_array_any($highArr,$listRegArr)) {                
                $flag = 'bg-success-2';
            } 
            else if (in_array_any($mediumArr,$listRegArr)) {
                $flag = 'bg-dizzy';
            } else {
                $flag = 'bg-danger-2';
            }
        }
        $tb.= '<div class="row tb-row hover border-hover hover-event border-bottom ' . ($i%2 ? 'odd-row':'even-row') . " " . $flag .'">';
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
                    <div class="col-sm-12 col-md-8 p-0 hover circle-md hide">
                        <div class="d-flex justify-content-center" reg-id="' . $inp->REG_ID . '">
                            <a class="i-wrapp light" id="btnEditBerkas" data-toggle="tooltip" data-placement="bottom" title="Lihat"><i class="fas fa-file-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>';
        $tb.= '</div>';
        $i++;
    };

    $dropdown = '';
    foreach($berkas as $list) {
        $dropdown.= '<button class="dropdown-item btn-upload-template" data-toggle="tooltip" data-placement="bottom" title="Upload Template ' . $list->KETERANGAN . '" berkas_id="' . $list->BERKAS_ID . '" desc="' .  $list->KETERANGAN . '"><i class="far fa-file-plus"></i>&nbsp;' . $list->KETERANGAN . '</button>';
    }

    $dropdown_all = '';
    $dropdown_all.= '<button class="dropdown-item" data-toggle="tooltip" data-placement="bottom" berkas_id="all" desc="all"><i class="far fa-file-plus"></i>&nbsp;SEMUA</button>';
    $n=0;
    foreach($berkas_all as $list) {
        $n++;
        $dropdown_all.= '<button class="dropdown-item" data-toggle="tooltip" data-placement="bottom" id=' . $n . ' title="Upload Template ' . $list->KETERANGAN . '" berkas_id="' . $list->BERKAS_ID . '" desc="' .  $list->KETERANGAN . '"><i class="far fa-file-plus"></i>&nbsp;' . $list->KETERANGAN . '</button>';
    }

    
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
    $data['dropdown'] = $dropdown;
    $data['dropdown_all'] = $dropdown_all;
    // $data['thumb'] = $thumb;
?>