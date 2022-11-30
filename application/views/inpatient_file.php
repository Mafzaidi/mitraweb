

<div class="container-fluid table_wrapper p-0" id="page_inpatientFile" style="height: 100%;">
    <div class="card rounded-0" style="height: 100%;">
        <div class="card-body p-3" id="rowsInpatientFile">
        <!-- <div class="card-body p-3" style="display: none;"> -->
            <div class="row">
                <div class="col-sm-12 col-md-7 col-lg-8">
                    <div class="dataTables_length" id="">
                        <label> 
                            <select name="dataTable_length" id="InpatientFile_selectPageSize" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50" selected>50</option>
                                <option value="100">100</option>
                            </select> baris
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-4">
                    <div class="input-group mb-3 inner-addon left-addon">
                        <!-- <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0 rounded-left-pill search-icon" id="addon-wrapping"></span>
                        </div> -->
                        <i class="fas fa-search inner-fa-icon"></i>
                        <input type="text" class="form-control rounded-pill pl-5 input-auto-complete" placeholder="Cari nama atau medrec pasien..." id="inputTxtSearchInpatient" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <!-- <div class="input-group-append">
                            <button class="btn btn-outline-secondary border-gray-1 rounded-right" type="button" id="button-addon2">&nbsp;Cari&nbsp;</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <ul class="nav tab-container">
                <li class="nav-item tab-content h-100 col-md-3 col-sm-6" mode="REG">
                    <div class="d-flex flex-row tab-header h-100 active" target="tb_inpatientFile_container">
                        <div class="tab-icon-container h-100">
                            <div class="tab-icon h-100">
                                <i class="fas fa-clinic-medical"></i>
                            </div>
                        </div>
                        <div class="tab-caption-container h-100">
                            <div class="tab-caption h-100">
                                <a class="nav-link p-0 active" href="#">Sedang rawat</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item tab-content h-100 col-md-3 col-sm-6" mode="FLT">
                    <div class="d-flex flex-row tab-header h-100" target="filter_inpatientFIle_container">
                        <div class="tab-icon-container h-100">
                            <div class="tab-icon h-100">
                                <i class="fas fa-th-list"></i>
                            </div>
                        </div>
                        <div class="tab-caption-container h-100">
                            <div class="tab-caption h-100">
                                <a class="nav-link p-0 active" href="#">Pilih kriteria</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="container-fluid filter_container toggle-container d-none" id="filter_inpatientFIle_container" style="margin-top: 6px">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row border-bottom border-top py-1">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="form-inline d-flex">
                                        <!-- <div class="d-flex justify-content-center">
                                            <div class="i-wrapp light btn-add-berkas" role="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tambah berkas lain">
                                                <span class="multi-icon"><i class="far fa-square"></i></span>
                                                <span class="multi-icon"><i class="fas fa-caret-down"></i></span>
                                            </div>
                                        </div> -->
                                        <div class="form-inline dropdown d-flex hover square-dynamic i-wrap-outer-wrapper hide mr-2" id="dropdownFilterBerkas">                             
                                            <div class="i-wrapp light square-box" role="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Semua Berkas">
                                                <i class="far fa-square"></i>
                                                <i class="far fa-check-square d-none"></i>
                                            </div>
                                            <div class="i-wrapp light dropdown-toggle dropdown-toggle-split" role="button" data-toggle="dropdown" aria-expanded="false" data-reference="parent">
                                            </div>
                                            <div class="dropdown-menu">
                                                <?= $dropdown_all ?>
                                            </div>
                                        </div>
                                        <div class="form-inline d-flex hover circle-md hide">
                                            <div class="d-flex justify-content-center  mx-1">
                                                <label for="radio_filterRawat1">
                                                    <input class="d-none" type="radio" name="radioRawatOptions" id="radio_filterRawat1" value="Y"/>
                                                    <div class="i-wrapp light btn-check-rawat" role="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Masih rawat">
                                                        <i class="fas fa-calendar-plus"></i>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="d-flex justify-content-center mx-1">
                                                <label for="radio_filterRawat2">
                                                    <input class="d-none" type="radio" name="radioRawatOptions" id="radio_filterRawat2" value="N"/>
                                                    <div class="i-wrapp light btn-check-rawat" role="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sudah Pulang">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <div class="dropdown" id="dropdownPeriod" style="line-height:33px">
                                        <button class="btn btn-sm btn-white btn-outline-secondary dropdown-toggle" id="btnDropdownPeriod" type="button" data-toggle="dropdown" aria-expanded="false" for_id="1">
                                            <i class="fas fa-calendar-alt"></i><span class="ml-2">Semua waktu</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" id="1">Semua waktu</a>
                                            <!-- <a class="dropdown-item" id="2">Rentang seminggu</a>
                                            <a class="dropdown-item" id="3">Rentang sebulan</a>
                                            <a class="dropdown-item" id="4">Rentang 6 bulan</a>
                                            <a class="dropdown-item" id="5">Rentang setahun</a> -->
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item btn-dropdown-period" id="6">Pilih periode...</a>
                                        </div>                                      
                                        <div class="card custom-dropdown">
                                            <div class="card-body py-0 px-2">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-0" for="inputFromDateRpt">Tanggal mulai</label>
                                                        <div class="input-group date" id="fromDateRpt_picker" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" name="fromDate" data-target="#fromDateRpt_picker" id="inputFromDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                                            <div class="input-group-append" data-target="#fromDateRpt_picker" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label class="mb-0" for="inputToDateRpt">Tanggal akhir</label>
                                                        <div class="input-group date" id="toDateRpt_picker" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" name="toDate" data-target="#toDateRpt_picker" id="inputToDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                                            <div class="input-group-append" data-target="#toDateRpt_picker" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-inline d-flex justify-content-end py-2">
                                                            <button class="btn btn-sm btn-white btn-outline-secondary" id="btnSetPeriod" type="button" >
                                                                Apply
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="tb_inpatientFileReport_container">
                        <div class="col">
                            <div class="tb" id="tb_inpatientFileReport">
                                <div class="tb-body">
                                </div>                  
                                <div class="row py-2">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="tb-info" role="status" aria-live="polite">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="tb-pagination">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row toggle-container" id="tb_inpatientFile_container">
                <div class="col">
                    <div class="tb" id="tb_inpatientFile">
                        <div class="tb-body">
                            <?= $tablerows; ?>
                        </div>                  
                        <div class="row py-2">
                            <div class="col-sm-12 col-md-5">
                                <div class="tb-info" role="status" aria-live="polite">
                                    Tampilkan <?= $num1; ?> ke <?= $num2; ?> dari <?= $rows; ?> baris
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="tb-pagination">
                                    <?= $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0 d-none" id="detailInpatientFile">        
            
            <nav class="navbar topbar navbar-expand-sm navbar-light bg-white border-bottom py-2 mb-3 hover circle">
                <div class="form-inline d-flex justify-content-end hover circle-md hide">
                    <div class="d-flex justify-content-center light">
                        <a class="i-wrapp text-muted" id="btnBack" data-toggle="tooltip" data-placement="bottom" title="Kembali"><i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>
                <!-- <a class="i-wrapp text-muted" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Tambah"><i class="fas fa-plus"></i></a> -->
                <!-- <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-pen"></i></a>
                <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas"  data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fas fa-trash"></i></a>
                <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas"  data-toggle="tooltip" data-placement="bottom" title="Batal"><i class="fas fa-undo-alt"></i></a> -->
                <div class="dropdown dropleft ml-md-auto">
                    <a class="i-wrapp-animate float-right text-muted" id="btnAddBerkas" href="#" role="button" data-toggle="dropdown" aria-expanded="false" data-content="Template" data-width=120px ><i class="fas fa-plus"></i></a>
                    <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="btnAddBerkas" id="dropdown_berkas">
                        <?= $dropdown ?>
                    </div>
                </div> 
            </nav>

            <div class="row p-3">  
                <div class="col-md-12 col-lg-6">
                    <div class="card bg-transparent border rounded-3" style="font-size: 0.85rem;">
                        <div class="card-header bg-light align-middle border-bottom p-2">
                            <h6 class="card-header-title float-left mb-0">Data Pasien</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">No. Medrec</label>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">                                  
                                    <span class="font-weight-bold" id="medrec">000000</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Nama Pasien</label>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">                                  
                                    <span class="font-weight-bold" id="nama">Test IT</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Tanggal Lahir</label>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">                                  
                                    <span class="" id="tgl_lahir">000000</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Umur</label>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">                                  
                                    <span class="" id="umur">000000</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row p-0 m-0">
                            <div class="card-body pt-0">
                                <label  class="text-muted col-sm-12 col-md-12 col-lg-6 mb-0 mt-md-2 mt-lg-0">Tanggal Masuk</label>
                                <span class="col-sm-12 col-md-12 col-lg-6 mb-md-2 mb-lg-0" id="tgl_masuk">10.10.2022</span>
                                <label  class="text-muted col-sm-12 col-md-12 col-lg-6 mb-0 mt-md-2 mt-lg-0">Ruangan</label>
                                <span class="col-sm-12 col-md-12 col-lg-6 mb-md-2 mb-lg-0" id="ruang">302(1)</span>
                                <label  class="text-muted col-sm-12 col-md-12 col-lg-6 mb-0 mt-md-2 mt-lg-0">NS</label>
                                <span class="col-sm-12 col-md-12 col-lg-6 mb-md-2 mb-lg-0" id="ns">Cempaka</span>
                                <label  class="text-muted col-sm-12 col-md-12 col-lg-6 mb-0 mt-md-2 mt-lg-0">DPJP</label>
                                <span class="col-sm-12 col-md-12 col-lg-6 mb-md-2 mb-lg-0" id="dokter">Dokter Test, Dr</span>
                                <label  class="text-muted col-sm-12 col-md-12 col-lg-12 mb-0 mt-4">Rekanan Pasien</label>
                                <span class="col-sm-12 col-md-12 col-lg-12 mb-md-2 mb-lg-0" id="rekanan">-RSMK PASIEN UMUM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">   
                    <form id="formInpatientFile">     
                        <div class="card bg-transparent border rounded-3 m-3">
                            <div class="card-header bg-white align-middle border-bottom p-2 text-right fs-085rem hover square">
                                <p class="card-text text-muted" id="card-header-description">Pengisian kelengkapan berkas pasien rawat inap</p>                              
                                <!-- <a class="i-wrapp text-muted float-right mr-2" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Kembali"><i class="fas fa-trash"></i></a>
                                <a class="i-wrapp text-muted float-right mx-2" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-pen"></i></a> -->
                            </div>
                            <div class="card-body" id="berkasContainer">                           
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-12 form-inline d-flex justify-content-end">
                                        <small class="alert alert-danger d-none p-1 m-0 mr-2" id="card-header-alert" role="alert">
                                            "A simple danger alert—check it out!"
                                        </small>
                                        <button type="button" class="btn btn-primary btn-sm mr-2 fs-075rem" id="btn_save_berkas_final"><i class="fas fa-save"></i>&nbsp;Save</button>
                                        <button type="button" class="btn btn-danger btn-sm mr-2 fs-075rem" disabled><i class="fas fa-ban"></i></i>&nbsp;Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loader-modal fade show">   
    <div class="loader-container">                     
        <div class="large-indicator">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>       
</div>  

<div class="modal secondary fade" id="myConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Test Modal
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Oke</button>
            </div>
        </div>
    </div>
</div>