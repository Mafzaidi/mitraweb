<div class="container-fluid py-3" id="searchMr">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-info bg-dark-text">
            Poli Monitor Report
            <button class="filter-toggler ml-auto" id="searchMrFilterToggler" data-toggle="collapse" data-target="#filterMr">
                <i class="fas fa-angle-double-up"></i>
            </button>
        </div>
        <div class="formFilter-wrapper collapse show" id="filterMr">
            <div class="row p-3">
                <div class="col-md-8">
                    <div class="form-group row">
                        <label for="inputBirthPlace" class="col-sm-2 col-form-label-sm pr-0 mb-2">From Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date" id="fromDateRpt_picker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" data-target="#fromDateRpt_picker" id="inputFromDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                <div class="input-group-append" data-target="#fromDateRpt_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <label for="inputBirthPlace" class="col-sm-2 col-form-label-sm pr-0 mb-2">To Date</label>
                        <div class="col-sm-4">
                            <div class="input-group date" id="toDateRpt_picker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" data-target="#toDateRpt_picker" id="inputToDateRpt" placeholder="DD.MM.YYYY" maxlength="10" />
                                <div class="input-group-append" data-target="#toDateRpt_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn-sm" id="btnPolimonSubmit">Submit</button>
                    <button type="button" class="btn btn-sm excel" id="btnPolimonExc">Excel</button>
                    <button type="button" class="btn btn-sm pdf" id="btnPolimonPdf">PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>