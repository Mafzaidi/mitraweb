
<div class="container-fluid table_wrapper py-3" id="page_mrReturn">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-white justify-content-between pb-0">
            <h5 class="card-title mb-0">DATA PEMINJAMAN</h5>     
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_length" id="">
                        <label>
                            Tampilkan 
                            <select name="dataTable_length" id="select_pageSize_mr_return" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> baris
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="input-group mb-3 inner-addon left-addon">
                        <!-- <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0 rounded-left-pill search-icon" id="addon-wrapping"></span>
                        </div> -->
                        <i class="fas fa-search inner-fa-icon"></i>
                        <input type="text" class="form-control rounded-pill pl-5" placeholder="Cari nama atau medrec..." id="inputTxtSearchMrReturn" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <!-- <div class="input-group-append">
                            <button class="btn btn-outline-secondary border-gray-1 rounded-right" type="button" id="button-addon2">&nbsp;Cari&nbsp;</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-8">
                    <span class="color-indicator blue">Counter daftar</span>
                    <span class="color-indicator orange">Dokter selesai</span>
                    <span class="color-indicator green">Counter selesai</span>
                    <span class="color-indicator red">Counter batal</span>
                </div>
            </div> -->
            <div class="row">  
                <div class="col-sm-12 col-md-7" id="">   
                    <div class="tb" id="pinjamMrReturn">

                        <div class="tb-header bg-cool text-light row">
                            <div class="col-md-1 tb-label p-rem-50">NO</div>
                            <div class="col-md-2 tb-label p-rem-50">MEDREC</div>
                            <div class="col-md-4 tb-label p-rem-50">PEMINJAM</div>
                            <div class="col-md-2 tb-label p-rem-50">TGL PINJAM</div>
                            <div class="col-md-3 tb-label p-rem-50 text-center">PILIH</div>
                        </div>

                        <div class="tb-body">  
                            <?= $datarow; ?>
                        </div>       
                    </div>
                                                         
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                Tampilkan <?= $num1; ?> ke <?= $num2; ?> dari <?= $rows; ?> baris
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7" id="pages_polimon">
                            <?= $pagination; ?>
                        </div>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-5" id="">      
                    <div class="formData-wrapper p-3">                       
                        <form id="formReturnBy">
                            <div class="form-row">
                                <div class="form-group col-md-4 mb-2">
                                    <label for="inputDataMr" class="col-form-label-sm mb-1">Medrec</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataMr" readonly>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputDataPatient" class="col-form-label-sm mb-1">Nama</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataPatient" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4 mb-2">
                                    <label for="inputDataBirthPlace" class="col-form-label-sm mb-1">Tempat Lahir</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataBirthPlace" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputDataBirthDate" class="col-form-label-sm mb-1">Tanggal Lahir</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataBirthDate" readonly>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="inputDataTelp" class="col-form-label-sm mb-1">No. Telp/HP</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataTelp" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="inputDataAddress" class="col-form-label-sm mb-1">Alamat</label>
                                <input type="text" class="form-control form-control-sm" id="inputDataAddress" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 mb-2">
                                    <label for="inputDataBorrower" class="col-form-label-sm mb-1">Peminjam</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataBorrower" readonly>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <label for="inputDataLender" class="col-form-label-sm mb-1">Pemberi Pinjam</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataLender" readonly>
                                </div>
                            </div>                       
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="inputDataNecst" class="col-form-label-sm mb-1">Keperluan</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataNecst" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputDataRtrnDate" class="col-form-label-sm mb-1">Tanggal Janji Kembali</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataRtrnDate" readonly>
                                </div>
                            </div>
                            <div class="form-row d-none" id="divReturnBy">
                                <div class="col-auto">
                                    <label class="sr-only" for="mr">Medical Record Number</label>
                                    <input type="text" class="form-control mb-2 mr-sm-2" id="inputReturnBy" placeholder="dikembalikan oleh" name="returnBy">
                                </div>
                                <div class="col-auto">
                                    <button type="" class="btn btn-primary mb-2 save" trans_pinjam="">&nbsp;&nbsp;Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>