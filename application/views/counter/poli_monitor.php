
<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-4.6.1/dist/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>

<!-- Jquery UI -->
<script src="<?php echo base_url('assets/vendor/jquery-ui-1.13.0/jquery-ui.min.js'); ?>"></script>
<!-- Jquery Validation -->
<script src="<?php echo base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
<!-- datetimepicker jquery -->
<script src="<?php echo base_url('assets/vendor/date-time-picker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<div class="container-fluid py-3" id="table_wrapper">
    <ul class="nav nav-tabs">
    <li class="nav-item bg-nav-cool">
        <a class="nav-link active" href="#">Belum ke Dokter</a>
    </li>
    <li class="nav-item bg-nav-gloom">
        <a class="nav-link" href="#">Sudah dari Dokter</a>
    </li>
    <li class="nav-item bg-nav-cure">
        <a class="nav-link" href="#">Selesai Berobat</a>
    </li>
    <li class="nav-item bg-nav-dizzy">
        <a class="nav-link" href="#">Batal</a>
    </li>
    </ul>
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
                <div class="col-sm-12">             
                    <?= $polimon; ?>
                </div>
            </div>                
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                        Showing <?= $num1; ?> to <?= $num2; ?> of <?= $rows; ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <!-- <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                                <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">
                                    Previous
                                </a>
                            </li>
                            <li class="paginate_button page-item active">
                                <a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                            </li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                            </li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">3</a>
                            </li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">4</a>
                            </li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="5" tabindex="0" class="page-link">5</a>
                            </li>
                            <li class="paginate_button page-item ">
                                <a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">6</a>
                            </li>
                            <li class="paginate_button page-item next" id="dataTable_next">
                                <a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div> -->
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
		var _URL = window.URL || window.webkitURL;
	});

   $("#select_pageSize").on("change", function () {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url + "functions/Medrec_func/saveMrBorrow",
            data: {
                mr: mr,
            },
            success: function (data) {
                //alert(JSON.stringify(data));
                $(".submit").click();
                //pageInit();
            },
            error: function (data) {
                alert(JSON.stringify(data));
                //pageInit();
            },
        });
    });
</script>
