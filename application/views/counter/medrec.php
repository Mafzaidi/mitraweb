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
                            <input type="text" class="form-control form-control-sm" id="inputTextName" placeholder="nama">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputBirthPlace" class="col-sm-4 col-form-label-sm pr-0 mb-2">Tanggal Lahir</label>
                        <div class="col-sm-8 pl-0">
                            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input form-control-sm" data-target="#datetimepicker4" id="inputDate" placeholder="tanggal lahir"/>
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row mb-2">
                        <label for="inputTextMr" class="col-sm-4 col-form-label-sm pr-0 mb-2">No. Telp/HP</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextMr" placeholder="no HP/Telp">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputTextName" class="col-sm-4 col-form-label-sm pr-0 mb-2">Alamat</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextName" placeholder="alamat">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="inputTextName" class="col-sm-4 col-form-label-sm pr-0 mb-2">Nama Ayah</label>
                        <div class="col-sm-8 pl-0">
                            <input type="text" class="form-control form-control-sm" id="inputTextName" placeholder="nama ayah">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row px-3 mb-0">
                <div class="col-sm-10 ">
                <button type="submit" class="btn btn-primary search">Search</button>
                </div>
            </div>
        </div>
        <div class="formData-wrapper p-3">
            <div>
                <div class="form-row">
                    <div class="form-group col-md-6 mb-2">
                        <label for="inputDataMr" class="col-form-label-sm mb-1">Medrec</label>
                         <input type="text" class="form-control form-control-sm" id="inputDataMr" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDataName" class="col-form-label-sm mb-1">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataName" readonly>
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
                        <label for="inputDataDistrict" class="col-form-label-sm mb-1">Kecamatan</label>
                        <input type="text" class="form-control form-control-sm" id="inputDataDistrict" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>