
<div class="container-fluid table_wrapper py-3" id="polimon_wrapper">
    <!-- <ul class="nav nav-tabs" id="tab_polimon">
        <li class="nav-item bg-nav-cool">
            <a class="nav-link active" data-toggle=tab id="t1" href="#" >Belum ke Dokter</a>
        </li>
        <li class="nav-item bg-nav-love">
            <a class="nav-link" data-toggle=tab id="t2" href="#">Sudah dari Dokter</a>
        </li>
        <li class="nav-item bg-nav-cure">
            <a class="nav-link" data-toggle=tab id="t3" href="#">Selesai Berobat</a>
        </li>
        <li class="nav-item bg-nav-dizzy">
            <a class="nav-link" data-toggle=tab id="t4" href="#">Batal</a>
        </li>
    </ul> -->
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-white justify-content-between pb-0">
            <h5 class="card-title mb-0">POLI MONITORING</h5>                  
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
                        <input class="form-check-input input-check" type="checkbox" value="<?= $val_ctr_daftar ?: 'NONE'; ?>" id="counterCheck" name="checkfilter">
                        <label class="form-check-label" for="counterCheck">
                            Daftar Counter
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="<?= $val_dr_selesai ?: 'NONE'; ?>" id="consultCheck" name="checkfilter">
                        <label class="form-check-label" for="consultCheck">
                            Dokter Selesai
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="<?= $val_ctr_selesai ?: 'NONE'; ?>" id="finishCheck" name="checkfilter">
                        <label class="form-check-label" for="finishCheck">
                            Counter Selesai
                        </label>
                    </li>
                    <li class="dropdown-item form-check form-check-inline">
                        <input class="form-check-input input-check" type="checkbox" value="<?= $val_ctr_batal ?: 'NONE'; ?>" id="cancelCheck" name="checkfilter">
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
                            Show 
                            <select name="dataTable_length" id="select_pageSize" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="">ALL</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="dataTable_filter" class="dataTables_filter">
                        <label>
                            Search:
                            <input type="search" class="form-control form-control-sm text-uppercase" id="inputSearchPolimon" placeholder="" aria-controls="dataTable">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <span class="color-indicator blue">Counter daftar</span>
                    <span class="color-indicator orange">Dokter selesai</span>
                    <span class="color-indicator green">Counter selesai</span>
                    <span class="color-indicator red">Counter batal</span>
                </div>
                <div class="col-md-4 text-right">
                    <span class="d-none" id="pausedTag">Paused&nbsp;<i class="fas fa-ban"></i>&nbsp;</span>
                    <button type="submit" id="btnStartPausePolimon" class="btn btn-sm btn-primary" style="width:100px;";>Pause</button>
                </div>
            </div>
            <div class="row">  
                <div class="col-sm-12" id="data_polimon">   
                    <div class="tb" id="polimonTable">

                        <div class="tb-header bg-cool text-light row">
                            <div class="col-md-1 tb-label sort-col">NO.<span class="sort-filter desc"></span></div>
                            <div class="col-md-1 tb-label sort-col">MEDREC<span class="sort-filter desc"></span></div>
                            <div class="col-md-2 tb-label sort-col">PASIEN<span class="sort-filter desc"></span></div>
                            <div class="col-md-3 tb-label sort-col">DOKTER<span class="sort-filter desc"></span></div>
                            <div class="col-md-1 tb-label sort-col">URUT<span class="sort-filter desc"></span></div>
                            <div class="col-md-2 tb-label sort-col">STRUK<span class="sort-filter desc"></span></div>
                            <div class="col-md-2 tb-label sort-col">JAM<span class="sort-filter desc"></span></div>
                        </div>

                        <div class="tb-body">  
                            <?= $polimon; ?>
                        </div>        
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                        Showing <?= $num1; ?> to <?= $num2; ?> of <?= $rows; ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7" id="pages_polimon">
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>