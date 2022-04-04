
<div class="container-fluid table_wrapper py-3" id="polimon_wrapper">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-white justify-content-between pb-0">
            <h5 class="card-title mb-0">LAPORAN PEMINJAMAN REKAM MEDIS</h5>                  
            <div class="dropdown">
                <button class="btn btn-sm ml-auto dropdown-toggle" type="button" id="dropdownFilterPolimon" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i>
                </button>
                <ul class="dropdown-menu form-check form-check-inline" aria-labelledby="dropdownFilterPolimon">
                    <li class="dropdown-item">
                        <input class="form-check-input" type="checkbox" value="" id="allCheck" name="checkfilter">
                        <label class="form-check-label" for="allCheck">
                            Select all
                        </label>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="" id="counterCheck" name="checkfilter">
                        <label class="form-check-label" for="counterCheck">
                            Daftar Counter
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="" id="consultCheck" name="checkfilter">
                        <label class="form-check-label" for="consultCheck">
                            Dokter Selesai
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="" id="finishCheck" name="checkfilter">
                        <label class="form-check-label" for="finishCheck">
                            Counter Selesai
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="" id="cancelCheck" name="checkfilter">
                        <label class="form-check-label" for="cancelCheck">
                            Batal
                        </label>
                    </li>
                    <li class="dropdown-divider"></li>
                    <div class="row px-3">
                        <div class="col">
                            <button type="submit" id="submitFilterPolimon" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="dataTable_length">
                        <label>
                            Tampilkan 
                            <select name="dataTable_length" id="select_pageSize" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> baris
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="dataTable_filter" class="dataTables_filter">
                        <label>
                            Cari:
                            <input type="search" class="form-control form-control-sm text-uppercase" id="inputSearchPolimon" placeholder="" aria-controls="dataTable">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">  
                <div class="col-sm-12" id="data_polimon">   
                    <div class="tb" id="polimonTable">

                        <div class="tb-header bg-cool text-light row">
                            <div class="col-md-1 tb-label p-rem-50">NO</div>
                            <div class="col-md-2 tb-label p-rem-50">MEDREC</div>
                            <div class="col-md-4 tb-label p-rem-50">PEMINJAM</div>
                            <div class="col-md-2 tb-label p-rem-50">TGL KEMBALI</div>
                            <div class="col-md-3 tb-label p-rem-50 text-center">PILIH</div>
                        </div>

                        <div class="tb-body">  
                            <?= $datarow; ?>
                        </div>        
                    </div>
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
    </div>
</div>