<div class="container-fluid p-5">
    <!-- Page Heading -->
    <div class="form-row align-items-center">
        <div class="col-auto">
            <label class="sr-only" for="inputMR">Medical Record Number</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inputMR" placeholder="Type medrec" name="mr">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2" id="btnSearch">Submit</button>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputName">Name</label>
            <input type="name" class="form-control" id="inputName" placeholder="name" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputBirthPlace">Birth Place</label>
            <input type="text" class="form-control" id="inputBirthPlace" placeholder="birth place" disabled>
        </div>
        <div class="form-group col-md-3">
            <label for="inputState">Birth Date</label>
            <input type="text" class="form-control" id="datetimepicker1" placeholder="birth date" disabled>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="textAddress">Address</label>
            <textarea class="form-control" id="textAddress" placeholder="Address" disabled></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Next Step</button>

</div>