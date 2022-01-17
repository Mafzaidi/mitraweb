<!-- MultiStep Form -->
<div class="container-fluid py-3" id="borrowMr">
    <div class="card">
        <div class="row p-3">
            <div class="col-md-12">
                <!-- progressbar -->
                <ul class="m-0 p-0" id="progressbar">
                    <li class="active" id="search"><strong>Find</strong></li>
                    <li id="insert"><strong>Insert</strong></li>
                    <li id="confirm"><strong>Finish</strong></li>
                </ul> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-0">
                <form id="formSearchBrw">
                    <div class="form-card">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label class="sr-only" for="mr">Medical Record Number</label>
                                <input type="text" class="form-control mb-2 mr-sm-2" id="mr" placeholder="Type medrec" name="mr" />
                            </div>
                            <div class="col-auto">
                                <button type="" class="btn btn-primary mb-2" id="btnSearchBrw">Find</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="brwForm">
                    
                    <!-- fieldsets -->
                    <fieldset class="tab current">
                        <div class="form-card">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">Name</label>
                                    <input type="name" class="form-control" id="inputName" placeholder="name" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputBirthPlace">Birth Place</label>
                                    <input type="text" class="form-control" id="inputBirthPlace" placeholder="birth place" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputBirthDate">Birth Date</label>
                                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" id="inputBirthDate" disabled />
                                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="textAddress">Address</label>
                                    <textarea class="form-control" id="textAddress" placeholder="Address" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <button class="next btn btn-primary" >Next</button>
                    </fieldset>
                    
                    <!-- fieldset 2 -->
                    <fieldset class="tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="card-title text-left mb-3">
                                    Borrower
                                </h5>
                                <div class="form-row align-items-center">
                                    <div class="col-md col-lg-10">
                                        <label class="sr-only" for="inputBorrower">Borrower's name</label>
                                        <input type="text" class="form-control mb-2 mr-sm-2" id="inputBorrower" placeholder="Type the borrower" name="borrower" />
                                    </div>
                                </div>

                                <div class="form-card">
                                    <div class="form-row">
                                        <div class="form-group col-lg">
                                            <label for="inputDept">Department</label>
                                            <input type="text" name="dept" class="form-control" id="inputDept" placeholder="Department" disabled />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg">
                                            <label for="inputNecsty">Necessity</label>
                                            <input type="text" name="necessity" class="form-control" id="inputNecsty" placeholder="Necessity" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <h5 class="card-title text-left mb-3">
                                    Lender
                                </h5>
                                <div class="form-row align-items-center">
                                    <div class="col-md col-lg-10">
                                        <label class="sr-only" for="inputBorrower">Borrower's name</label>
                                        <input type="text" class="form-control mb-2 mr-sm-2" id="inputBorrower" name="borrower" value=" <?=ucwords($user['first_name']) .' ' . ucwords($user['last_name']) ?>" disabled />
                                    </div>
                                </div>

                                <div class="form-card">
                                    <div class="form-row">
                                        <div class="form-group col-auto">
                                        <label for="inputReturnDate">Return Date</label>
                                            <div class="input-group date" id="returnPickerDate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input date-validate" data-target="#returnPickerDate" id="inputDate" />
                                                <div class="input-group-append" data-target="#returnPickerDate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg">
                                            <label for="inputDescBrw">Description</label>
                                            <input type="text" name="descBrw" class="form-control" id="inputDescBrw" placeholder="Description" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="previous btn btn-light">Previous</button>
                        <button class="submit btn btn-primary" id="confirmBrwBtn" >Confirm</button>
                        <!-- <button class="submit d-none">Next</button> -->
                    </fieldset>

                    <fieldset class="tab" id="borrowComplete">
                        <div class="form-card">
                            <h2 class="fs-title text-center">Success !</h2> <br><br>
                            <div class="success-checkmark">
                                <div class="check-icon">
                                    <span class="icon-line line-tip"></span>
                                    <span class="icon-line line-long"></span>
                                    <div class="icon-circle"></div>
                                    <div class="icon-fix"></div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5>You Have Successfully Signed Up</h5>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>