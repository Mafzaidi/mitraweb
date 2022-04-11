(function ($) {
	"use strict"; // Start of use strict

	var _URL = window.URL || window.webkitURL;
	var base_url = $("#baseUrl").val();
	var current_url = $(location).attr("href");
	var segments = current_url.split("/");
	var sixth_segment = segments[6];

	var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

	$("#datetimepicker4").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#birthDate_picker").datetimepicker({
		format: "DD.MM.yyyy",
	});

	$("#fromDateRpt_picker").datetimepicker({
		date: today,
		format: "DD.MM.yyyy",
	});

	$("#toDateRpt_picker").datetimepicker({
		date: today,
		format: "DD.MM.yyyy",
	});

	$("#returnDate_picker").datetimepicker({
		date: today,
		format: "DD.MM.yyyy",
	});

	function pageInit() {
		$(".date-validate").mask("99.99.9999");
		$(".date-validate").change(function () {
			if (
				$(this).val().substring(0, 2) > 12 ||
				$(this).val().substring(0, 2) == "00"
			) {
				// alert("Iregular Month Format");
				return false;
			}
			if (
				$(this).val().substring(3, 5) > 31 ||
				$(this).val().substring(0, 2) == "00"
			) {
				// alert("Iregular Date Format");
				return false;
			}
		});

		page_polimon_click();
		detail_polimon_click();
	}

<<<<<<< HEAD
=======
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

>>>>>>> 32ff8c516a868b23cc378ebc8163b4fce0a629cd
	$("#sidebarToggle").on("click", function () {
		$("#content-wrapper").toggleClass("sidebar-hidden");
	});

	$("#searchMrFilterToggler").on("click", function () {
		$("#searchMr").toggleClass("filter-hidden");
	});

	$(".filter-toggler").on("click", function () {
		$(this).parent().parent().toggleClass("filter-hidden");
	});

	$(".input-single-check").on("change", function () {
		$(".input-single-check").not(this).prop("checked", false);
	});

	// ***************************************************************************************************
	$(document).ready(function () {
		var val = {
			focusInvalid: false,
			rules: {
				mr: {
					required: true,
					minlength: 6,
					maxlength: 7,
					digits: true,
				},
				borrower: "required",
				dept: "required",
				necessity: "required",
				lender: "required",
			},
			messages: {
				mr: {
					required: "Medrec harus di isi",
					minlength: "Please enter minimum 6 digit mobile number",
					maxlength: "Please enter maximum 7 digit mobile number",
					digits: "Only numbers are allowed in this field",
				},
				borrower: {
					required: "Peminjam harus di isi",
				},
				dept: {
					required: "Departemen harus di isi",
				},
				necessity: {
					required: "Keperluan harus di isi",
				},
				lender: {
					required: "Pemberi pinjam harus di isi",
				},
				descBrw: {
					required: "Keterangan harus di isi",
				},
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
				mr: {
					required: true,
					minlength: 6,
					maxlength: 7,
					digits: true,
				},
				borrower: "required",
				dept: "required",
				necessity: "required",
				lender: "required",
			},
			messages: {
				mr: {
					required: "Medrec harus di isi",
					minlength: "Masukkan minimal 6 digit angka",
					maxlength: "Masukkan maksimal 7 digit angka",
					digits: "Hanya angka di perbolehkan",
				},
				borrower: {
					required: "Peminjam harus di isi",
				},
				dept: {
					required: "Departemen harus di isi",
				},
				necessity: {
					required: "Keperluan harus di isi",
				},
				lender: {
					required: "Pemberi pinjam harus di isi",
				},
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

						pageInit();
					},
					error: function (data) {
						//alert(JSON.stringify(data));
						alert("Data tidak ditemukan");
						pageInit();
					},
				});
				return false; // blocks regular submit since you have ajax
			},
		});

		$("#saveMr_borrow").click(function () {
			var medrec = $("#mr").val();
			var nokar_peminjam = $("#inputBorrower").attr("nokar");
			var keperluan = $("#inputNecsty").val();
			var dept_peminjam = $("#inputDept").val();

			var created_by = $("#inputLender").attr("nokar");
			var diserahkan_oleh = $("#inputLender").val();
			var tgl_janji_kembali = $("#inputReturnDate").val();

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
				},
				success: function (data) {
					// alert(JSON.stringify(data));
					$(".next").click();

					$("#mr").val("");
					$("#inputName").val("");
					$("#inputBirthPlace").val("");
					$("#inputReturnDate").val("");
					$("#textAddress").val("");
					$("#formBrwMr .next").prop("disabled", true);

					$("#inputBorrower").val("");
					$("#inputNecsty").val("");
					$("#inputDept").val("");
					
					pageInit();
				},
				error: function (data) {
					// alert(JSON.stringify(data));
					pageInit();
				},
			});
		});

		$("#backBrwBtn").on("click", function (e) {
			e.preventDefault();
			location.reload();
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
				$("#inputBorrower").attr("nokar", ui.item.id);
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
			if ($(this).hasClass("save")) {
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
		} else if (segments[6] !== "" && segments[6] == "report-mr-brw") {
<<<<<<< HEAD
=======
			// var date = new Date();
			// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
>>>>>>> 32ff8c516a868b23cc378ebc8163b4fce0a629cd
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
			if ($(this).html() == "Pause") {
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

	// -- medrec/mr-return
	$("#pinjamMrReturn").on("click", ".tb-row", function () {
		$(this).addClass("selected").siblings().removeClass("selected");

		var trans_pinjam_mr = $(this).attr("trans_id");
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Medrec_func/getPinjamMR",
			data: {
				trans_pinjam_mr: trans_pinjam_mr,
			},
			success: function (data) {
				// alert(JSON.stringify(data));
				$("#inputDataMr").val(data.mr);
				$("#inputDataPatient").val(data.pasien);
				$("#inputDataBirthPlace").val(data.tempat_lahir);
				$("#inputDataBirthDate").val(data.tgl_lahir);
				$("#inputDataAddress").val(data.alamat);
				$("#inputDataTelp").val(data.no_hp);
				$("#inputDataBorrower").val(data.peminjam);
				$("#inputDataLender").val(data.pemberi_pinjam);
				$("#inputDataNecst").val(data.keperluan);
				$("#inputDataRtrnDate").val(data.tgl_janji_kembali);
				// pageInit();
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				// pageInit();
			},
		});
	});

	$("#pinjamMrReturn").on("click", ".edit", function () {
		var trans_pinjam = $(this).parent().parent().attr("trans_id");
		var title = "Pengembalian Medrec";
		var body =
			"<div class='form-group row mb-2' id='divReturnBy'>" +
			"<label class='col-sm-4 col-form-label-sm pr-0 mb-2' for='returnBy'>Nama Pengembali :</label>" +
			"<div class='col-sm-8 pl-0'>" +
			"<input type='text' class='form-control-sm w-100 border-top-0 border-right-0 border-left-0 upper-text' id='inputReturnBy' placeholder='dikembalikan oleh' name='returnBy'>" +
			"</div>";
		+"</div>";
		var btn =
			"<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>" +
			"<button id='saveMr_return' class='btn btn-primary' type='button'>Simpan</button>";
		// $('#myDynamicModal').modal({
		// 	backdrop: false
		// })
		$("#myDynamicModal .modal-title").html(title);
		$("#myDynamicModal .modal-body").html(body);
		$("#myDynamicModal .modal-footer").html(btn);

		$("#myDynamicModal").find("#saveMr_return").attr("trans_id", trans_pinjam);
		$("#myDynamicModal .modal-dialog").addClass("modal-dialog-centered");
		$("#myDynamicModal").modal("show");
		saveReturnMR();

		// $(this).parent().parent().parent().find(".btn").attr("disabled", true)
		// $(this).parent().find(".cancel").attr("disabled", false)
		// $(this).parent().find(".cancel").removeClass("d-none");
		// $(this).addClass("d-none");
		// alert(trans_pinjam);
		// $("#divReturnBy").find(".save").attr("trans_id",trans_pinjam);
		// $("#divReturnBy").toggleClass("d-none");
	});

	$("#pinjamMrReturn").on("click", ".cancel", function () {
		var trans_pinjam = $(this).parent().parent().attr("trans_id");
		$(this).parent().parent().parent().find(".btn").attr("disabled", false);
		$(this).parent().find(".edit").removeClass("d-none");
		$(this).addClass("d-none");
		// alert(trans_pinjam);
		$("#divReturnBy").toggleClass("d-none");
		$("#inputReturnBy").val("");
	});

	$("#pinjamMrReturn").on("click", ".delete", function () {
		var trans_pinjam = $(this).parent().parent().attr("trans_id");
		var title = "Pengembalian Medrec";
		var body = "Apakah anda yakin ingin menghapus data ini?";
		var btn =
			"<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>" +
			"<button id='deleteMr_return' class='btn btn-danger' type='button'>Hapus</button>";

		$("#myDynamicModal .modal-title").html(title);
		$("#myDynamicModal .modal-body").html(body);
		$("#myDynamicModal .modal-footer").html(btn);

		$("#myDynamicModal")
			.find("#deleteMr_return")
			.attr("trans_id", trans_pinjam);
		$("#myDynamicModal .modal-dialog").addClass("modal-dialog-centered");
		$("#myDynamicModal").modal("show");
		deleteReturnMR();
	});

	$("#formReturnBy").validate({
		focusInvalid: false,
		rules: {
			returnBy: "required",
		},
		messages: {
			returnBy: {
				required: "Nama pengembali harus di isi",
			},
		},
		submitHandler: function (form) {
			$("#myDynamicModal").modal("show");
		},
	});

	function saveReturnMR() {
		$("#myDynamicModal").on("shown.bs.modal", function (event) {
			$("#inputReturnBy").autocomplete({
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
					$("#inputReturnBy").val(ui.item.label); // display the selected text
					$("#inputReturnBy").attr("returnBy", ui.item.nokar);
					return false;
				},
			});

			$("#saveMr_return").on("click", function () {
				var trans_pinjam = $(this).attr("trans_id");
				var returnBy = $("#inputReturnBy").attr("returnBy");
				var loading =
					"<div style='text-align:center;'><img src='../../assets/img/gif/loader.gif' height='100px' /></div>";
				var succeed =
					"<div class='success-checkmark'>" +
					"<div class='check-icon'>" +
					"<span class='icon-line line-tip'></span>" +
					"<span class='icon-line line-long'></span>" +
					"<div class='icon-circle'></div>" +
					"<div class='icon-fix'></div>" +
					"</div>" +
					"</div>" +
					"<div class='row justify-content-center'>" +
					"<div class='col-7 text-center'>" +
					"Data telah tersimpan" +
					"</div>" +
					"</div>";
				var btn =
					"<button id='deleteMr_return' class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

				var page_start = 1;
				var per_page = $("#select_pageSize_mr_return option:selected").val();
				var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
				var showitem = 1;
				var status = "not return";
				var from_date = "";
				var to_date = "";

				$("#myDynamicModal .modal-body").html(loading);

				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Medrec_func/updateReturnMR",
					data: {
						trans_pinjam: trans_pinjam,
						returnBy: returnBy,
					},
					success: function (data) {
						// alert(JSON.stringify(data));
						$("#myDynamicModal .modal-footer").html(btn);
						$("#myDynamicModal .modal-body").html(succeed);
						$("#formReturnBy").find(".btn").attr("disabled", true);
						loadPinjamMR(
							page_start,
							per_page,
							func_url,
							showitem,
							status,
							from_date,
							to_date
						);
						// pageInit();
					},
					error: function (data) {
						// alert(JSON.stringify(data));
						// pageInit();
					},
				});
			});
		});
	}

	function deleteReturnMR() {
		$("#myDynamicModal").on("shown.bs.modal", function (event) {
			$("#deleteMr_return").on("click", function () {
				var trans_pinjam = $(this).attr("trans_id");

				var loading =
					"<div style='text-align:center;'><img src='../../assets/img/gif/loader.gif' height='100px' /></div>";
				var deleted =
					"<div class='remove-checkmark'>" +
					"<div class='check-icon'>" +
					"<span class='icon-line line-tip'></span>" +
					"<span class='icon-line line-long'></span>" +
					"<div class='icon-circle'></div>" +
					"<div class='icon-fix'></div>" +
					"</div>" +
					"</div>" +
					"<div class='row justify-content-center'>" +
					"<div class='col-7 text-center'>" +
					"Data telah dihapus" +
					"</div>" +
					"</div>";
				var btn =
					"<button id='deleteMr_return' class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

				var page_start = 1;
				var per_page = $("#select_pageSize_mr_return option:selected").val();
				var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
				var showitem = 1;
				var status = "not return";
				var from_date = "";
				var to_date = "";
				$("#myDynamicModal .modal-body").html(loading);

				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Medrec_func/deleteReturnMR",
					data: {
						trans_pinjam: trans_pinjam,
					},
					success: function (data) {
						// alert(JSON.stringify(data));
						$("#myDynamicModal .modal-footer").html(btn);
						$("#myDynamicModal .modal-body").html(deleted);
						$("#formReturnBy").find(".btn").attr("disabled", true);
						loadPinjamMR(
							page_start,
							per_page,
							func_url,
							showitem,
							status,
							from_date,
							to_date
						);
						// pageInit();
					},
					error: function (data) {
						// alert(JSON.stringify(data));
						// pageInit();
					},
				});
			});
		});
	}

	//--  medrec/report-mr-brw

	$("#filterReportPinjamMr").on("click", ".submit", function () {
		// $("#fromDateRpt_picker").datetimepicker({
		// 	date: today,
		// 	format: "DD.MM.yyyy",
		// });
		// alert(1);
		var page_start = 1;
		var per_page = "";
		var showitem = 1;
		var status = "all";
		var from_date = $("#inputFromDateRpt").val();
		var to_date = $("#inputToDateRpt").val();
		var tb = "";

		// console.log(page_start, per_page, showitem, status, from_date, to_date);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Medrec_func/loadPinjamMR",
			data: {
				page_start: page_start,
				per_page: per_page,
				showitem: showitem,
				status: status,
				from_date: from_date,
				to_date: to_date,
			},
			success: function (data) {
				// alert(JSON.stringify(data));

				var rcount = data.response.length;
				if (rcount > 0) {
					for (var i = 0; i < rcount; i++) {
						var oddEven = "";
						if (i % 2 == 0) {
							oddEven = "even";
						} else {
							oddEven = "odd";
						}
						tb +=
							'<div class="row tb-row border-bottom ' +
							oddEven +
							' enabled" trans_id="' +
							data.response[i].trans_pinjam +
							'">';
						tb +=
							'<div class="col-md-1 tb-cell p-rem-50">' +
							data.response[i].no +
							"</div>";
						tb +=
							'<div class="col-md-1 tb-cell p-rem-50">' +
							data.response[i].medrec +
							"</div>";
						tb +=
							'<div class="col-md-3 tb-cell p-rem-50">' +
							data.response[i].pasien +
							"</div>";
						tb +=
							'<div class="col-md-3 tb-cell p-rem-50">' +
							data.response[i].peminjam +
							"</div>";
						tb +=
							'<div class="col-md-2 tb-cell p-rem-50">' +
							data.response[i].tgl_pinjam +
							"</div>";
						tb +=
							'<div class="col-md-2 tb-cell p-rem-50">' +
							data.response[i].tgl_janji_kembali +
							"</div>";

						tb += "</div>";
					}
				} else {
					tb += '<div class="row">';
					tb +=
						'<div class="col-md-12 bg-danger-2 text-center">TIDAK ADA DATA DITEMUKAN</div>';
					tb += "</div>";
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

				$("#tbReportPinjamMr .tb-body").html("");
				$("#tbReportPinjamMr .tb-body").html(tb);

				$("#dataTable_info").html("");
				$("#dataTable_info").html(
					"Tampilkan" +
						num1 +
						" " +
						"ke" +
						" " +
						num2 +
						" " +
						"dari" +
						" " +
						total +
						" baris"
				);

				$("#pages_polimon").html("");
				$("#pages_polimon").html(data.pagination);
				$("#tbReportPinjamMr").attr("data", "true");
				// pageInit();
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				if (data.response === null || data.response === undefined) {
					tb += '<div class="row">';
					tb +=
						'<div class="col-md-12 bg-danger-2 text-center">TIDAK ADA DATA DITEMUKAN</div>';
					tb += "</div>";
					tb += "</div>";

					$("#tbReportPinjamMr .tb-body").html("");
					$("#tbReportPinjamMr .tb-body").html(tb);
					$("#tbReportPinjamMr").attr("data", "false");

					$("#dataTable_info").html("");
					$("#dataTable_info").html("Showing 0 to 0 of 0");
				}
			},
		});
	});

	$("#filterReportPinjamMr").on("click", ".excel", function () {
		// alert(1);
		if ($("#tbReportPinjamMr").attr("data") == "true") {
			var page_start = 1;
			var per_page = "";
			var showitem = 1;
			var status = "all";
			var from_date = $("#inputFromDateRpt").val();
			var to_date = $("#inputToDateRpt").val();
			// console.log(page_start, per_page, showitem, status, from_date, to_date);

			$.ajax({
				type: "POST",
				dataType: "json",
				url: base_url + "functions/Medrec_func/createExcelPinjamMR",
				data: {
					page_start: page_start,
					per_page: per_page,
					showitem: showitem,
					status: status,
					from_date: from_date,
					to_date: to_date,
				},
				success: function (data) {
					// alert(JSON.stringify(data));
					// console.log(JSON.stringify(data.url));
					window.location.href = data.url;
					// pageInit();
				},
				error: function (data) {
					// alert(JSON.stringify(data));
					console.log(JSON.stringify(data));
				},
			});
		} else {
			var title = "Peringatan";
			var error =
				"<div class='remove-checkmark'>" +
				"<div class='check-icon'>" +
				"<span class='icon-line line-tip'></span>" +
				"<span class='icon-line line-long'></span>" +
				"<div class='icon-circle'></div>" +
				"<div class='icon-fix'></div>" +
				"</div>" +
				"</div>" +
				"<div class='row justify-content-center'>" +
				"<div class='col-7 text-center'>" +
				"Data belum ditampilkan" +
				"</div>" +
				"</div>";
			var btn =
				"<button id='deleteMr_return' class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

			$("#myDynamicModal .modal-footer").html(btn);
			$("#myDynamicModal .modal-body").html(error);
			$("#myDynamicModal .modal-title").html(title);
			$("#myDynamicModal").modal("show");
		}
	});

	function loadPinjamMR(
		page_start,
		per_page,
		func_url,
		showitem,
		status,
		from_date,
		to_date
	) {
		var tb = "";
		// console.log(page_start, per_page, func_url);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: func_url,
			data: {
				page_start: page_start,
				per_page: per_page,
				showitem: showitem,
				status: status,
				from_date: from_date,
				to_date: to_date,
			},
			success: function (data) {
				// alert(JSON.stringify(data));
				var rcount = data.response.length;

				for (var i = 0; i < rcount; i++) {
					var oddEven = "";
					if (i % 2 == 0) {
						oddEven = "even";
					} else {
						oddEven = "odd";
					}
					tb +=
						'<div class="row tb-row border-bottom ' +
						oddEven +
						' enabled" trans_id="' +
						data.response[i].trans_pinjam +
						'">';
					tb +=
						'<div class="col-md-1 tb-cell p-rem-50">' +
						data.response[i].no +
						"</div>";
					tb +=
						'<div class="col-md-2 tb-cell p-rem-50">' +
						data.response[i].medrec +
						"</div>";
					tb +=
						'<div class="col-md-4 tb-cell p-rem-50">' +
						data.response[i].pasien +
						"</div>";
					tb +=
						'<div class="col-md-2 tb-cell p-rem-50">' +
						data.response[i].tgl_janji_kembali +
						"</div>";
					tb +=
						'<div class="col-md-3 tb-cell p-rem-50 text-center">' +
						'<button class="btn bg-primary btn-sm mx-1 text-white edit"></button>' +
						'<button class="btn btn-danger btn-sm mx-1 text-white delete"></button>' +
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

				$("#pinjamMrReturn .tb-body").html("");
				$("#pinjamMrReturn .tb-body").html(tb);

				$("#dataTable_info").html("");
				$("#dataTable_info").html(
					"Tampilkan" +
						num1 +
						" " +
						"ke" +
						" " +
						num2 +
						" " +
						"dari" +
						" " +
						total +
						" baris"
				);

				$("#pages_polimon").html("");
				$("#pages_polimon").html(data.pagination);

				// pageInit();
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				if (data.response === null || data.response === undefined) {
					tb += '<div class="row">';
					tb +=
						'<div class="col-md-12 bg-danger-2 text-center">NO DATA FOUND</div>';
					tb += "</div>";
					tb += "</div>";

					$("#pinjamMrReturn .tb-body").html("");
					$("#pinjamMrReturn .tb-body").html(tb);

					$("#dataTable_info").html("");
					$("#dataTable_info").html("Showing 0 to 0 of 0");
				}
				// pageInit();
			},
		});
	}
})(jQuery); // End of use strict
