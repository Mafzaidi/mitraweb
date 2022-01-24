<div class="container-fluid py-3" id="searchMr">
    <div class="card">
        <div class="d-flex card-header border-bottom-0 bg-info bg-dark-text">
            Filter Pencarian Medrec
            <button class="filter-toggler ml-auto" id="searchMrFilterToggler" data-toggle="collapse" data-target="#filterMr">
                <i class="fas fa-angle-double-up"></i>
            </button>
        </div>
        <div class="formFilter-wrapper collapse show" id="filterMr">
            <div class="row p-3">
                <div class="col">
                    <div class="form-group row mb-2">
                        <label for="inputTextMr" class="col-sm-4 col-form-label-sm pr-0 mb-2">Medrec</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextMr" placeholder="medrec">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputTextName" class="col-sm-4 col-form-label-sm pr-0 mb-2">Name</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm upper-text" id="inputTextName" placeholder="nama">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputBirthPlace" class="col-sm-4 col-form-label-sm pr-0 mb-2">Tanggal Lahir</label>
                        <div class="col-sm-8 pl-0">
                            <div class="input-group date" id="birthDateTime_picker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm date-validate" data-target="#birthDateTime_picker" id="inputBirthDate" placeholder="DD.MM.YYYY" maxlength="10" />
                                <div class="input-group-append" data-target="#birthDateTime_picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row mb-2">
                        <label for="inputTextTelp" class="col-sm-4 col-form-label-sm pr-0 mb-2">No. Telp/HP</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextTelp" placeholder="no HP/Telp">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputTextAddress" class="col-sm-4 col-form-label-sm pr-0 mb-2">Alamat</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextAddress" placeholder="alamat">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputTextParent" class="col-sm-4 col-form-label-sm pr-0 mb-2">Orang Tua</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextParent" placeholder="orang tua">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row px-3 mb-0">
                <div class="col-sm-10 ">
                <button type="submit" class="btn btn-primary search" id="btnSearchMr">Search</button>
                </div>
            </div>
        </div>
        <div class="formData-wrapper p-3">
            <div>
                <div class="form-row">
                    <div class="form-group col-md-4 mb-2">
                        <label for="inputDataMr" class="col-form-label-sm mb-1">Medrec</label>
                         <input type="text" class="form-control form-control-sm" id="inputDataMr" readonly>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="inputDataName" class="col-form-label-sm mb-1">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataName" readonly>
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
                    <div class="form-group col-md-4 mb-2">
                        <label for="inputDataCity" class="col-form-label-sm mb-1">Kota</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataCity" readonly>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label for="inputDataRegency" class="col-form-label-sm mb-1">Kecamatan</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataRegency" readonly>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label for="inputDataDistrict" class="col-form-label-sm mb-1">Kelurahan</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataDistrict" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Logout Modal-->
 <!-- <div class="modal fade" id="myDynamicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Medrec</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-submit btn-primary" href="#">Select</a>
            </div>
        </div>
    </div>
</div>  -->