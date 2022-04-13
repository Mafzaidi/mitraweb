
<div class="container-fluid table_wrapper p-0" id="polimon_wrapper">
    <div class="card rounded-0">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
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
            </div>
            <div class="row">
                <div class="col">
                    <div class="tb">
                        <div class="tb-body">  
                            <?= $tablerows; ?>
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