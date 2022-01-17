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

	$("#birthDateTime_picker").datetimepicker({
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
	$(document).ready(function () {
		pageInit();

		$("#brwForm").validate({
			// initialize plugin
			// your rules & options,
			focusInvalid: false,
			rules: {
				mr: "required",
				borrower: "required",
				necessity: "required",
			},
			submitHandler: function (form) {
				// your ajax would go here
				var mr = $("#mr").val();
				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Medrec_func/getDataMR",
					data: {
						mr: mr,
					},
					success: function (data) {
						//alert(JSON.stringify(data));
						$("#inputName").val(data.NAMA);
						$("#inputBirthPlace").val(data.TEMPAT_LAHIR);
						$("#inputBirthDate").val(data.TGL_LAHIR);
						$("#textAddress").val(data.ALAMAT);
						$("#brwForm .next").prop("disabled", false);

						$("#confirmBrwBtn").click(function () {
							$("#myDynamicModal").modal("show");
						});
						pageInit();
					},
					error: function (data) {
						//alert(JSON.stringify(data));
						pageInit();
					},
				});

				// $("#confirmBrwBtn").click(function () {
				// 	$("#myDynamicModal").modal("show");
				// });

				return false; // blocks regular submit since you have ajax
			},
		});

		$("#inputTextMr").inputFilter(function (value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
		});
	});

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

	$("#btnSearchMr").click(function () {
		var mr = $("#inputTextMr").val();
		var name = $("#inputTextName").val();
		var birth_date = $("#inputBirthDate").val();
		var telp = $("#inputTextTelp").val();
		var address = $("#inputTextAddress").val();
		var parent = $("#inputTextParent").val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Counter_func/searchMedrec",
			data: {
				mr: mr,
				name: name,
				birth_date: birth_date,
				telp: telp,
				address: address,
				parent: parent,
			},
			success: function (data) {
				//alert(JSON.stringify(data));
				$("#myDynamicModal .modal-body").append(data["html"]);
				$("#myDynamicModal").modal("show");
				//pageInit();
			},
			error: function (data) {
				alert(JSON.stringify(data));
				//pageInit();
			},
		});
	});

	// Modal function
	$("#myDynamicModal").on("hidden.bs.modal", function (event) {
		$("#myDynamicModal .modal-body").html("");
	});

	$("#myDynamicModal").on("shown.bs.modal", function (event) {
		$(".input-check").on("change", function () {
			$(".input-check").not(this).prop("checked", false);
		});

		$("#selectMedrec").click(function () {
			$.each($(".input-check:checked"), function () {
				var mr = $(this).val();
				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Counter_func/getMedrec",
					data: {
						mr: mr,
					},
					success: function (data) {
						//alert(JSON.stringify(data));
						$("#inputDataMr").val(data.mr);
						$("#inputDataName").val(data.nama);
						$("#inputDataAddress").val(data.alamat);
						$("#inputDataCity").val(data.kota);
						$("#inputDataRegency").val(data.kecamatan);
						$("#inputDataDistrict").val(data.kelurahan);
						$("#inputDataBirthPlace").val(data.tempat_lahir);
						$("#inputDataBirthDate").val(data.tgl_lahir);
						if (data.hp !== "") {
							$("#inputDataTelp").val(data.hp);
						} else if (data.hp == "" && data.telp !== "") {
							$("#inputDataTelp").val(data.telp);
						} else {
							$("#inputDataTelp").val("");
						}
						//pageInit();
					},
					error: function (data) {
						alert(JSON.stringify(data));
						//pageInit();
					},
				});
			});
		});
	});

	function pageInit() {
		$(".date-validate").mask("99.99.9999");
		$(".date-validate").change(function () {
			if (
				$(this).val().substring(0, 2) > 12 ||
				$(this).val().substring(0, 2) == "00"
			) {
				alert("Iregular Month Format");
				return false;
			}
			if (
				$(this).val().substring(3, 5) > 31 ||
				$(this).val().substring(0, 2) == "00"
			) {
				alert("Iregular Date Format");
				return false;
			}
		});
	}
})(jQuery); // End of use strict
