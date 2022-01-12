<div class="container-fluid py-3">
    <div class="card">
        <div class="card-header border-bottom-0 bg-info text-white">
            Filter Pencarian Medrec
        </div>
        <div class="formFilter-wrapper p-3">
            <div class="row">
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
            <div class="form-group row mb-0">
                <div class="col-sm-10 ">
                <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
        </div>
        <div class="formData-wrapper p-3">
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                         <input type="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="form-group">
                    <label for="inputAddress2">Address 2</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>