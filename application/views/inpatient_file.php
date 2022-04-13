
<div class="container-fluid table_wrapper p-0" id="polimon_wrapper">
    <div class="card rounded-0">
        <div class="card-body">
            <div class="row">  
                <div class="col-sm-12">
                    <div class="tb" id="tbInpatienFile">
                        <div class="tb-body">  
                            <?= $tbrows; ?>
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