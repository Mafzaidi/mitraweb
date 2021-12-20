(function ($) {
	"use strict"; // Start of use strict

	var _URL = window.URL || window.webkitURL;
	$("#datetimepicker4").datetimepicker({
		format: "dd.mm.yyyy",
	});

	$("#sidebarToggle").on("click", function () {
		$("#content-wrapper").toggleClass("sidebar-hidden");
	});

	// Close any open menu accordions when window is resized below 768px
	$(window).resize(function () {
		if ($(window).width() < 768) {
			// $("[data-toggle='collapse']").click(function (event) {
			// 	event.stopPropagation();
			// 	var thisModal = $(this).attr("data-target");
			// });
			$(".sidebar .collapse").collapse("hide");
		}
	});

	$("#btnSearch").on("click", function (e) {
		var mr = $("#inputMR").val();
		//alert(user);
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "<?= base_url(); ?>medrec/Medrec_func/getDataMR",
			data: {
				mr: mr,
			},
			success: function (data) {
				alert(JSON.stringify(data));
				$("#inputName").val(data.NAMA);
				$("#inputBirthPlace").val(data.TEMPAT_LAHIR);
				$("#inputDate").val(data.TGL_LAHIR);
				$("#textAddress").val(data.ALAMAT);
				//pageInit();
			},
			error: function (data) {
				alert(JSON.stringify(data));
				//pageInit();
			},
		});
	});
})(jQuery); // End of use strict
