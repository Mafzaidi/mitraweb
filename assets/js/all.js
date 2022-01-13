(function ($) {
	"use strict"; // Start of use strict

	var _URL = window.URL || window.webkitURL;
	var base_url = $("#baseUrl").val();

	$("#datetimepicker4").datetimepicker({
		format: "DD.MM.yyyy",
	});
	$("#returnPickerDate").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#sidebarToggle").on("click", function () {
		$("#content-wrapper").toggleClass("sidebar-hidden");
	});

	$("#searchMrFilterToggler").on("click", function () {
		$("#searchMr").toggleClass("filter-hidden");
	});

	$(document).ready(function () {
		var val = {
			// Specify validation rules
			rules: {
				mr: "required",
				borrower: "required",
			},
			// Specify validation error messages
			messages: {
				mr: "Type medical record number",
				borrower: "Type medical record number",
			},
		};
		$("#brwForm").multiStepForm({
			// defaultStep:0,
			beforeSubmit: function (form, submit) {
				console.log("called before submiting the form");
				console.log(form);
				console.log(submit);
			},
			validations: val,
		});
	});

	// ***************************************************************************************************
	// $(document).ready(function () {
	// 	$("#brwForm").validate({
	// 		// initialize plugin
	// 		// your rules & options,
	// 		focusInvalid: false,
	// 		rules: {
	// 			mr: "required",
	// 		},
	// 		submitHandler: function (form) {
	// 			// your ajax would go here
	// 			var mr = $("#mr").val();
	// 			$.ajax({
	// 				type: "POST",
	// 				dataType: "json",
	// 				url: base_url + "functions/Medrec_func/getDataMR",
	// 				data: {
	// 					mr: mr,
	// 				},
	// 				success: function (data) {
	// 					//alert(JSON.stringify(data));
	// 					$("#inputName").val(data.NAMA);
	// 					$("#inputBirthPlace").val(data.TEMPAT_LAHIR);
	// 					$("#inputDate").val(data.TGL_LAHIR);
	// 					$("#textAddress").val(data.ALAMAT);
	// 					$("#brwForm .next").prop("disabled", false);

	// 					$("#save_mr_borrow").click(function () {
	// 						$.ajax({
	// 							type: "POST",
	// 							dataType: "json",
	// 							url: base_url + "functions/Medrec_func/saveMrBorrow",
	// 							data: {
	// 								mr: mr,
	// 							},
	// 							success: function (data) {
	// 								//alert(JSON.stringify(data));
	// 								$(".submit").click();
	// 								//pageInit();
	// 							},
	// 							error: function (data) {
	// 								alert(JSON.stringify(data));
	// 								//pageInit();
	// 							},
	// 						});
	// 					});
	// 					//pageInit();
	// 				},
	// 				error: function (data) {
	// 					//alert(JSON.stringify(data));
	// 					//pageInit();
	// 				},
	// 			});
	// 			return false; // blocks regular submit since you have ajax
	// 		},
	// 	});
	// });
	// ***************************************************************************************************

	$("#inputBorrower").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: base_url + "functions/Medrec_func/getDataEmployee",
				type: "post",
				dataType: "json",
				data: {
					search: request.term,
				},
				success: function (data) {
					response(data);
					//alert(JSON.stringify(data));
				},
			});
		},
		select: function (event, ui) {
			// Set selection
			$("#inputBorrower").val(ui.item.label); // display the selected text
			$("#inputDept").val(ui.item.dept); // display the selected text
			return false;
		},
	});

	$("#save_mr_borrow").click(function () {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Medrec_func/saveMrBorrow",
			data: {
				mr: mr,
			},
			success: function (data) {
				//alert(JSON.stringify(data));
				$(".submit").click();
				//pageInit();
			},
			error: function (data) {
				alert(JSON.stringify(data));
				//pageInit();
			},
		});
	});

})(jQuery); // End of use strict
