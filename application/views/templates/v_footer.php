<!-- Footer -->
<footer class="navbar bg-dark text-light mt-auto">
    <div class="container">
        <div class="copyright text-center mx-auto">
            <span>Copyright © Mitra Keluarga <?= date('Y'); ?></span>
			<input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>">
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Main Content -->
</div>
<!-- End of Content -->
</div>
<!-- End Of Wrapper -->

<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-4.6.1/dist/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>

<!-- Jquery UI -->
<script src="<?php echo base_url('assets/vendor/jquery-ui-1.13.0/jquery-ui.min.js'); ?>"></script>
<!-- datetimepicker jquery -->
<script src="<?php echo base_url('assets/vendor/date-time-picker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<!-- main.js -->
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

<script>

    var _URL = window.URL || window.webkitURL;
    $("#datetimepicker4").datetimepicker({
        format: "DD.MM.yyyy"
    });
	$("#returnPickerDate").datetimepicker({
        format: "DD.MM.yyyy"
    });


    // $("#btnSearch").on("click", function (e) {
	// 	var mr = $("#inputMR").val();
	// 	//alert(user);
	// 	$.ajax({
	// 		type: "POST",
	// 		dataType: "json",
	// 		url: "<?= base_url(); ?>functions/Medrec_func/getDataMR",
	// 		data: {
	// 			mr: mr,
	// 		},
	// 		success: function (data) {
	// 			//alert(JSON.stringify(data));
	// 			$("#inputName").val(data.NAMA);
	// 			$("#inputBirthPlace").val(data.TEMPAT_LAHIR);
	// 			$("#inputDate").val(data.TGL_LAHIR);
	// 			$("#textAddress").val(data.ALAMAT);
	// 			//pageInit();
	// 		},
	// 		error: function (data) {
	// 			alert(JSON.stringify(data));
	// 			//pageInit();
	// 		},
	// 	});
	// });

	$("#inputBorrower").autocomplete({
            source: function(request, response) {
            $.ajax({
				url:  base_url + "functions/Medrec_func/getName",
				dataType: "jsonp",
				data: {
					q: request.term
				},
				success: function(data) {
					response(data);
				}
            });
        },
        minLength: 3,
        select: function(event, ui) {
            // log( ui.item ?
            // "Selected: " + ui.item.label :
            // "Nothing selected, input was " + this.value);
        },
        open: function() {
            // $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            // $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });  

$(function(){
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    
});

</script>
</body>

</html>