(function ($) {
	"use strict"; // Start of use strict

	var _URL = window.URL || window.webkitURL;
	var base_url = $("#baseUrl").val();
	var current_url = $(location).attr("href");
	var segments = current_url.split("/");
	var sixth_segment = segments[6];

	var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

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

		page_polimon_click();
		detail_polimon_click();
	}

	$("#datetimepicker4").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#birthDate_picker").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#fromDateRpt_picker").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#toDateRpt_picker").datetimepicker({
		format: "DD.MM.yyyy",
	});
	// $("#returnDate_picker").datetimepicker({
	// 	format: "DD.MM.yyyy",
	// });

	// $('#returnDate_picker').datetimepicker({
	// 	defaultDate: new Date()
	// });

	$("#sidebarToggle").on("click", function () {
		$("#content-wrapper").toggleClass("sidebar-hidden");
	});

	$("#searchMrFilterToggler").on("click", function () {
		$("#searchMr").toggleClass("filter-hidden");
	});

	$(".input-single-check").on("change", function () {
		$(".input-single-check").not(this).prop("checked", false);
	});

	// ***************************************************************************************************
	$(document).ready(function () {
		var val = {
			// Specify validation rules
			rules: {				
				mr: "required",
				borrower: "required",
				dept: "required",
				necessity: "required",
				lender: "required",
				descBrw: "required"
			},
			// Specify validation error messages
			messages: {
				mr: "Type medical record number",
				borrower: "Type medical record number",
			},
		};
		$("#formBrwMr").multiStepForm({
			// defaultStep:0,
			beforeSubmit: function (form, submit) {
				console.log("called before submiting the form");
				console.log(form);
				console.log(submit);
			},
			validations: val,
		});
		
		$("#formBrwMr").validate({
			// initialize plugin
			// your rules & options,
			focusInvalid: false,
			rules: {
				mr: "required",
				borrower: "required",
				dept: "required",
				necessity: "required",
				lender: "required",
				descBrw: "required"
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
						$("#inputReturnDate").val(data.TGL_LAHIR);
						$("#textAddress").val(data.ALAMAT);
						$("#formBrwMr .next").prop("disabled", false);

						$('#returnDate_picker').datetimepicker({
							"date": today,
							"format": "DD.MM.yyyy",
						});

						$("#saveMr_borrow").click(function () {
							
							var medrec = $("#mr").val();
							var nokar_peminjam = $("#inputBorrower").attr("nokar");
							var keperluan = $("#inputNecsty").val();
							var dept_peminjam = $("#inputDept").val();

							var created_by = $("#inputLender").attr("nokar");
							var diserahkan_oleh = $("#inputLender").val();
							var tgl_janji_kembali = $("#inputReturnDate").val();
							var catatan = $("#inputDescBrw").val();
							$.ajax({
								type: "POST",
								dataType: "json",
								url: base_url + "functions/Medrec_func/saveMrBorrow",
								data: {
									medrec: medrec,
									nokar_peminjam: nokar_peminjam,
									keperluan: keperluan,
									dept_peminjam: dept_peminjam,
									created_by: created_by,
									diserahkan_oleh: diserahkan_oleh,
									tgl_janji_kembali: tgl_janji_kembali,
									catatan: catatan,
								},
								success: function (data) {
									alert(JSON.stringify(data));
									$(".next").click();
									//pageInit();
								},
								error: function (data) {
									// alert(JSON.stringify(data));
									//pageInit();
								},
							});
						});
						pageInit();
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
				$("#inputBorrower").attr("nokar",ui.item.id)
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
					pageInit();
				},
				error: function (data) {
					alert(JSON.stringify(data));
					pageInit();
				},
			});
		});

		// Modal function
		$("#myDynamicModal").on("hidden.bs.modal", function (event) {
			if($(this).hasClass("save")){

			} else {
				$("#myDynamicModal .modal-body").html("");
			}
		});

		$("#myDynamicModal").on("shown.bs.modal", function (event) {
			$("#selectMedrec").click(function () {
				$.each($(".input-single-check:checked"), function () {
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
							pageInit();
						},
						error: function (data) {
							alert(JSON.stringify(data));
							pageInit();
						},
					});
				});
			});

			$(".input-single-check").on("change", function () {
				$(".input-single-check").not(this).prop("checked", false);
			});
		});

		$("#inputTextName").keyup(function () {
			$(this).val($(this).val().toUpperCase());
		});
		//autoLoad_polimon();
		if (segments[6] !== "" && segments[6] == "poli-monitor") {
			autoLoad_polimon();
		}

		pageInit();
	});

	// Polimon

	$("#polimon_wrapper .nav-link").click(function () {
		$("#polimon_wrapper .nav-link").removeClass("active");
		$(this).addClass("active");
	});

	function autoLoad_polimon() {
		function RecurringTimer(callback, delay) {
			var timerId,
				start,
				remaining = delay;

			this.pause = function () {
				window.clearTimeout(timerId);
				remaining -= new Date() - start;
			};

			var resume = function () {
				start = new Date();
				timerId = window.setTimeout(function () {
					remaining = delay;
					resume();
					callback();
				}, remaining);
			};

			this.resume = resume;

			this.resume();
		}

		function Timer(callback, delay) {
			var timerId,
				start,
				remaining = delay;

			this.pause = function () {
				window.clearTimeout(timerId);
				remaining -= new Date() - start;
			};

			this.resume = function () {
				start = new Date();
				window.clearTimeout(timerId);
				timerId = window.setTimeout(callback, remaining);
			};

			this.resume();
		}

		var timer = new RecurringTimer(function () {
			// console.log(sixth_segment);
			refreshPolimon();
		}, 5000);

		$("#inputSearchPolimon").focus(function () {
			timer.pause();
		});

		$("#dropdownFilterPolimon").focus(function () {
			timer.pause();
		});

		$("#inputSearchPolimon").focusout(function () {
			timer.resume();
		});

		$("#dropdownFilterPolimon").focusout(function () {
			timer.resume();
		});

		$("#btnStartPausePolimon").on("click", function () {
			 //alert($(this).html());
			//timer.pause();
			if ($(this).html() == "Pause"){
				timer.pause();
				$(this).removeClass("btn-primary");
				$(this).addClass("btn-danger");
				$("#pausedTag").removeClass("d-none");
				$(this).html("Start");
			} else {
				timer.resume();
				$(this).removeClass("btn-danger");
				$(this).addClass("btn-primary");
				$("#pausedTag").addClass("d-none");
				$(this).html("Pause");
			}
		});

		// $('.sort-col').toggle(function(){
		// 	$(this).addClass('asc');
		// 	timer.pause();
		// },
		// function(){
		// 	$(this).removeClass('asc').addClass('desc');
		// 	timer.pause();
		// },
		// function(){
		// 	$(this).removeClass('desc');
		// 	timer.resume();
		// });
		// $('.sort-col').toggle(function(){
		// });
	}

	function refreshPolimon() {
		// console.log("1");
		var pageno = $("#polimon-pagination")
			.find(".active")
			.find(".page-link")
			.html();
		var pageselect = $("#select_pageSize option:selected").val();

		var ctr_daftar = "";
		var ctr_batal = "";
		var ctr_selesai = "";
		var jml_dr = 0;
		var dr_selesai = "";
		var ada_resep = "";
		var ada_lab = "";
		var ada_rad = "";
		var page_start = 1;
		var per_page = $("#select_pageSize option:selected").val();
		var search = "";
		var func_url = base_url + "functions/Counter_func/getDataPolimon/";

		if (pageselect !== "" && pageselect !== undefined) {
			if (pageno !== "" && pageno !== undefined) {
				page_start = (pageno - 1) * pageselect + 1;
				func_url = base_url + "functions/Counter_func/getDataPolimon/" + pageno;
			} else {
				pageno = 0;
				page_start = 1;
				func_url = base_url + "functions/Counter_func/getDataPolimon/";
			}
		}

		if (
			$(
				"#polimon_wrapper .dropdown input[type='checkbox'][name='checkfilter']:checked"
			).length
		) {
			ctr_daftar = "NONE";
			dr_selesai = "NONE";
			ctr_selesai = "NONE";
			ctr_batal = "NONE";
			$.each(
				$(
					"#polimon_wrapper .dropdown input:checkbox[name='checkfilter']:checked"
				),
				function (i) {
					if ($(this).attr("id") == "counterCheck") {
						ctr_daftar = $(this).val();
					} else if ($(this).attr("id") == "consultCheck") {
						dr_selesai = $(this).val();
					} else if ($(this).attr("id") == "finishCheck") {
						ctr_selesai = $(this).val();
					} else if ($(this).attr("id") == "cancelCheck") {
						ctr_batal = $(this).val();
					}
				}
			);
		} else {
			ctr_daftar = "";
			dr_selesai = "";
			ctr_selesai = "";
			ctr_batal = "";
		}

		console.log(page_start, per_page, pageno, pageselect, func_url);

		loadPolimon(
			ctr_daftar,
			dr_selesai,
			ctr_selesai,
			ctr_batal,
			jml_dr,
			ada_resep,
			ada_lab,
			ada_rad,
			page_start,
			per_page,
			search,
			func_url
		);
	}

	$("#select_pageSize").on("change", function () {
		var pageno = $("#polimon-pagination")
			.find(".active")
			.find(".page-link")
			.html();
		var pageselect = $("#select_pageSize option:selected").val();

		var ctr_daftar = "";
		var dr_selesai = "";
		var ctr_selesai = "";
		var ctr_batal = "";
		var jml_dr = 0;
		var ada_resep = "";
		var ada_lab = "";
		var ada_rad = "";
		var page_start = 1;
		var per_page = $("#select_pageSize option:selected").val();
		var search = "";
		var func_url = base_url + "functions/Counter_func/getDataPolimon/";

		if (pageselect !== "" && pageselect !== undefined) {
			if (pageno !== "" && pageno !== undefined) {
				page_start = (pageno - 1) * pageselect + 1;
				func_url = base_url + "functions/Counter_func/getDataPolimon/" + pageno;
			} else {
				pageno = 0;
				page_start = 1;
				func_url = base_url + "functions/Counter_func/getDataPolimon/";
			}
		}

		if (
			$(
				"#polimon_wrapper .dropdown input[type='checkbox'][name='checkfilter']:checked"
			).length
		) {
			ctr_daftar = "NONE";
			dr_selesai = "NONE";
			ctr_selesai = "NONE";
			ctr_batal = "NONE";
			$.each(
				$(
					"#polimon_wrapper .dropdown input:checkbox[name='checkfilter']:checked"
				),
				function (i) {
					if ($(this).attr("id") == "counterCheck") {
						ctr_daftar = $(this).val();
					} else if ($(this).attr("id") == "consultCheck") {
						dr_selesai = $(this).val();
					} else if ($(this).attr("id") == "finishCheck") {
						ctr_selesai = $(this).val();
					} else if ($(this).attr("id") == "cancelCheck") {
						ctr_batal = $(this).val();
					}
				}
			);
		} else {
			ctr_daftar = "";
			dr_selesai = "";
			ctr_selesai = "";
			ctr_batal = "";
		}

		loadPolimon(
			ctr_daftar,
			dr_selesai,
			ctr_selesai,
			ctr_batal,
			jml_dr,
			ada_resep,
			ada_lab,
			ada_rad,
			page_start,
			per_page,
			search,
			func_url
		);
	});

	function page_polimon_click() {
		$("#polimon-pagination").on("click", "a", function (e) {
			e.preventDefault();
			var pageno = $(this).attr("data-ci-pagination-page");
			var pageselect = $("#select_pageSize option:selected").val();

			var ctr_daftar = "";
			var dr_selesai = "";
			var ctr_selesai = "";
			var ctr_batal = "";
			var jml_dr = 0;
			var ada_resep = "";
			var ada_lab = "";
			var ada_rad = "";
			var page_start = (pageno - 1) * pageselect + 1;
			var per_page = $("#select_pageSize option:selected").val();
			var search = "";
			var func_url =
				base_url + "functions/Counter_func/getDataPolimon/" + pageno;

				if (
					$(
						"#polimon_wrapper .dropdown input[type='checkbox'][name='checkfilter']:checked"
					).length
				) {
					ctr_daftar = "NONE";
					dr_selesai = "NONE";
					ctr_selesai = "NONE";
					ctr_batal = "NONE";
					$.each(
						$(
							"#polimon_wrapper .dropdown input:checkbox[name='checkfilter']:checked"
						),
						function (i) {
							if ($(this).attr("id") == "counterCheck") {
								ctr_daftar = $(this).val();
							} else if ($(this).attr("id") == "consultCheck") {
								dr_selesai = $(this).val();
							} else if ($(this).attr("id") == "finishCheck") {
								ctr_selesai = $(this).val();
							} else if ($(this).attr("id") == "cancelCheck") {
								ctr_batal = $(this).val();
							}
						}
					);
				} else {
					ctr_daftar = "";
					dr_selesai = "";
					ctr_selesai = "";
					ctr_batal = "";
				}

			// alert(ctr_daftar, dr_selesai, ctr_selesai, ctr_batal);
			loadPolimon(
				ctr_daftar,
				dr_selesai,
				ctr_selesai,
				ctr_batal,
				jml_dr,
				ada_resep,
				ada_lab,
				ada_rad,
				page_start,
				per_page,
				search,
				func_url
			);
		});
	}

	$("#inputSearchPolimon").bind("enterKey", function (e) {
		//do stuff here
		var ctr_daftar = "";
		var ctr_batal = "";
		var ctr_selesai = "";
		var jml_dr = 0;
		var dr_selesai = "";
		var ada_resep = "";
		var ada_lab = "";
		var ada_rad = "";
		var page_start = 1;
		var per_page = "";
		var search = $(this).val().toUpperCase();
		var func_url = base_url + "functions/Counter_func/getDataPolimon/";
		// alert(search);

		loadPolimon(
			ctr_daftar,
			dr_selesai,
			ctr_selesai,
			ctr_batal,
			jml_dr,
			ada_resep,
			ada_lab,
			ada_rad,
			page_start,
			per_page,
			search,
			func_url
		);

		// alert($(this).val());
	});
	$("#inputSearchPolimon").keyup(function (e) {
		if (e.keyCode == 13) {
			$(this).trigger("enterKey");
		}
	});

	$(document).on("click", "#polimon_wrapper .dropdown-menu", function (e) {
		e.stopPropagation();
	});

	$("#allCheck").change(function () {
		var checkboxes = $(this)
			.closest(".dropdown")
			.find(":checkbox")
			.not($(this));
		checkboxes.prop("checked", $(this).is(":checked"));
	});

	$("#submitFilterPolimon").on("click", function () {
		var ctr_daftar = "";
		var dr_selesai = "";
		var ctr_selesai = "";
		var ctr_batal = "";
		var jml_dr = 0;
		var ada_resep = "";
		var ada_lab = "";
		var ada_rad = "";
		var page_start = 1;
		var per_page = "";
		var search = "";
		var func_url = base_url + "functions/Counter_func/getDataPolimon/";

		if (
			$(
				"#polimon_wrapper .dropdown input[type='checkbox'][name='checkfilter']:checked"
			).length
		) {
			ctr_daftar = "NONE";
			dr_selesai = "NONE";
			ctr_selesai = "NONE";
			ctr_batal = "NONE";
			$.each(
				$(
					"#polimon_wrapper .dropdown input:checkbox[name='checkfilter']:checked"
				),
				function (i) {
					if ($(this).attr("id") == "counterCheck") {
						ctr_daftar = $(this).val();
					} else if ($(this).attr("id") == "consultCheck") {
						dr_selesai = $(this).val();
					} else if ($(this).attr("id") == "finishCheck") {
						ctr_selesai = $(this).val();
					} else if ($(this).attr("id") == "cancelCheck") {
						ctr_batal = $(this).val();
					}
				}
			);
		} else {
			ctr_daftar = "";
			dr_selesai = "";
			ctr_selesai = "";
			ctr_batal = "";
		}

		loadPolimon(
			ctr_daftar,
			dr_selesai,
			ctr_selesai,
			ctr_batal,
			jml_dr,
			ada_resep,
			ada_lab,
			ada_rad,
			page_start,
			per_page,
			search,
			func_url
		);
		console.log(ctr_daftar, dr_selesai, ctr_selesai, ctr_batal);
	});

	function detail_polimon_click() {
		$(".btn-detail-polimon").on("click", function () {
			var mr = $(this).attr("mr");
			var dokter_id = $(this).attr("dr");

			// console.log(mr, dokter_id);
		});
	}

	function loadPolimon(
		ctr_daftar,
		dr_selesai,
		ctr_selesai,
		ctr_batal,
		jml_dr,
		ada_resep,
		ada_lab,
		ada_rad,
		page_start,
		per_page,
		search,
		func_url
	) {
		var tb = "";

		$.ajax({
			type: "POST",
			dataType: "json",
			url: func_url,
			data: {
				ctr_daftar: ctr_daftar,
				dr_selesai: dr_selesai,
				ctr_selesai: ctr_selesai,
				ctr_batal: ctr_batal,
				jml_dr: jml_dr,
				ada_resep: ada_resep,
				ada_lab: ada_lab,
				ada_rad: ada_rad,
				page_start: page_start,
				per_page: per_page,
				search: search,
			},
			success: function (data) {
				//alert(JSON.stringify(data));
				var rcount = data.response.length;

				// tb += '<div class="tb-body">';
				for (var i = 0; i < rcount; i++) {
					var oddEven = "";
					if (i % 2 == 0) {
						oddEven = "even-row";
					} else {
						oddEven = "odd-row";
					}
					var stat_cls = "";
					if (data.response[i].status == "COUNTER DAFTAR") {
						stat_cls = "bg-primary-2";
					} else if (data.response[i].status == "DOKTER SELESAI") {
						stat_cls = "bg-warning-2";
					} else if (data.response[i].status == "COUNTER SELESAI") {
						stat_cls = "bg-success-2";
					} else if (data.response[i].status == "COUNTER BATAL") {
						stat_cls = "bg-danger-2";
					} else {
					}
					tb +=
						'<div class="row tb-row border-bottom ' +
						stat_cls +
						" " +
						oddEven +
						'">';
					tb +=
						'<div class="col-md-1 tb-cell">' + data.response[i].no + "</div>";
					tb +=
						'<div class="col-md-1 tb-cell">' +
						data.response[i].medrec +
						"</div>";
					tb +=
						'<div class="col-md-2 tb-cell">' +
						data.response[i].pasien +
						"</div>";
					tb +=
						'<div class="col-md-3 tb-cell">' +
						data.response[i].dokter +
						"</div>";
					tb +=
						'<div class="col-md-1 tb-cell">' +
						data.response[i].no_urut +
						"</div>";
					tb +=
						'<div class="col-md-2 tb-cell">' +
						data.response[i].no_struk +
						"</div>";
					tb +=
						'<div class="col-md-2 tb-cell">' +
						data.response[i].jam_daftar +
						"</div>";

					tb += "</div>";
				}

				var num1 = page_start;
				if (per_page !== "") {
					if (per_page > data.count) {
						var num2 = data.count;
					} else {
						var num2 = per_page;
					}
				} else {
					var num2 = data.count;
				}
				var total = data.count;

				$("#data_polimon .tb-body").html("");
				$("#data_polimon .tb-body").html(tb);

				$("#dataTable_info").html("");
				$("#dataTable_info").html(
					"Showing " + num1 + " " + "to" + " " + num2 + " " + "of" + " " + total
				);

				$("#pages_polimon").html("");
				$("#pages_polimon").html(data.pagination);

				pageInit();
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				if (data.response === null || data.response === undefined) {
					tb += '<div class="row">';
					tb +=
						'<div class="col-md-12 bg-danger-2 text-center">NO DATA FOUND</div>';
					tb += "</div>";
					tb += "</div>";

					$("#data_polimon .tb-body").html("");
					$("#data_polimon .tb-body").html(tb);

					$("#dataTable_info").html("");
					$("#dataTable_info").html("Showing 0 to 0 of 0");
				}
				pageInit();
			},
		});

		var table = document.getElementById("polimonTable"),
			tableHead = table.querySelector("div.tb-header"),
			tableHeaders = tableHead.querySelectorAll("div.tb-label"),
			tableBody = table.querySelector("div.tb-body");
		tableHead.addEventListener("click", function (e) {
			var tableHeader = e.target,
				textContent = tableHeader.textContent,
				tableHeaderIndex,
				isAscending,
				order;
			if (textContent !== "add row") {
				// Note: the value in the tableHeader.nodeName check must be UPPERCASE
				while (tableHeader.nodeName !== "DIV") {
					tableHeader = tableHeader.parentNode;
				}
				tableHeaderIndex = Array.prototype.indexOf.call(
					tableHeaders,
					tableHeader
				);
				isAscending = tableHeader.getAttribute("data-order") === "asc";
				order = isAscending ? "desc" : "asc";
				tableHeader.setAttribute("data-order", order);
				tinysort(tableBody.querySelectorAll("div.tb-row"), {
					selector: "div.tb-cell:nth-child(" + (tableHeaderIndex + 1) + ")",
					order: order,
				});
			}
		});
	}
})(jQuery); // End of use strict
