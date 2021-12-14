<div class="container-fluid p-5">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> -->
    <form class="form-inline" action="<?php echo base_url('medrec/medrec_func/getDataMR');?>" id="getMR">
        <label class="sr-only" for="inlineFormInputName2">Medical Record Number</label>
        <input type="text" class="form-control mb-2 mr-sm-2" id="inputMR" placeholder="Type medrec" name="medrec">

        <button type="submit" class="btn btn-primary mb-2" id="btnSearch">Submit</button>
    </form>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputName">Name</label>
                <input type="name" class="form-control" id="inputName" placeholder="name" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputBirthPlace">Birth Place</label>
                <input type="text" class="form-control" id="inputBirthPlace" placeholder="birth place" disabled>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Birth Date</label>
                <input type="text" class="form-control" id="datetimepicker1" placeholder="birth date" disabled>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
</div>