
<div class="container-fluid table_wrapper py-3" id="reportPinjamMr_wrapper">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-white bg-light-text">
            Laporan Peminjaman Rekam Medis
            <button class="filter-toggler ml-auto" id="searchMrFilterToggler" data-toggle="collapse" data-target="#filterReportPinjamMr">
                <i class="fas fa-angle-double-up"></i>
            </button>
        </div>
        <div class="formFilter-wrapper collapse show" id="filterReportPinjamMr">
            <div class="row p-3">
                <div class="col-md-8">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="input-group date" id="fromDateRpt_picker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" name="fromDate" data-target="#fromDateRpt_picker" id="inputFromDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                <div class="input-group-append" data-target="#fromDateRpt_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date" id="toDateRpt_picker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" name="toDate" data-target="#toDateRpt_picker" id="inputToDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                <div class="input-group-append" data-target="#toDateRpt_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn-sm submit" id="btnPinjamMrSubmit">Submit</button>
                    <button type="button" class="btn btn-sm excel" id="btnPinjamMrExc">Excel</button>
                    <button type="button" class="btn btn-sm pdf" id="btnPinjamMrPdf">PDF</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="reportPinjamMr">
            <div class="row">  
                <div class="col-sm-12">   
                    <div class="tb" id="tbReportPinjamMr" data="false">

                        <div class="tb-header bg-cool text-white row">
                            <div class="col-md-1 tb-label p-rem-50">NO</div>
                            <div class="col-md-1 tb-label p-rem-50">MEDREC</div>
                            <div class="col-md-3 tb-label p-rem-50">PASIEN</div>
                            <div class="col-md-3 tb-label p-rem-50">PEMINJAM</div>
                            <div class="col-md-2 tb-label p-rem-50">TGL PINJAM</div>
                            <div class="col-md-2 tb-label p-rem-50">TGL JANJI KEMBALI</div>
                        </div>

                        <div class="tb-body">  
                            <!-- <?= $datarow; ?> -->
                            <div class="row">
                                <div class="col-md-12 bg-danger-2 text-center">DATA BELUM DITAMPILKAN</div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                        <!-- Tampilkan <?= $num1; ?> ke <?= $num2; ?> dari <?= $rows; ?> baris -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-7" id="pages_polimon">
                    <!-- <?= $pagination; ?> -->
                </div>
            </div>
        </div>
    </div>
</div>