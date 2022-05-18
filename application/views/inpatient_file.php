

<div class="container-fluid table_wrapper p-0" id="page_inpatientFile" style="height: 100%;">
    <div class="card rounded-0" style="height: 100%;">
        <div class="card-body p-3" id="rowsInpatientFile">
        <!-- <div class="card-body p-3" style="display: none;"> -->
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="">
                        <label>
                            Tampilkan 
                            <select name="dataTable_length" id="select_pageSize" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50" selected>50</option>
                                <option value="100">100</option>
                            </select> baris
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
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
                <a class="i-wrapp text-muted" id="btnBack" data-toggle="tooltip" data-placement="bottom" title="Kembali"><i class="fas fa-arrow-left"></i></a>
                <!-- <a class="i-wrapp text-muted" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Tambah"><i class="fas fa-plus"></i></a> -->
                <!-- <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-pen"></i></a>
                <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas"  data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fas fa-trash"></i></a>
                <a class="i-wrapp text-muted float-right mx-1" id="btnAddBerkas"  data-toggle="tooltip" data-placement="bottom" title="Batal"><i class="fas fa-undo-alt"></i></a> -->
                <div class="dropdown dropleft ml-md-auto">
                    <a class="i-wrapp-animate float-right text-muted" id="btnAddBerkas" href="#" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-plus"></i></a>

                    <div class="dropdown-menu" aria-labelledby="btnAddBerkas" id="dropdownBerkas">
                        <!-- <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a> -->
                    </div>
                </div>
            </nav>

            <div class="row p-3">  
                <div class="col-md-8 col-lg-6">
                    <div class="card bg-transparent border rounded-3" style="font-size: 0.85rem;">
                        <div class="card-header bg-light align-middle border-bottom p-2">
                            <h6 class="card-header-title float-left mb-0">Data Pasien</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">No. Medrec</label>
                                </div>
                                <div class="col-sn-12 col-md-12 col-lg-6">                                  
                                    <span class="" id="medrec">000000</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Nama Pasien</label>
                                </div>
                                <div class="col-sn-12 col-md-12 col-lg-6">                                  
                                    <span class="" id="nama">Test IT</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Tanggal Lahir</label>
                                </div>
                                <div class="col-sn-12 col-md-12 col-lg-6">                                  
                                    <span class="" id="tgl_lahir">000000</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label  class="text-muted m-0">Umur</label>
                                </div>
                                <div class="col-sn-12 col-md-12 col-lg-6">                                  
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
                <div class="col-md-4 col-lg-6">          
                    <div class="card bg-transparent border rounded-3 m-3">
                        <!-- <div class="card-header bg-light align-middle border-bottom p-2 hover square">
                            <h6 class="card-header-title float-left mb-0">LMA</h6>
                            <a class="i-wrapp text-muted float-right mr-2" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Kembali"><i class="fas fa-trash"></i></a>
                            <a class="i-wrapp text-muted float-right mx-2" id="btnAddBerkas" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fas fa-pen"></i></a>
                        </div> -->
                        <div class="card-body">
                        </div>
                    </div> 
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