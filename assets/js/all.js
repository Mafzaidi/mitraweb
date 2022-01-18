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
		$("#brwForm").validate({
			// initialize plugin
			// your rules & options,
			focusInvalid: false,
			rules: {
				mr: "required",
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
						$("#inputDate").val(data.TGL_LAHIR);
						$("#textAddress").val(data.ALAMAT);
						$("#brwForm .next").prop("disabled", false);

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
						//pageInit();
					},
					error: function (data) {
						//alert(JSON.stringify(data));
						//pageInit();
					},
				});
				return false; // blocks regular submit since you have ajax
			},
		});

		$("#inputTextMr").inputFilter(function (value) {
			return /^\d*$/.test(value); // Allow digits only, using a RegExp
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
			pageInit();
		});

		function pageInit() {
			$(".input-check").on("change", function () {
				$(".input-check").not(this).prop("checked", false);
			});

			$("#selectmedrec").click(function () {
				$.each($(".input-check:checked"), function () {
					alert($(this).val());
				});
			});
		}

		// Polimon

		$("#tab_polimon a[data-toggle=tab]").click(function (e) {
			//e.preventDefault();

			if (this.id == "t1") {
				var batal = "N";
				var jml_dr = 0;
				var resep = "N";
				var selesai = "N";
				var pageStart = 1;
				var per_page = $("#select_pageSize option:selected").val();
				var func_url = base_url + "functions/Counter_func/getDataPolimon";
				var bg_color = "bg-cool";
			} else if (this.id == "t2") {
				var batal = "N";
				var jml_dr = 0;
				var resep = "Y";
				var selesai = "N";
				var pageStart = 1;
				var per_page = $("#select_pageSize option:selected").val();
				var func_url = base_url + "functions/Counter_func/getDataPolimon";
				var bg_color = "bg-love";
			} else if (this.id == "t3") {
				var batal = "N";
				var jml_dr = 0;
				var resep = "Y";
				var selesai = "Y";
				var pageStart = 1;
				var per_page = $("#select_pageSize option:selected").val();
				var func_url = base_url + "functions/Counter_func/getDataPolimon";
				var bg_color = "bg-cure";
			} else if (this.id == "t4") {
				var batal = "Y";
				var jml_dr = 0;
				var resep = "N";
				var selesai = "N";
				var pageStart = 1;
				var per_page = $("#select_pageSize option:selected").val();
				var func_url = base_url + "functions/Counter_func/getDataPolimon";
				var bg_color = "bg-dizzy";
			}

			$.ajax({
				type: "POST",
				dataType: "json",
				url: func_url,
				data: {
					batal: batal,
					jml_dr: jml_dr,
					resep: resep,
					selesai: selesai,
					pageStart: pageStart,
					per_page: per_page,
				},
				success: function (data) {
					// alert(JSON.stringify(data));
					//alert(data[0].no);
					var tb = "";
					tb += '<div class="tb">';

					tb += '<div class="tb-header ' + bg_color + '">';
					tb += '<div class="row">';
					tb += '<div class="col-md-1">NO.</div>';
					tb += '<div class="col-md-1">MEDREC</div>';
					tb += '<div class="col-md-3">PASIEN</div>';
					tb += '<div class="col-md-3">DOKTER</div>';
					tb += '<div class="col-md-1">NO URUT</div>';
					tb += '<div class="col-md-1">NO STRUK</div>';
					tb += '<div class="col-md-2">JAM</div>';
					tb += "</div>";
					tb += "</div>";

					tb += '<div class="tb-body">';
					for (var i = 0; i < data.length; i++) {
						var oddEven = "";
						if (i % 2 == 0) {
							oddEven = "even";
						} else {
							oddEven = "odd";
						}
						tb += '<div class="row border-bottom ' + oddEven + '">';
						tb += '<div class="col-md-1">' + data[i].no + "</div>";
						tb += '<div class="col-md-1">' + data[i].medrec + "</div>";
						tb += '<div class="col-md-3">' + data[i].pasien + "</div>";
						tb += '<div class="col-md-3">' + data[i].dokter + "</div>";
						tb += '<div class="col-md-1">' + data[i].no_urut + "</div>";
						tb += '<div class="col-md-1">' + data[i].no_struk + "</div>";
						tb += '<div class="col-md-2">' + data[i].jam + "</div>";
						tb += "</div>";
					}

					tb += "</div>";

					tb += "</div>";
					$("#data_polimon").html("");
					$("#data_polimon").html(tb);
					pageInit();
				},
				error: function (data) {
					alert(JSON.stringify(data));
					//pageInit();
				},
			});
		});

		$("#select_pageSize").on("change", function () {
			var per_page = $("#select_pageSize option:selected").val();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: base_url + "functions/Counter_func/getDataPolimon",
				data: {
					per_page: per_page,
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
	});
	$("#polimon_wrapper .nav-link").click(function () {
		$("#polimon_wrapper .nav-link").removeClass("active");
		$(this).addClass("active");
	});

	// $('#polimon-pagination').on('click','a',function(e){
	// 	e.preventDefault();
	// });
})(jQuery); // End of use strict
