
<div class="container-fluid table_wrapper py-3" id="page_mrReturn">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-white justify-content-between pb-0">
            <h5 class="card-title mb-0">DATA PEMINJAMAN</h5>     
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-7">           
                    <div class="dropdown pb-2">
                        <button class="btn btn-sm ml-auto dropdown-toggle" type="button" id="dropdownFilterMrReturn" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter"></i>
                        </button>
                        <ul class="dropdown-menu form-check form-check-inline" aria-labelledby="dropdownFilterMrReturn">
                            <li class="dropdown-item">
                                <input class="form-check-input" type="checkbox" value="all" id="allCheck" name="checkfilter">
                                <label class="form-check-label" for="allCheck">
                                    Select all
                                </label>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item form-check form-check-inline">
                                <input class="form-check-input input-check" type="checkbox" value="not return" id="notReturnCheck" name="checkfilter">
                                <label class="form-check-label" for="notReturnCheck">
                                    Belum Kembali
                                </label>
                            </li>
                            <li class="dropdown-item form-check form-check-inline">
                                <input class="form-check-input input-check" type="checkbox" value="return" id="returnCheck" name="checkfilter">
                                <label class="form-check-label" for="returnCheck">
                                    Sudah Kembali
                                </label>
                            </li>
                            <li class="dropdown-divider"></li>
                            <div class="row px-3">
                                <div class="col">
                                    <button type="submit" id="submitFilterMrReturn" class="btn btn-sm btn-primary">Submit</button>
                                </div>
                            </div>
                        </ul>
                    </div>
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

                        <!-- <div class="tb-header bg-cool text-light row">
                            <div class="col-md-1 col-lg-1 tb-label p-rem-50">NO</div>
                            <div class="col-md-4 col-lg-2 tb-label p-rem-50">MEDREC</div>
                            <div class="col-md-5 col-lg-5 tb-label p-rem-50">PEMINJAM</div>
                            <div class="col-md-0 col-lg-4 tb-label p-rem-50">PILIH</div>
                        </div> -->

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
                                <div class="form-group col-md-6">
                                    <label for="inputDataBrwDate" class="col-form-label-sm mb-1">Tanggal Pinjam</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataBrwDate" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputDataRtrnDate" class="col-form-label-sm mb-1">Tanggal Janji Kembali</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataRtrnDate" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputDataNecst" class="col-form-label-sm mb-1">Keperluan</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDataNecst" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>