

<div class="container-fluid table_wrapper p-0" id="page_inpatientFile">
    <div class="card rounded-0">
        <div class="card-body">
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