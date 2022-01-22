
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
                            <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">  
                <div class="col-sm-12" id="data_polimon">             
                    <?= $polimon; ?>
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