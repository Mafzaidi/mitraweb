(function ($) {
	"use strict"; // Start of use strict
	// Dropzone.autoDiscover = false;
	var _URL = window.URL || window.webkitURL;
	var base_url = $("#baseUrl").val();
	var current_url = $(location).attr("href");
	var segments = current_url.split("/");
	var sixth_segment = segments[6];

	var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	
	var obj_berkas = {};
	var list_obj_berkas = [];
	var list_obj_berkas_temp = [];

	// When the user scrolls the page, execute myFunction
	window.onscroll = function () {
		navbarScrollFunction();
	};
	$("body").tooltip({ selector: '[data-toggle="tooltip"]' });

	// Get the navbar
	var navbar = document.getElementById("navbar");

	// Get the offset position of the navbar
	var sticky = navbar.offsetTop;

	// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
	function navbarScrollFunction() {
		if (window.pageYOffset > sticky) {
			navbar.classList.add("navbar-sticky-top");
		} else {
			navbar.classList.remove("navbar-sticky-top");
		}
	}

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

	$("#borrowDate_picker").datetimepicker({
		date: today,
		format: "DD.MM.yyyy",
	});

	$("#returnDate_picker").datetimepicker({
		date: today,
		format: "DD.MM.yyyy",
	});

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

	$("#sidebarToggle").on("click", function () {
		$("#content-wrapper").toggleClass("sidebar-hidden");
		$("#navbarMenu").toggleClass("fixed-hidden");
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

	function loaderFunction() {
		setTimeout(() => {
			$(".loader-modal").removeClass("show");
		}, 2000);
	}

	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	function enableRemoveBtn(input) {
		var btnRemove =
			'<button type="button" class="btn bg-transparent input-remove-btn">';
		btnRemove += '<i class="fa fa-times"></i>';
		btnRemove += "</button>";

		if (input.nextAll().length === 0) {
			input.after(btnRemove);

			$(".input-group .input-remove-btn").on("click", function (e) {
				e.preventDefault();
				$(this).remove();
				input.val("");
				input.focus();
			});
		}
	}

	function disableRemoveBtn(input) {
		if (input.nextAll().length > 0) {
			input.nextAll().remove();
		}
	}

	function activateRemoveBtn(input) {
		/*
		 * If any field is edited,then only it will enable Save button
		 */
		input.keypress(function (e) {
			// text written
			if (input.val().trim() == "") {
				disableRemoveBtn(input);
			} else {
				enableRemoveBtn(input);
			}
		});

		input.keyup(function (e) {
			if (e.keyCode == 8 || e.keyCode == 46) {
				//backspace and delete key
				if (input.val().trim() == "") {
					disableRemoveBtn(input);
				} else {
					enableRemoveBtn(input);
				}
			} else {
				// rest ignore
				if (input.val().trim() == "") {
					disableRemoveBtn(input);
				} else {
					enableRemoveBtn(input);
				}
			}
		});

		input.change(function (e) {
			// select element changed
			if (input.val().trim() == "") {
				disableRemoveBtn(input);
			} else {
				enableRemoveBtn(input);
			}
		});

		input.bind("paste", function (e) {
			// password pasted
			if (input.val().trim() == "") {
				disableRemoveBtn(input);
			} else {
				enableRemoveBtn(input);
			}
		});
	}
	// ***************************************************************************************************
	$(document).ready(function () {
		// for handle multiple modals overlay
		$(".modal").on("hidden.bs.modal", function (event) {
			$(this).removeClass("fv-modal-stack");
			$("body").data("fv_open_modals", $("body").data("fv_open_modals") - 1);
		});

		$(".modal").on("shown.bs.modal", function (event) {
			// keep track of the number of open modals
			if (typeof $("body").data("fv_open_modals") == "undefined") {
				$("body").data("fv_open_modals", 0);
			}

			// if the z-index of this modal has been set, ignore.
			if ($(this).hasClass("fv-modal-stack")) {
				return;
			}

			$(this).addClass("fv-modal-stack");
			$("body").data("fv_open_modals", $("body").data("fv_open_modals") + 1);
			$(this).css("z-index", 1040 + 10 * $("body").data("fv_open_modals"));
			$(".modal-backdrop")
				.not(".fv-modal-stack")
				.css("z-index", 1039 + 10 * $("body").data("fv_open_modals"));
			$(".modal-backdrop").not("fv-modal-stack").addClass("fv-modal-stack");
		});

		// Dropzone.autoDiscover = false;
		if (segments[6] !== "" && segments[6] == "poli-monitor") {
		} else if (segments[6] !== "" && segments[6] == "report-mr-brw") {
			// var date = new Date();
			// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		} else if (segments[6] !== "" && segments[6] == "mr-return") {
			var inputSearch = $("#page_mrReturn").find("#inputTxtSearchMrReturn");
			// console.log(inputSearch.nextAll().length);
			activateRemoveBtn(inputSearch);
			initMrReturn();
		} else if (
			segments[6].replace(window.location.hash, "") !== "" &&
			segments[6].replace(window.location.hash, "") == "inpatient-file"
		) {
			page_inpatientFile_click();
			var inputSearch = $("#page_inpatientFile").find(
				"#inputTxtSearchInpatient"
			);
			// console.log(inputSearch.nextAll().length);
			activateRemoveBtn(inputSearch);
			if (window.location.hash) {
				var regid = window.location.hash.slice(1);
				loaderFunction();
				loadDetailInpatientFile(regid);
			} else {
				$(".loader-modal").removeClass("show");
			}
		} else {
		}

		var inputMr = $("#formBrwMr").find("#mr");
		activateRemoveBtn(inputMr);

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
					url: base_url + "functions/Form_app_func/checkPinjamMR",
					data: {
						mr: mr,
					},
					success: function (data) {
						// alert(JSON.stringify(data.check));
						if (data.check <= 0) {
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
									$("#formBrwMr .next").prop("disabled", false);

									pageInit();
								},
								error: function (data) {
									//alert(JSON.stringify(data));
									alert("Data tidak ditemukan");
									pageInit();
								},
							});
						} else {
							// alert("Medrec ini belum dikembalikan");
							var title = "Informasi";
							var body =
								"Medrec ini tidak bisa dipinjam karena masih dalam masa peminjaman!";
							var btn =
								"<button class='btn btn-secondary' type='button' data-dismiss='modal'>Oke</button>";

							$("#myDynamicModal .modal-title").html(title);
							$("#myDynamicModal .modal-body").html(body);
							$("#myDynamicModal .modal-footer").html(btn);
							$("#myDynamicModal").modal("show");
						}

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
			var tgl_peminjaman = $("#inputBorrowDate").val();
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
					tgl_peminjaman: tgl_peminjaman,
					tgl_janji_kembali: tgl_janji_kembali,
				},
				success: function (data) {
					// alert(JSON.stringify(data));
					if (data.err !== "" && data.err  !== undefined) {
						if (data.err == "001") {
							// location.reload();
							window.location.href = base_url + "auth";;
						}
					} else {
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
					}
				},
				error: function (data) {
					alert(JSON.stringify(data));
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
			// var date = new Date();
			// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
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

	$("#select_pageSize_mr_return").on("change", function (e) {
		e.preventDefault();
		var pageno = 1;
		var page_start = 1;
		var per_page = $("#select_pageSize_mr_return option:selected").val();
		var pageselect = $("#select_pageSize_mr_return option:selected").val();
		var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
		var showitem = 1;
		var status = "";
		var from_date = "";
		var to_date = "";
		var keyword = "";
		var trans_id = "";
		var status_return = "";
		var status_notreturn = "";
		// console.log(pageno, pageselect);

		if (pageselect !== "" && pageselect !== undefined) {
			if (pageno !== "" && pageno !== undefined) {
				page_start = (pageno - 1) * pageselect + 1;
				func_url = base_url + "functions/Medrec_func/loadPinjamMR/" + pageno;
			} else {
				pageno = 0;
				page_start = 1;
			}
		} else {
			per_page = "";
		}

		if (
			$(
				"#page_mrReturn .dropdown input[type='checkbox'][name='checkfilter']:checked"
			).length
		) {
			status_return = "";
			status_notreturn = "";
			$.each(
				$(
					"#page_mrReturn .dropdown input:checkbox[name='checkfilter']:checked"
				),
				function (i) {
					if ($(this).attr("id") == "notReturnCheck") {
						status_notreturn = $(this).val();
					} else if ($(this).attr("id") == "returnCheck") {
						status_return = $(this).val();
					} 
				}
			);
		} else {
			status_return = "";
			status_notreturn = "";
		}

		loadPinjamMR(
			page_start,
			per_page,
			func_url,
			showitem,
			status,
			from_date,
			to_date,
			keyword,
			trans_id,
			status_notreturn,
			status_return
		);
		console.log(
			page_start,
			per_page,
			func_url,
			showitem,
			status,
			from_date,
			to_date,
			keyword,
			trans_id
		);
	});

	function initMrReturn() {
		$("#mrReturn-pagination").on("click", "a", function (e) {
			e.preventDefault();
			var pageno = $(this).attr("data-ci-pagination-page");
			var page_start = 1;
			var per_page = $("#select_pageSize_mr_return option:selected").val();
			var pageselect = $("#select_pageSize_mr_return option:selected").val();
			var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
			var showitem = 1;
			var status = "not return";
			var from_date = "";
			var to_date = "";
			var keyword = "";
			var trans_id = "";
			var status_return = "";
			var status_notreturn = "";

			if (pageselect !== "" && pageselect !== undefined) {
				if (pageno !== "" && pageno !== undefined) {
					page_start = (pageno - 1) * pageselect + 1;
					func_url = base_url + "functions/Medrec_func/loadPinjamMR/" + pageno;
				} else {
					pageno = 0;
					page_start = 1;
				}
			} else {
				per_page = "";
			}

			if (
				$(
					"#page_mrReturn .dropdown input[type='checkbox'][name='checkfilter']:checked"
				).length
			) {
				status_return = "";
				status_notreturn = "";
				$.each(
					$(
						"#page_mrReturn .dropdown input:checkbox[name='checkfilter']:checked"
					),
					function (i) {
						if ($(this).attr("id") == "notReturnCheck") {
							status_notreturn = $(this).val();
						} else if ($(this).attr("id") == "returnCheck") {
							status_return = $(this).val();
						} 
					}
				);
			} else {
				status_return = "";
				status_notreturn = "";
			}

			loadPinjamMR(
				page_start,
				per_page,
				func_url,
				showitem,
				status,
				from_date,
				to_date,
				keyword,
				trans_id,
				status_notreturn,
				status_return
			);

			console.log(
				page_start,
				per_page,
				func_url,
				showitem,
				status,
				from_date,
				to_date,
				keyword,
				trans_id,
				status_return,
				status_notreturn
			);
		});
	}

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
				$("#inputDataBrwDate").val(data.tgl_pinjam);
				$("#inputDataRtrnDate").val(data.tgl_janji_kembali);
				$("#formReturnBy").find(".btn-update").prop("disabled", false);
				$("#formReturnBy").on("click", ".btn-update", function () {
					console.log(121);
				});
				// pageInit();
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				// pageInit();
			},
		});
	});

	$("#pinjamMrReturn").on("click", ".btn-return", function () {
		var trans_pinjam = $(this).parent().parent().attr("trans_id");
		var title = "Pengembalian Medrec";
		var body =
			"<div class='form-group row mb-2' id='divReturnBy'>" +
			"<label class='col-sm-4 col-form-label-sm pr-0 mb-2' for='returnBy'>Nama Pengembali :</label>" +
			"<div class='col-sm-8 pl-0'>" +
			"<input type='text' class='form-control-sm w-100 border-top-0 border-right-0 border-left-0 upper-text' id='inputReturnBy' placeholder='dikembalikan oleh' name='returnBy'>" +
			"</div>" +
			"</div>" +
			"<div class='form-group row mb-2' id='divCatatan'>" +
			"<label class='col-sm-4 col-form-label-sm pr-0 mb-2' for='returnDesc'>Keterangan :</label>" +
			"<div class='col-sm-8 pl-0'>" +
			"<input type='text' class='form-control-sm w-100 border-top-0 border-right-0 border-left-0 upper-text' id='inputReturnDesc' placeholder='keterangan' name='returnDesc'>" +
			"</div>" +
			"</div>" +

			"<div class='form-group row mb-2' id='divReturnDate'>" +
			"<label class='col-sm-4 col-form-label-sm pr-0 mb-2' for='inputRealReturnDate'>Tanggal Kembali :</label>" +
			"<div class='col-sm-8 pl-0'>" +
			'<div class="input-group date" id="realReturnDate_picker" data-target-input="nearest">' +
			'<input type="text" class="form-control datetimepicker-input date-validate" data-target="#realReturnDate_picker" id="inputRealReturnDate" placeholder="DD.MM.YYYY" maxlength="10"/>' +
			'<div class="input-group-append" data-target="#realReturnDate_picker" data-toggle="datetimepicker">' +
			'<div class="input-group-text"><i class="fa fa-calendar"></i></div>' +
			'</div>' +
			"</div>" +
			"</div>" +
			"</div>";
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

	$("#pinjamMrReturn").on("click", ".btn-delete", function () {
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

	$("#pinjamMrReturn").on("click", ".btn-update", function () {
		
		$("#myDynamicModal .modal-dialog").addClass("modal-lg");
		var trans_pinjam_mr = $(this).parent().parent().attr("trans_id")
		var title = "Data Peminjaman";
		var body =
			'<form>' +
			'<div class="form-group row">' +
			'<label for="inputPeminjam" class="col-sm-4 col-form-label">Peminjam</label>' +
			'<div class="col-sm-8">' +
				'<input type="text" class="form-control" id="inputPeminjam">' +
			'</div>' +
			'</div>' +
			'<div class="form-group row">' +
			'<label for="inputTglPinjam" class="col-sm-4 col-form-label">Tanggal Pinjam</label>' +
				'<div class="col-sm-8">' +
					'<div class="input-group date" id="tglPinjamDate_picker" data-target-input="nearest">' +
						'<input type="text" class="form-control datetimepicker-input date-validate" data-target="#tglPinjamDate_picker" id="inputTglPinjam" placeholder="DD.MM.YYYY" maxlength="10"/>' +
						'<div class="input-group-append" data-target="#tglPinjamDate_picker" data-toggle="datetimepicker">' +
							'<div class="input-group-text"><i class="fa fa-calendar"></i></div>' +
						'</div>' +
					"</div>" +
				'</div>' +
			'</div>' +
			'<div class="form-group row">' +
			'<label for="inputKeperluan" class="col-sm-4 col-form-label">Keperluan</label>' +
			'<div class="col-sm-8">' +
				'<input type="text" class="form-control" id="inputKeperluan">' +
			'</div>' +
			'</div>' +
			'<div class="form-group row">' +
			'<label for="inputTglPinjam" class="col-sm-4 col-form-label">Tanggal Kembali</label>' +
				'<div class="col-sm-8">' +
					'<div class="input-group date" id="tglKembaliDate_picker" data-target-input="nearest">' +
						'<input type="text" class="form-control datetimepicker-input date-validate" data-target="#tglKembaliDate_picker" id="inputTglKembali" placeholder="DD.MM.YYYY" maxlength="10"/>' +
						'<div class="input-group-append" data-target="#tglKembaliDate_picker" data-toggle="datetimepicker">' +
							'<div class="input-group-text"><i class="fa fa-calendar"></i></div>' +
						'</div>' +
					"</div>" +
				'</div>' +
			'</div>' +
		'</form>';
		var btn =
			"<button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>" +
			"<button id='btn-save-update' class='btn btn-primary' type='button'>Simpan</button>";
		// $('#myDynamicModal').modal({
		// 	backdrop: false
		// })
		$("#myDynamicModal .modal-title").html(title);
		$("#myDynamicModal .modal-body").html(body);
		$("#myDynamicModal .modal-footer").html(btn);
		$("#myDynamicModal .modal-dialog").addClass("modal-dialog-centered");

		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Medrec_func/getPinjamMR",
			data: {
				trans_pinjam_mr: trans_pinjam_mr,
			},
			success: function (data) {		
				var old_peminjam = data.peminjam;
				var old_nik_peminjam = data.nik_peminjam;
				var old_tgl_pinjam = data.tgl_pinjam;
				var old_keperluan = data.keperluan;
				var old_tgl_kembali = data.tgl_kembali;

				$("#tglKembaliDate_picker").datetimepicker({
					format: "DD.MM.yyyy",
				});
				$("#tglPinjamDate_picker").datetimepicker({
					format: "DD.MM.yyyy",
				});
				$("#inputPeminjam").val(data.peminjam);
				$("#inputPeminjam").attr("peminjam", old_nik_peminjam);
				$("#inputTglPinjam").val(data.tgl_pinjam);
				$("#inputKeperluan").val(data.keperluan);
				$("#inputTglKembali").val(data.tgl_kembali);
				$("#btn-save-update").attr("trans_id", data.trans_id);
				$("#myDynamicModal").modal("show");

				$("#myDynamicModal").on("shown.bs.modal", function (event) {
					$("#inputPeminjam").autocomplete({
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
							$("#inputPeminjam").val(ui.item.label); // display the selected text
							$("#inputPeminjam").attr("peminjam", ui.item.nokar);
							return false;
						},
					});

					$("#inputPemberi").autocomplete({
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
							$("#inputPemberi").val(ui.item.label); // display the selected text
							$("#inputPemberi").attr("pemberi", ui.item.nokar);
							return false;
						},
					});

					$("#btn-save-update").on("click", function () {
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
						var keyword = "";
						var trans_id = "";
						var status_return = "";
						var status_notreturn = "";

						var new_peminjam = $("#inputPeminjam").val();
						var new_nik_peminjam = $("#inputPeminjam").attr("peminjam");
						var new_tgl_pinjam = $("#inputTglPinjam").val();
						var new_keperluan = $("#inputKeperluan").val();
						var new_tgl_kembali = $("#inputTglKembali").val();
						var trans_id = $(this).attr("trans_id");
						console.log(old_nik_peminjam + '/' + new_nik_peminjam + ', ' + new_tgl_pinjam + ', ' + old_keperluan + '/' + new_keperluan + ', ' + old_tgl_kembali + '/' + new_tgl_kembali);

						if (new_nik_peminjam !== old_nik_peminjam || new_tgl_pinjam !== old_tgl_pinjam || 
							new_keperluan !== old_keperluan || new_tgl_kembali !== old_tgl_kembali){					
							$.ajax({
								type: "POST",
								dataType: "json",
								url: base_url + "functions/Medrec_func/updateSavedReturnMR",
								data: {
									trans_id: trans_id,
									new_nik_peminjam: new_nik_peminjam,
									new_tgl_pinjam: new_tgl_pinjam,
									new_keperluan: new_keperluan,
									new_tgl_kembali: new_tgl_kembali,
								},
								success: function (data) {	
									console.log(JSON.stringify(data));
									// console.log(data.err);
									if (data.err !== "" && data.err  !== undefined) {
										if (data.err == "001") {
											// location.reload();
											window.location.href = base_url + "auth";;
										}
									} else {
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
											to_date,
											keyword,
											trans_id,
											status_notreturn,
											status_return
										);
										// pageInit();
									}
								},
								error: function (data) {
									// alert(JSON.stringify(data));
									// pageInit();
								},
							});
						} 
						else if 
							(new_nik_peminjam == old_nik_peminjam && new_tgl_pinjam == old_tgl_pinjam && 
							new_keperluan == old_keperluan && old_tgl_kembali == old_tgl_kembali) {
								alert("tidak ada perubahan data!");
						}
						else {
							alert("tidak ada perubahan data!");
						}
					});
				});
			},
			error: function (data) {
				// alert(JSON.stringify(data));
				// pageInit();
			},
		});
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
			$("#realReturnDate_picker").datetimepicker({
				format: "DD.MM.yyyy",
			});

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
				var returnDesc = $("#inputReturnDesc").val();
				var realReturnDate = $("#inputRealReturnDate").val();

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
				var keyword = "";
				var trans_id = "";
				var status_return = "";
				var status_notreturn = "not return";

				$("#myDynamicModal .modal-body").html(loading);

				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Medrec_func/updateReturnMR",
					data: {
						trans_pinjam: trans_pinjam,
						returnBy: returnBy,
						returnDesc: returnDesc,
						realReturnDate: realReturnDate,
					},
					success: function (data) {
						console.log(JSON.stringify(data));
						console.log(data.err);
						if (data.err !== "" && data.err  !== undefined) {
							if (data.err == "001") {
								// location.reload();
								window.location.href = base_url + "auth";;
							}
						} else {
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
								to_date,
								keyword,
								trans_id,
								status_notreturn,
								status_return
							);
							// pageInit();
						}
					},
					error: function (data) {
						// console.log(JSON.stringify(data));
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
					"<button class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

				var page_start = 1;
				var per_page = $("#select_pageSize_mr_return option:selected").val();
				var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
				var showitem = 1;
				var status = "not return";
				var from_date = "";
				var to_date = "";
				var keyword = "";
				var trans_id = "";
				var status_return = "";
				var status_notreturn = "not return";
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
							to_date,
							keyword,
							trans_id,
							status_notreturn,
							status_return
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
		var keyword = "";
		var trans_id = "";
		var tb = "";
		var status_return = "";
		var status_notreturn = "";

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
				keyword: keyword,
				trans_id: trans_id,
				status_return: status_return,
				status_notreturn: status_notreturn,
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
							'<div class="col-md-2 tb-cell p-rem-50">' +
							data.response[i].pasien +
							"</div>";
						tb +=
							'<div class="col-md-2 tb-cell p-rem-50">' +
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
						tb +=
							'<div class="col-md-2 tb-cell p-rem-50">' +
							data.response[i].tgl_kembali +
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
				"<button class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

			$("#myDynamicModal .modal-footer").html(btn);
			$("#myDynamicModal .modal-body").html(error);
			$("#myDynamicModal .modal-title").html(title);
			$("#myDynamicModal").modal("show");
		}
	});

	$("#inputTxtSearchMrReturn").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: base_url + "functions/Medrec_func/getAutoMrReturn",
				type: "post",
				dataType: "json",
				data: {
					keyword: request.term,
				},
				success: function (data) {
					response(data);
					//alert(JSON.stringify(data));
				},
			});
		},
		select: function (event, ui) {
			// Set selection
			$(this).val(ui.item.label); // display the selected text
			$(this).attr("trans_id", ui.item.id);

			var pageno = 1;
			var page_start = 1;
			var per_page = $("#select_pageSize_mr_return option:selected").val();
			var pageselect = $("#select_pageSize_mr_return option:selected").val();
			var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
			var showitem = 1;
			var status = "not return";
			var from_date = "";
			var to_date = "";
			var keyword = "";
			var trans_id = ui.item.id;
			var status_return = "";
			var status_notreturn = "";
			// console.log(pageno, pageselect);

			if (pageselect !== "" && pageselect !== undefined) {
				if (pageno !== "" && pageno !== undefined) {
					page_start = (pageno - 1) * pageselect + 1;
					func_url = base_url + "functions/Medrec_func/loadPinjamMR/" + pageno;
				} else {
					pageno = 0;
					page_start = 1;
				}
			} else {
				per_page = "";
			}
			loadPinjamMR(
				page_start,
				per_page,
				func_url,
				showitem,
				status,
				from_date,
				to_date,
				keyword,
				trans_id,
				status_notreturn,
				status_return
			);
			// console.log(ui.item.id);
			return false;
		},
	});

	$("#inputTxtSearchMrReturn").bind("enterKey", function (e) {
		var search = $(this).val();
		if (search == "") {
			var pageno = 1;
			var page_start = 1;
			var per_page = $("#select_pageSize_mr_return option:selected").val();
			var pageselect = $("#select_pageSize_mr_return option:selected").val();
			var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
			var showitem = 1;
			var status = "not return";
			var from_date = "";
			var to_date = "";
			var keyword = "";
			var trans_id = "";
			var status_return = "";
			var status_notreturn = "";
			// console.log(pageno, pageselect);

			if (pageselect !== "" && pageselect !== undefined) {
				if (pageno !== "" && pageno !== undefined) {
					page_start = (pageno - 1) * pageselect + 1;
					func_url = base_url + "functions/Medrec_func/loadPinjamMR/" + pageno;
				} else {
					pageno = 0;
					page_start = 1;
				}
			} else {
				per_page = "";
			}
			
			loadPinjamMR(
				page_start,
				per_page,
				func_url,
				showitem,
				status,
				from_date,
				to_date,
				keyword,
				trans_id,
				status_notreturn,
				status_return
			);
		}
	});

	$("#submitFilterMrReturn").on("click", function () {
		var pageno = 1;
		var page_start = 1;
		var per_page = $("#select_pageSize_mr_return option:selected").val();
		var pageselect = $("#select_pageSize_mr_return option:selected").val();
		var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
		var showitem = 1;
		var status = "";
		var from_date = "";
		var to_date = "";
		var keyword = "";
		var trans_id = "";

		var status_notreturn = "";
		var status_return = "";

		if (
			$(
				"#page_mrReturn .dropdown input[type='checkbox'][name='checkfilter']:checked"
			).length
		) {
			status_return = "";
			status_notreturn = "";
			$.each(
				$(
					"#page_mrReturn .dropdown input:checkbox[name='checkfilter']:checked"
				),
				function (i) {
					if ($(this).attr("id") == "notReturnCheck") {
						status_notreturn = $(this).val();
					} else if ($(this).attr("id") == "returnCheck") {
						status_return = $(this).val();
					} 
				}
			);
		} else {
			status_return = "";
			status_notreturn = "";
		}

		loadPinjamMR(
			page_start,
			per_page,
			func_url,
			showitem,
			status,
			from_date,
			to_date,
			keyword,
			trans_id,
			status_notreturn,
			status_return
		);
		console.log(status_notreturn + ", " + status_return);
	});

	$("#inputTxtSearchMrReturn").keyup(function (e) {
		if (e.keyCode == 13) {
			$(this).trigger("enterKey");
		}
	});

	function loadPinjamMR(
		page_start,
		per_page,
		func_url,
		showitem,
		status,
		from_date,
		to_date,
		keyword,
		trans_id,
		status_notreturn,
		status_return
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
				keyword: keyword,
				trans_id: trans_id,
				status_notreturn: status_notreturn,
				status_return: status_return,
			},
			success: function (data) {
				// alert(JSON.stringify(data));
				// console.log(JSON.stringify(data));
				var rcount = data.response.length;
				var btnReturn = "";
				var btnEdit = "";

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
						'<div class="col-md-1 col-lg-1 tb-cell p-rem-50">' +
						data.response[i].no +
						"</div>";
					tb +=
						'<div class="col-md-4 col-lg-2 tb-cell p-rem-50">' +
						data.response[i].medrec +
						"</div>";
					tb +=
						'<div class="col-md-7 col-lg-5 tb-cell p-rem-50">' +
						data.response[i].pasien +
						"</div>";
					// tb +=
					// 	'<div class="col-md-2 tb-cell p-rem-50">' +
					// 	data.response[i].tgl_janji_kembali +
					// 	"</div>";
					if (data.response[i].tgl_kembali !== "" && data.response[i].tgl_kembali !== undefined && data.response[i].tgl_kembali !== '-') {
						btnReturn = "";
					} else {
						btnReturn = '<button class="btn bg-primary btn-sm mx-1 text-white file-alt btn-return" data-toggle="tooltip" data-placement="bottom" title="Pilih"></button>';
					}
					if (data.response[i].tgl_kembali !== "" && data.response[i].tgl_kembali !== undefined && data.response[i].tgl_kembali !== '-') {
						btnEdit = 
						'<button class="btn bg-success btn-sm mx-1 text-white edit btn-update" data-toggle="tooltip" data-placement="bottom" title="Ubah"></button>';
					} else {
						btnEdit = '';
					}
					tb +=
						'<div class="col-md-12 col-lg-4 tb-cell p-rem-50 text-center">' +
						btnReturn +
						'<button class="btn btn-danger btn-sm mx-1 text-white delete btn-delete" data-toggle="tooltip" data-placement="bottom" title="Hapus"></button>' +
						btnEdit +
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
				initMrReturn();
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

	// Jquery inpatient-file

	function getHashValue(key) {
		var matches = location.hash.match(new RegExp(key + "=([^&]*)"));
		return matches ? matches[1] : null;
	}

	$("#tb_inpatientFile").on(
		"click",
		"#btnEditBerkas:not([disabled])",
		function (e) {
			var regid = $(this).parent().attr("reg-id");
			var hash_url = "#" + regid;
			window.location.hash = hash_url;
			loaderFunction();
			loadDetailInpatientFile(regid);
		}
	);

	$("#detailInpatientFile").on(
		"click",
		"#btnBack:not([disabled])",
		function () {
			$("#detailInpatientFile").toggleClass("d-none");
			$("#rowsInpatientFile").toggleClass("d-none");
			if (window.location.hash) {
				// Fragment exists
				// var hash_value = window.location.hash.slice(1);
				// console.log(hash_value);
				history.replaceState("", document.title, window.location.pathname);
			} else {
				// Fragment doesn't exist
			}
		}
	);

	$("#inputTxtSearchInpatient").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: base_url + "functions/Form_app_func/getAutoInpatientFile",
				type: "post",
				dataType: "json",
				data: {
					keyword: request.term,
				},
				success: function (data) {
					response(data);
					//alert(JSON.stringify(data));
				},
			});
		},
		select: function (event, ui) {
			// Set selection
			$(this).val(ui.item.label); // display the selected text
			$(this).attr("reg_id", ui.item.id);
			var page_start = 1;
			var per_page = "";
			var func_url = base_url + "functions/Form_app_func/loadInpatientFile";
			var key_word = "";
			var reg_id = ui.item.id;
			loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
			// console.log(ui.item.id);
			return false;
		},
	});

	$("#inputTxtSearchInpatient").bind("enterKey", function (e) {
		var search = $(this).val();
		if (search == "") {
			var page_start = 1;
			var per_page = "";
			var func_url = base_url + "functions/Form_app_func/loadInpatientFile";
			var key_word = "";
			var reg_id = "";
			loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
		}
	});

	$("#inputTxtSearchInpatient").keyup(function (e) {
		if (e.keyCode == 13) {
			$(this).trigger("enterKey");
		}
	});

	$("#InpatientFile_selectPageSize").on("change", function (e) {
		e.preventDefault();
		var reg_id = "";
		var key_word = "";
		var pageno = 1;
		var pageselect = $("#InpatientFile_selectPageSize option:selected").val();
		var per_page = $("#InpatientFile_selectPageSize option:selected").val();
		var page_start = 1;
		var func_url = base_url + "functions/Form_app_func/loadInpatientFile";
		// console.log(pageno, pageselect);

		if (pageselect !== "" && pageselect !== undefined) {
			if (pageno !== "" && pageno !== undefined) {
				page_start = (pageno - 1) * pageselect + 1;
				func_url =
					base_url + "functions/Form_app_func/loadInpatientFile/" + pageno;
			} else {
				pageno = 0;
				page_start = 1;
			}
		} else {
			per_page = "";
		}

		loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
		console.log(pageno, pageselect, page_start, per_page, func_url);
	});

	function page_inpatientFile_click() {
		$("#inpatientFile-pagination").on("click", "a", function (e) {
			e.preventDefault();
			var reg_id = "";
			var key_word = "";
			var pageno = $(this).attr("data-ci-pagination-page");
			var pageselect = $("#InpatientFile_selectPageSize option:selected").val();
			var per_page = $("#InpatientFile_selectPageSize option:selected").val();
			var page_start = 1;
			var func_url = "";

			if (pageselect !== "" && pageselect !== undefined) {
				if (pageno !== "" && pageno !== undefined) {
					page_start = (pageno - 1) * pageselect + 1;
					func_url =
						base_url + "functions/Form_app_func/loadInpatientFile/" + pageno;
				} else {
					pageno = 0;
					page_start = 1;
					func_url = base_url + "functions/Form_app_func/loadInpatientFile";
				}
			}

			loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
		});
	}

	function loadInpatientFile(page_start, per_page, func_url, key_word, reg_id) {
		var tb = "";
		// console.log(page_start, per_page, func_url);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: func_url,
			data: {
				page_start: page_start,
				per_page: per_page,
				key_word: key_word,
				reg_id: reg_id,
			},
			success: function (data) {
				// alert(JSON.stringify(data));
				var rcount = data.response.length;

				for (var i = 0; i < rcount; i++) {
					var oddEven = "";
					if (i % 2 == 0) {
						oddEven = "even-row";
					} else {
						oddEven = "odd-row";
					}

					var flag = "";
					if (data.response[i].reg_berkas == "N") {
						flag = "bg-danger-2";
					} else {
						var listRegArr = "";
						var highArr = "";
						var mediumArr = "";
						var lowArr = "";

						if (
							data.response[i].list_reg !== "" &&
							data.response[i].list_reg !== undefined
						) {
							if (data.response[i].list_reg.indexOf(",") > -1) {
								listRegArr = data.response[i].list_reg.split(",");
							} else {
								listRegArr = data.response[i].list_reg;
							}
						}

						if (
							data.response[i].high_priority !== "" &&
							data.response[i].high_priority !== undefined
						) {
							if (data.response[i].high_priority.indexOf(",") > -1) {
								highArr = data.response[i].high_priority.split(",");
							} else {
								highArr = data.response[i].high_priority;
							}
						}

						if (
							data.response[i].medium_priority !== "" &&
							data.response[i].medium_priority !== null &&
							data.response[i].medium_priority !== undefined
						) {
							if (data.response[i].medium_priority.indexOf(",") > -1) {
								mediumArr = data.response[i].medium_priority.split(",");
							} else {
								mediumArr = data.response[i].medium_priority;
							}
						} else {
							mediumArr = "";
							console.log(mediumArr);
						}

						if (
							data.response[i].low_priority !== "" &&
							data.response[i].low_priority !== null &&
							data.response[i].low_priority !== undefined
						) {
							if (data.response[i].low_priority.indexOf(",") > -1) {
								lowArr = data.response[i].low_priority.split(",");
							} else {
								lowArr = data.response[i].low_priority;
							}
						} else {
							lowArr = "";
							console.log(lowArr);
						}
						// var highArr = data.response[i].high_priority.split(',');
						// var mediumArr = data.response[i].medium_priority.split(',');
						// var lowArr = data.response[i].low_priority.split(',');

						console.log(listRegArr);
						console.log(highArr);
						console.log(mediumArr);
						console.log(lowArr);
						for (var r = 0; r < listRegArr.length; r++) {
							if (highArr.indexOf(listRegArr[r]) >= 0) {
								flag = "bg-success-2";
							} else if (mediumArr.indexOf(listRegArr[r]) >= 0) {
								flag = "bg-dizzy";
							} else {
								flag = "bg-danger-2";
							}
						}
					}
					tb +=
						'<div class="row tb-row hover border-hover hover-event border-bottom ' +
						oddEven +
						" " +
						flag +
						'">';

					tb += '<div class="col-sm-12 col-md-9 tb-cell">';

					tb += ' <div class="row">';

					tb += '<div class="col-sm-12 col-md-5 p-0">';

					tb += ' <div class="row">';

					tb += '<div class="w-35-px">' + data.response[i].no + "</div>";
					tb +=
						'<div class="col-sm-12 col-md-10 p-0"><b>' +
						data.response[i].medrec +
						"</b>&nbsp-&nbsp;" +
						data.response[i].pasien +
						"</div>";

					tb += "</div>";

					tb += "</div>";

					tb +=
						'<div class="col-sm-12 col-md-7 p-0 "> Masuk tanggal&nbsp;' +
						data.response[i].tgl_masuk +
						"&nbsp;-&nbsp;Ruang:&nbsp;" +
						data.response[i].ruang_id +
						"&nbsp;-&nbsp;NS:&nbsp;" +
						data.response[i].nama_dept +
						"</div>";

					tb += "</div>";

					tb += "</div>";

					tb += '<div class="col-sm-12 col-md-3 tb-cell p-0">';
					tb += '<div class="row">';
					tb += '<div class="col-sm-12 col-md-4 p-0"></div>';
					var textRekananNama = "";
					if (data.response[i].rekanan_nama.length > 20) {
						textRekananNama =
							data.response[i].rekanan_nama.substring(0, 20) + "...";
					} else {
						textRekananNama = data.response[i].rekanan_nama;
					}
					tb +=
						'<div class="col-sm-12 col-md-8 p-0 font-weight-lighter hover show">' +
						textRekananNama +
						"</div>";

					var is_reg = "";
					var is_edit = "";
					if (data.response[i].reg_berkas !== "") {
						is_reg = "enabled";
						is_edit = "disabled";
					} else {
						is_reg = "disabled";
						is_edit = "enabled";
					}
					tb += '<div class="col-sm-12 col-md-8 p-0 hover circle hide">';
					tb +=
						'<div class="d-flex justify-content-center" reg-id="' +
						data.response[i].reg_id +
						'">';
					tb +=
						'<a class="i-wrapp light" id="btnEditBerkas" data-toggle="tooltip" data-placement="bottom" title="Lihat"><i class="fas fa-file-alt"></i></a>';

					tb += "</div>";
					tb += "</div>";

					tb += "</div>";
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
				// console.log(page_start, per_page, data.count, num1, num2);

				$("#tb_inpatientFile .tb-body").html("");
				$("#tb_inpatientFile .tb-body").html(tb);

				$("#tb_inpatientFile .tb-info").html("");
				$("#tb_inpatientFile .tb-info").html(
					"Tampilkan" +
						data.start_from +
						" " +
						"ke" +
						" " +
						data.end_to +
						" " +
						"dari" +
						" " +
						total +
						" baris"
				);

				// console.log(JSON.stringify(data.per_page));
				$("#tb_inpatientFile .tb-pagination").html("");
				$("#tb_inpatientFile .tb-pagination").html(data.pagination);
				page_inpatientFile_click();
				pageInit();
			},
			error: function (data) {
				console.log(JSON.stringify(data.response));
				if (data.response === null || data.response === undefined) {
					tb += '<div class="row">';
					tb +=
						'<div class="col-md-12 bg-danger-2 text-center">NO DATA FOUND</div>';
					tb += "</div>";
					tb += "</div>";

					$("#tb_inpatientFile .tb-body").html("");
					$("#tb_inpatientFile .tb-body").html(tb);

					$("#tb_inpatientFile .tb-info").html("");
					$("#tb_inpatientFile .tb-info").html("Showing 0 to 0 of 0");
				}
				pageInit();
			},
		});
	}

	function loadDetailInpatientFile(regid) {
		var reg_id = regid;
		var rekanan_id = "";
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Form_app_func/getInpatientFile",
			data: {
				reg_id: regid,
			},
			success: function (data) {
				$("#detailInpatientFile #medrec").html(data.medrec);
				$("#detailInpatientFile #nama").html(data.pasien);
				$("#detailInpatientFile #tgl_lahir").html(data.tgl_lahir);
				$("#detailInpatientFile #umur").html(data.umur);
				$("#detailInpatientFile #tgl_masuk").html(data.tgl_masuk);
				$("#detailInpatientFile #ruang").html(data.ruang_id);
				$("#detailInpatientFile #ns").html(data.nama_dept);
				$("#detailInpatientFile #dokter").html(data.nama_dr);
				$("#detailInpatientFile #rekanan").html(data.rekanan_nama);
				var berkas_html = "";
				var col_class = "";
				var button_html = "";	
				
				var check_toggle = "";	
				var check_registered = "";

				var count_berkas = data.listBerkas.length;
				var array_berkas_template = [];
				rekanan_id = data.rekanan_id;
				reg_id = data.reg_id;

				var uploaded = "";
				var btn_action = "";

				var cls_registered = "";

				for (var i = 0; i < count_berkas; i++) {
					check_registered = "";	
					cls_registered = "";

					if (data.listBerkas[i].registered == "Y") {
						btn_action = 
						// upload
						'<div class="d-flex justify-content-center light" role="button" trans_id="' +
						data.listBerkas[i].trans_id +
						'" reg_id="' +
						data.reg_id +
						'" berkas_id="' +
						data.listBerkas[i].berkas_id +
						'" ket="' + 
						data.listBerkas[i].keterangan + 
						'"><a class="i-wrapp btn_detail_berkas" data-toggle="tooltip" data-placement="bottom" title="Lihat Berkas" ><i class="fas fa-folder-open"></i></a>' +
						"</div>";
						check_registered = '<i class="fas fa-check-circle float-right align-middle" style="line-height: 2rem; color: green;"></i>';
						cls_registered = "registered";
						uploaded = "text-success";
					} else {
						btn_action = 
						// upload
						'<div class="d-flex justify-content-center light" role="button" rekanan_id="' +
						data.rekanan_id +
						'" berkas_id="' +
						data.listBerkas[i].berkas_id +
						'" reg_id="' +
						data.reg_id +
						'" uploaded_default="' +
						data.listBerkas[i].uploaded_default +
						'" uploaded_rekanan="' +
						data.listBerkas[i].uploaded_rekanan +
						'" ket="' + 
						data.listBerkas[i].keterangan + 
						'"><a class="i-wrapp btn_upload_berkas" data-toggle="tooltip" data-placement="bottom" title="Upload Berkas" ><i class="fas fa-upload"></i></a>' +
						"</div>";
						check_registered = "";
						cls_registered = "";
						uploaded = "text-white";
					}
					
					if (data.listBerkas[i].jenis == "02") {
						var download_button = "";
						if (data.listBerkas[i].uploaded == "N") {
							download_button =
								'<div class="d-flex justify-content-center"" rekanan_id="' +
								data.rekanan_id +
								'" berkas_id="' +
								data.listBerkas[i].berkas_id +
								'" reg_id="' +
								data.reg_id +
								'" uploaded_default="' +
								data.listBerkas[i].uploaded_default +
								'" uploaded_rekanan="' +
								data.listBerkas[i].uploaded_rekanan +
								'" desc="' +
								'" ' +
								' disabled><a class="i-wrapp light btn-downnload-template" href="#" role="button" data-toggle="tooltip" data-placement="bottom" title="Download Template"><i class="fas fa-download"></i></a>' +
								"</div>";
						} else {
							
							array_berkas_template.push(data.listBerkas[i].list_template);
							var template_count = data.listBerkas[i].list_template.length;
							var download_dropdown = "";
								for (var j = 0; j < template_count; j++) {
									if (
										data.listBerkas[i].list_template[j].BERKAS_ID ==
										data.listBerkas[i].berkas_id
									) {
										download_dropdown +=
											'<a class="dropdown-item" href="' +
											base_url +
											data.listBerkas[i].list_template[j].URL +
											'" target="_blank" rekid="' +
											data.listBerkas[i].list_template[j].REKANAN_ID +
											'"><small>' +
											data.listBerkas[i].list_template[j].REKANAN_NAMA +
											"</small></a>";
									}
								}
							if (template_count > 1) {
								
								download_button =
									'<div class="dropleft d-flex justify-content-center" data-toggle="tooltip" data-placement="bottom" title="Download Template">' +
									'<a class="btn dropdown-toggle i-wrapp light btn-downnload-template" href="#" role="button"' + 
									'data-toggle="dropdown" aria-expanded="false" style="padding:0; line-height:35px">' +
									'<i class="fas fa-download"></i>' +
									"</a>" +
									'<div class="dropdown-menu">';
									
								download_button += download_dropdown;
								download_button += "</div>" +
									"</div>";
							} else {

								for (var j = 0; j < template_count; j++) {
									if (
										data.listBerkas[i].list_template[j].BERKAS_ID ==
										data.listBerkas[i].berkas_id
									) {
										download_button =
											'<div class="d-flex justify-content-center" rekanan_id="' +
											data.rekanan_id +
											'" berkas_id="' +
											data.listBerkas[i].berkas_id +
											'" reg_id="' +
											data.reg_id +
											'" uploaded_default="' +
											data.listBerkas[i].uploaded_default +
											'" uploaded_rekanan="' +
											data.listBerkas[i].uploaded_rekanan +
											'"><a class="i-wrapp light btn-downnload-template" href="' +  base_url + data.listBerkas[i].list_template[j].URL  + '"' +
											'role="button" " target="_blank" data-toggle="tooltip" data-placement="bottom" title="Download Template"><i class="fas fa-download"></i></a>' +
											"</div>";
									}
								}
							}
							
							// console.log(JSON.stringify(data.listBerkas[i].list_template));	
						}
						col_class = "";	

						button_html =
							// action section
							'<div class="form-inline d-flex justify-content-end hover circle hide">' +
							// download
							download_button +							
							btn_action +
							// '<button type="button" class="btn btn-mark btn-sm mr-2 fs-075rem ml-2" data-toggle="tooltip" data-placement="bottom" title="Upload Template">' +
							// '<i class="fas fa-upload"></i>&nbsp;Upload</button>' +
							"</div>"; // end of div form-inline	
					} else if (data.listBerkas[i].jenis == "03") {
						button_html =
							'<div class="form-inline d-flex justify-content-end hover circle hide">' +
							'<div class="d-flex justify-content-center" rekanan_id="' +
							data.rekanan_id +
							'" berkas_id="' +
							data.listBerkas[i].berkas_id +
							'" reg_id="' +
							data.reg_id +
							'"><a class="i-wrapp light btn-downnload-template" href="#"' +
							'role="button" data-toggle="tooltip" data-placement="bottom" title="Tambah berkas lain"><i class="fas fa-plus"></i></a>' +
							"</div>" +
							"</div>"; // end of div form-inline	
					} else {
						var check_disabled = "";
						col_class = "switch-button";
						if (data.listBerkas[i].registered == "Y") {
							check_toggle = "checked";
							check_disabled = "disabled"
						} else {
							check_toggle = "";
							check_disabled = ""
						}

						button_html =
							'<div class="form-check form-check-inline d-flex justify-content-end py-1">' +
							'<label class="toggle"><input class="btn btn-primary btn-sm toggle-checkbox ' + cls_registered + ' ' + check_disabled + '" type="checkbox" ' +
							check_toggle +
							' berkas_id="' + data.listBerkas[i].berkas_id + '" ' + check_disabled + '><div class="toggle-switch"></div><span class="toggle-label"></span></label>';
					}

					berkas_html += '<div class="row berkas-container" id="berkas_' + data.listBerkas[i].berkas_id + '">';

					berkas_html += '<div class="col-sm-12 col-md-12 col-lg-6">';
					berkas_html +=
						'<label  class="text-muted m-0 fs-085rem berkas-title">' +
						data.listBerkas[i].keterangan +
						"</label>";
					berkas_html += //check_registered + 
					'<i class="fas fa-check-circle float-right ' + uploaded + '" ></i>' +
					"</div>"; // eof div .col-sm-12 label

					berkas_html +=
						'<div class="col-sm-12 col-md-12 col-lg-6 ' + col_class + '">';
					berkas_html += button_html;
					berkas_html += "</div>"; // end of div form-check-inline
					berkas_html += "</div>"; // eof div .col-sm-12 action

					berkas_html += "</div>"; // eof div .row
					// console.log(JSON.stringify(obj_berkas_template));
				}

				$("#berkasContainer").html(berkas_html);
				$("#rowsInpatientFile").toggleClass("d-none");
				$("#detailInpatientFile").toggleClass("d-none");
				$("#btn_save_berkas_final").attr("reg_id", reg_id);
				// console.log(JSON.stringify(data));
				pageInit();
				uploadTemplateBerkas(regid, rekanan_id, array_berkas_template);
				upload_berkas();
				detail_berkas();
				sessionStorage.clear();
			},
			error: function (data) {
				// console.log(JSON.stringify(data));
				alert(JSON.stringify(data));
				// pageInit();
			},
		});
	}

	function upload_berkas() {
		$(".btn_upload_berkas").on("click", function () {
			Dropzone.autoDiscover = false;
			var desc = $(this).parent().attr("ket");
			var berkas_id = $(this).parent().attr("berkas_id");
			var reg_id = $(this).parent().attr("reg_id"); //window.location.hash.slice(1);

			var title = "Upload" + " " + desc;
			var html = '<div class="position-relative h-100" id="uploadImage">';
			html += "";
			html +=
				'<form action="' +
				base_url +
				"functions/Form_app_func/uploadBerkas" +
				'" class="dropzone h-100 d-flex justify-content-center" id="dropBerkas" berkas_id="' +
				berkas_id +
				'" reg_id="' +
				reg_id +
				'" style="opacity:0.7; border: none;"></form>';
			html += "</div>";
			var btn =
				'<div class="alert alert-danger d-none" id="templateErr" role="alert">' +
				"A simple danger alert—check it out!" +
				"</div>" +
				'<button class="btn btn-primary" id="saveUploadBerkas" ype="button" berkas_id="' +
				berkas_id +
				'" reg_id="' +
				reg_id +
				'">Oke</button>';

			$("#myDynamicModal .modal-footer").html(btn);
			$("#myDynamicModal .modal-body").html(html);
			$("#myDynamicModal .modal-title").html(title);
			$("#myDynamicModal").modal("show");
			dropZoneBerkas(reg_id, berkas_id, desc);
		});
	}

	function uploadTemplateBerkas(reg_id, rekanan_id, array_berkas_template) {

		$(".btn-upload-template").on("click", function () {
			// console.log(JSON.stringify(array_berkas_template));
			Dropzone.autoDiscover = false;
			var berkas_id = $(this).attr("berkas_id");
			var desc = $(this).attr("desc");
			$("#myDynamicModal .modal-dialog").addClass("modal-lg");
			$.ajax({
				type: "POST",
				dataType: "json",
				url: base_url + "functions/Form_app_func/checkTemplate",
				data: {
					reg_id: reg_id,
					berkas_id: berkas_id,
				},
				success: function (data) {
					//document.getElementById("tempPathSpan").remove();
					// alert(JSON.stringify(data));
					var rcount = data.rekanan.length;
					var selected = "";
					var selectActive = "";
					var title = "Upload Template" + " " + desc;

					var html = '<div class="form-row pb-3" id="templateOptionContainer">';
					var template_count = data.template.length;
					// console.log(template_count);
					var default_radio_active = "";
					var default_radio_check = "";

					var default_uploaded = "";
					var rek_uploaded = "";
					var rek_radio_active = "";
					var rek_radio_check = "";

					var default_radio_btn = '<input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioTemplate1" value="Default" >';
					var rek_radio_btn = '<input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioTemplate2" value="Pilih Rekanan" >';

					var template_container = "";
					var default_template_container = "";
					var rek_template_container = "";
					
					var confirm_template = "";
					html +=
						'<small class="form-text text-muted mb-3">' +
						"Pilih <b>Default</b> untuk membuat menjadi default template atau <b>Pilih Rekanan</b> untuk menjadikan template khusus bagi rekanan tertentu." +
						"</small>";

						if ( template_count > 0 ) {
							for (var i = 0; i < template_count; i++) {						
								if (data.template[i].berkas_id == berkas_id) {
									if (data.template[i].rekanan_id == "DEFAULT") {	
										default_uploaded = "Y"													
										default_radio_btn = '<div class="form-inline d-flex justify-content-end hover circle hide px-1">' +
											'<a class="i-wrapp light btn-edit-template" role="button" data-toggle="tooltip" data-placement="bottom" title="Edit Template" rekanan_id = "' + data.template[i].rekanan_id + 
											'" berkas_id="' + data.template[i].berkas_id + '"><i class="far fa-edit"></i></a>' +
											'<a class="i-wrapp light btn-cancel-template d-none" role="button" data-toggle="tooltip" data-placement="bottom" title="Batal" rekanan_id = "' + data.template[i].rekanan_id + 
											'" berkas_id="' + data.template[i].berkas_id + '"><i class="fas fa-undo-alt"></i></a>' +
											'</div><input class="form-check-input edit" type="radio" name="inlineRadioOptions" id="radioTemplate1" value="Default" disabled>';
										default_template_container += '<div class="col-sm-12 col-md-6 col-lg-6">' +
											'<span>1</span></div>';
									} else if (data.template[i].rekanan_id == rekanan_id) {
										rek_uploaded = "Y"
										rek_radio_btn = '<div class="form-inline d-flex justify-content-end hover circle hide px-1">' +
											'<a class="i-wrapp light btn-edit-template" role="button" data-toggle="tooltip" data-placement="bottom" title="Edit Template" rekanan_id = "' + data.template[i].rekanan_id + 
											'" berkas_id="' + data.template[i].berkas_id + '"><i class="far fa-edit"></i></a>' +
											'<a class="i-wrapp light btn-cancel-template d-none" role="button" data-toggle="tooltip" data-placement="bottom" title="Batal" rekanan_id = "' + data.template[i].rekanan_id + 
											'" berkas_id="' + data.template[i].berkas_id + '"><i class="fas fa-undo-alt"></i></a>' +
											'</div><input class="form-check-input edit" type="radio" name="inlineRadioOptions" id="radioTemplate2" value="Pilih Rekanan" disabled>';
										rek_template_container += '<div class="col-sm-12 col-md-6 col-lg-6">' +
											'<span>2</span></div>';
									}
								}
							}
							confirm_template = "Data sebelumnya akan digantikan oleh data ini"
						} 

					html += '<div class="col-sm-12 col-md-6 col-lg-6">';
					html +=
						'<div class="form-check form-check-inline">' +
						default_radio_btn +
						'<label class="form-check-label" for="radioTemplate1">Default</label>' +
						"</div>"; // eof form-check
					html += "</div>"; // eof col

					html += '<div class="col-sm-12 col-md-6 col-lg-6">';
					html +=
						'<div class="form-check form-check-inline">' +
						rek_radio_btn +
						'<label class="mr-sm-2 sr-only" for="selectRekananTemplate">Preference</label>' +
						'<select class="custom-select mr-sm-2" id="selectRekananTemplate" disabled>';
					for (var i = 0; i < rcount; i++) {
						if (data.rekanan[i].rekanan_id == rekanan_id) {
							selected = "selected";
						} else {
							selected = "";
							selectActive = "";
						}
						
						html +=
							"<option " +
							selected +
							' value = "' +
							data.rekanan[i].rekanan_id +
							'" ' +
							selectActive +
							">" +
							data.rekanan[i].rekanan_nama +
							"</option>";
					}
					html += "</select>"; // eof select
					html += "</div>"; // eof form-check form-check-inline
					html += "</div>"; // eof col

					html += "</div>"; // eof form-row

					html += '<div class="form-row pb-3">';
					html += '<div class="col-sm-12 col-md-12" style="height: 20em;">';		
					html += '<div class="position-relative h-100" id="uploadTemplBerkas">';							
					html +=
						'<form action="' +
						base_url +
						"functions/Form_app_func/uploadTemplate" +
						'" class="dropzone h-100 d-flex align-items-center justify-content-center" id="dropTemplate" berkas_id="' +
						berkas_id +
						'" style="opacity:0.7; border: none;"></form>';
					html += "</div>"; // eof uploadTemplBerkas				
					html += "</div>"; // eof col-sm-12						
					html += "</div>"; // eof form-row

					var btn =
						'<div class="alert alert-danger d-none" id="templateErr" role="alert">' +
						"A simple danger alert—check it out!" +
						"</div>" +
						'<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>' +
						'<button class="btn btn-primary" id="saveUploadTemplBerkas" ype="button" berkas_id="' +
						berkas_id +
						'" desc="' +
						desc +
						'" >Oke</button>';

					$("#myDynamicModal .modal-footer").html(btn);
					$("#myDynamicModal .modal-body").html(html);
					$("#myDynamicModal .modal-title").html(title);
					$("#myDynamicModal").modal({
						backdrop: "static",
					});
					$("#myDynamicModal").modal("show");
					dropZoneTemplate(berkas_id);
				},
				error: function (data) {
					console.log(JSON.stringify(data));
					//alert(2);
				},
			});
			// console.log(berkas_id + "," + rekanan_id + "," + desc);
		});

		$("#myDynamicModal").on("hidden.bs.modal", function (event) {
			if ($("#myDynamicModal .modal-dialog").hasClass("modal-lg")) {
				$("#myDynamicModal .modal-dialog").removeClass("modal-lg");
			}
		});
	}

	function dropZoneTemplate(berkas_id) {
		var rekanan_id = "";
		var rekanan_nama = "";
		var desc = "";

		$("#templateOptionContainer").on("click", ".btn-edit-template", function () { 
			if (!$(this).hasClass("disabled")) {		
				if ($(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").hasClass("edit")) {		
					// $("input[type=radio][name=inlineRadioOptions]").prop("disabled", true);	
					// $("input[type=radio][name=inlineRadioOptions]").prop("checked", false);	
					$(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").prop("disabled", false);
					$(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").prop("checked", true);
					$("input[type=radio][name=inlineRadioOptions]").trigger("change");
				}		
				$(this).parent().find(".btn-edit-template").toggleClass("d-none");
				$(this).parent().find(".btn-cancel-template").toggleClass("d-none");
				$(".btn-edit-template").toggleClass("disabled");
			} else {
				//
			}
		});

		$("#templateOptionContainer").on("click", ".btn-cancel-template", function () { 
			if ($(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").hasClass("edit")) {
				$(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").prop("disabled", true);
				$(this).parent().parent().find("input[type=radio][name=inlineRadioOptions]").prop("checked", false);	
			}		
			$(this).parent().find(".btn-edit-template").toggleClass("d-none");
			$(this).parent().find(".btn-cancel-template").toggleClass("d-none");
			$(".btn-edit-template").toggleClass("disabled");
		});

		$("input[type=radio][name=inlineRadioOptions]").change(function () {

			if (this.value == "Default") {
				$("#selectRekananTemplate").prop("disabled", true);
				rekanan_id = "DEFAULT";
				rekanan_nama = "DEFAULT";
			} else if (this.value == "Pilih Rekanan") {
				$("#selectRekananTemplate").prop("disabled", false);
				rekanan_id = $("#selectRekananTemplate option")
					.filter(":selected")
					.val();
				rekanan_nama = $("#selectRekananTemplate option")
					.filter(":selected")
					.text();
			}

			$("#selectRekananTemplate").change(function () {
				rekanan_id = $("#selectRekananTemplate option")
					.filter(":selected")
					.val();
				rekanan_nama = $("#selectRekananTemplate option")
					.filter(":selected")
					.text();
			});

			if ($("input[type=radio][name=inlineRadioOptions]").is(":checked")) {
				// dropZoneTemplate();
				if ($("#dropTemplate .dz-button").length) {
					// nothing
				} else {
					$("form#dropTemplate").dropzone({
						maxFilesize: 10,
						uploadMultiple: true,
						thumbnailWidth: 200,
						thumbnailHeight: 200,
						thumbnailMethod: "contain",
						addRemoveLinks: true,
						init: function () {
							this.on("addedfile", function (file) {
								console.log(rekanan_id, berkas_id, desc);
								var file = file;
								var countFile = this.files.length;

								if (this.files.length == 0) {
									alert("file tidak ditemukan");
									return false;
								} else {
								}

								var data = new FormData();
								for (var i = 0; i < countFile; i++) {
									data.append("imageFile", this.files[i]);
								}
								data.append("rekanan_id", rekanan_id);
								data.append("berkas_id", berkas_id);
								data.append("desc", desc);
								// console.log(JSON.stringify(data));

								var options = {};
								options.url =
								base_url + "functions/Form_app_func/uploadTemplateTemp";
								options.type = "POST";
								options.data = data;
								options.contentType = false;
								options.processData = false;
								options.dataType = "json";
								options.responseType = "json";
								options.success = function (result) {
									// var p = "<?= base_url(); ?>" + result.path;
									// console.log(JSON.stringify(result.imgName));

									var elmnt = document.createElement("span");
									var node = document.createTextNode(result.path);
									var content = document.getElementById("uploadTemplBerkas");
									var css = document.createElement("style");
									css.type = "text/css";
									// var styles = "span {display:none}";

									// if (css.styleSheet) css.styleSheet.cssText = styles;
									// else css.appendChild(document.createTextNode(styles));

									elmnt.setAttribute("id", "tempPathSpan" + result.filecount);
									elmnt.setAttribute("class", "path-container");
									elmnt.setAttribute("fpath", result.path);
									elmnt.setAttribute("fname", result.fileName);
									elmnt.setAttribute("berkas", result.berkas_id);
									elmnt.setAttribute("queue", result.filecount);
									elmnt.style.display = "none";
									elmnt.appendChild(node);
									elmnt.appendChild(css);
									content.appendChild(elmnt);
									$("#dropTemplate").css({ opacity: "1" });
									// console.log(result.berkas_id);
									$("#templateOptionContainer")
										.find("input[type=radio][name=inlineRadioOptions]")
										.prop("disabled", true);
								};
								options.error = function (err) {
									alert(JSON.stringify(err));
									console.log(JSON.stringify(err));
								};
								$.ajax(options);

								return true;
							}),
								this.on("thumbnail", function (file, dataUrl) {
									// $(".dz-image").parent().css({ margin: "0" });
									// $(".dz-image").parent().parent().css({ padding: "0" });
								}),
								this.on("success", function (file) {
									// $(".dz-image").css({ width: "100%", height: "100%" });
									var fileExt = file.name.replace(/(?:[\s.](?![^.]+$))+/g, "_");
									if (this.getQueuedFiles().length > 0) {
										this.processQueue();
									} else {
										// console.log(file);
										var $preview = $(file.previewElement).find("img");
										console.log($preview);

										var ext = checkFileExt(file.name); // Get extension
										var newimage = "";

										// Check extension
										if (ext != "png" && ext != "jpg" && ext != "jpeg") {
											if (ext == "pdf") {
												newimage = base_url + "assets/img/icons/pdf_file.png"; // default image path
											} else if (
												ext.indexOf("doc") != -1 ||
												ext.indexOf("docx") != -1
											) {
												newimage = base_url + "assets/img/icons/doc_file.png"; // default image path
												// $(file.previewElement).find(".dz-image img").attr("src", "/Content/Images/word.png");
											} else if (
												ext.indexOf("xls") != -1 ||
												ext.indexOf("xlsx") != -1
											) {
												newimage = base_url + "assets/img/icons/xls_file.png"; // default image path
												// $(file.previewElement).find(".dz-image img").attr("src", "/Content/Images/excel.png");
											}
											$(file.previewElement)
												.find(".dz-image img")
												.attr("src", newimage);
										}

										$(".dz-image").find("img").attr({
											width: "100%",
											height: "100%",
											display: "block",
										});
										$(".dz-details").find("span").css({ display: "block" });

										if ($("#templateErr").hasClass("d-none")) {
											//
										} else {
											$("#templateErr").addClass("d-none");
										}
									}
									// this.createThumbnailFromUrl(file, newimage);
								}),
								this.on("error", function (file, errormessage, xhr) {
									if (xhr) {
										var response = JSON.parse(xhr.responseText);
										alert(response.message);
									}
								}),
								this.on("removedfile", function (file) {
									// console.log(currentFile);
									// var currentFile = file.name.replace(/ /g, "_");
									var currentFile = file.name.replace(
										/(?:[\s.](?![^.]+$))+/g,
										"_"
									);
									// console.log(currentFile);

									$.each($(".path-container"), function (index) {
										var fileUploaded = $(this).attr("fName");
										// console.log(fileUploaded + ' \ ' + currentFile);
										if (fileUploaded == currentFile) {
											var currentPath = $(this).attr("fPath");
											$.ajax({
												type: "POST",
												dataType: "json",
												url:
													base_url +
													"functions/Form_app_func/removeTemplBerkas",
												data: {
													currentFile: currentFile,
													currentPath: currentPath,
													requested: 2,
												},
												success: function (data) {
													console.log(index);
													//document.getElementById("tempPathSpan").remove();
													//alert(JSON.stringify(data));
												},
												error: function (data) {
													alert(JSON.stringify(data));
													//alert(2);
												},
											});
											$(this).remove();
										}
									});
									// if ($(".path-container").length == 0) {
									// 	$('#templateOptionContainer').find('input[type=radio][name=inlineRadioOptions]').prop("disabled", false);
									// }
								});
						},
					});
				}
			} else {
				// console.log(rekanan_id, berkas_id, desc);
			}
		});

		$("#saveUploadTemplBerkas").on("click", function () {
			var berkas_id = $(this).attr("berkas_id");
			var file_path = "";
			var file_name = "";
			var berkas_name = $(this).attr("desc");
			var url = "";
			var err = "";
			// console.log(rekanan_id);

			if ($(this).parent().parent().find(".path-container").length) {
				$.each($(".path-container"), function () {
					if ($(this).length) {
						var title =
							'Konfirmasi&nbsp;<i class="fas fa-exclamation-circle"></i>';
						var body = "<p>Yakin untuk menyimpan data ini?</p>";
						var btn =
							'<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>' +
							'<button class="btn btn-primary" id="saveTemplBerkas" ype="button" berkas_id="' +
							berkas_id +
							'" desc="' +
							desc +
							'" >Oke</button>';

						$("#myConfirmModal .modal-footer").html(btn);
						$("#myConfirmModal .modal-body").html(body);
						$("#myConfirmModal .modal-title").html(title);
						$("#myConfirmModal").modal({
							backdrop: "static",
						});
						$("#myConfirmModal").modal("show");
						// console.log($(this).attr("fpath") + $(this).attr("fname"));
						file_path = $(this).attr("fpath");
						file_name = $(this).attr("fname");
						url = file_path + file_name;
						$("#saveTemplBerkas").on("click", function () {
							var loading =
								"<div style='text-align:center;'><img src='../../assets/img/gif/loader.gif' height='100px' /></div>";
							title = "Informasi";
							body =
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
							btn =
								'<button class="btn btn-primary close-modal-btn" type="button" data-dismiss="modal">Oke</button>';

							$("#myConfirmModal .modal-body").html(loading);

							$.ajax({
								type: "POST",
								dataType: "json",
								url: base_url + "functions/Form_app_func/saveBerkasTemplate",
								data: {
									rekanan_id: rekanan_id,
									rekanan_nama: rekanan_nama,
									berkas_id: berkas_id,
									berkas_name: berkas_name,
									file_path: file_path,
									file_name: file_name,
									url: url,
								},
								success: function (data) {
									//document.getElementById("tempPathSpan").remove();
									$("#myConfirmModal .modal-title").html(title);
									$("#myConfirmModal .modal-footer").html(btn);
									$("#myConfirmModal .modal-body").html(body);
									$(".close-modal-btn").on("click", function () {
										$("#myConfirmModal").modal("hide");
										$("#myDynamicModal").modal("hide");
										location.reload();
										return false;
										// var regid = window.location.hash.slice(1);
										// loaderFunction();
										// loadDetailInpatientFile(regid);
									});
									console.log(JSON.stringify(data));
								},
								error: function (data) {
									alert(JSON.stringify(data));
									//alert(2);
								},
							});
						});
						// console.log(url);
					} else {
						// alert("Data tidak ditemukan");
					}
				});
			} else {
				// console.log("err");
				err = "File belum diupload!";
				$("#templateErr").html(err);
				$("#templateErr").removeClass("d-none");
			}
			// alert(1201);
		});
	}

	$("#btnAddBerkas").on("click", function () {
		$(this).toggleClass("active");
		// alert(2154);
	});

	// $("#dropdownBerkas").on("click", ".dropdown-item", function () {
	// 	// alert($(this).attr("id"));
	// 	Dropzone.autoDiscover = false;
	// 	var desc = $(this).attr("ket");
	// 	var berkas_id = $(this).attr("id");
	// 	var reg_id = window.location.hash.slice(1);

	// 	var title = "Upload" + " " + desc;
	// 	var html = '<div class="position-relative h-100" id="uploadImage">';
	// 	html += "";
	// 	html +=
	// 		'<form action="' +
	// 		base_url +
	// 		"functions/Form_app_func/uploadBerkas" +
	// 		'" class="dropzone h-100" id="dropBerkas" berkas_id="' +
	// 		berkas_id +
	// 		'" reg_id="' +
	// 		reg_id +
	// 		'" style="opacity:0.7; border: none;"></form>';
	// 	html += "</div>";
	// 	var btn =
	// 		'<button class="btn btn-primary" id="saveUploadBerkas" ype="button" berkas_id="' +
	// 		berkas_id +
	// 		'" reg_id="' +
	// 		reg_id +
	// 		'" desc="' + desc + 
	// 		'">Oke</button>';

	// 	$("#myDynamicModal .modal-footer").html(btn);
	// 	$("#myDynamicModal .modal-body").html(html);
	// 	$("#myDynamicModal .modal-title").html(title);
	// 	$("#myDynamicModal").modal("show");
	// 	dropZoneBerkas(reg_id, berkas_id, desc);
	// });

	function dropZoneBerkas(reg_id, berkas_id, desc) {

		$("form#dropBerkas").dropzone({
			maxFilesize: 10,
			uploadMultiple: true,
			thumbnailWidth: 200,
			thumbnailHeight: 200,
			thumbnailMethod: "contain",
			addRemoveLinks: true,
			init: function () {
				this.on("addedfile", function (file) {
					var img = file;
					var countFile = this.files.length;

					if (this.files.length == 0) {
						alert("file tidak ditemukan");
						return false;
					} else {					
						if (this.files[1]!=null) {
							this.removeFile(this.files[0]);
						}
					}

					var data = new FormData();
					for (var i = 0; i < countFile; i++) {
						data.append("imageFile", this.files[i]);
					}
					data.append("reg_id", reg_id);
					data.append("berkas_id", berkas_id);
					data.append("ket", desc);

					var options = {};
					options.url = base_url + "functions/Form_app_func/uploadBerkasTemp";
					options.type = "POST";
					options.data = data;
					options.contentType = false;
					options.processData = false;
					options.dataType = "json";
					options.responseType = "json";
					options.success = function (result) {
						// var p = "<?= base_url(); ?>" + result.path;
						// console.log(JSON.stringify(result.imgName));

						var elmnt = document.createElement("span");
						var node = document.createTextNode(result.file_path);
						var content = document.getElementById("uploadImage");
						var css = document.createElement("style");
						css.type = "text/css";
						// var styles = "span {display:none}";

						// if (css.styleSheet) css.styleSheet.cssText = styles;
						// else css.appendChild(document.createTextNode(styles));

						elmnt.setAttribute("id", "tempPathSpan" + result.file_count);
						elmnt.setAttribute("class", "path-container");
						elmnt.setAttribute("file_path", result.file_path);
						elmnt.setAttribute("file_name", result.file_name);
						elmnt.setAttribute("real_name", result.real_name);
						elmnt.setAttribute("berkas_id", result.berkas_id);
						elmnt.setAttribute("queue_item", result.file_count);
						elmnt.style.display = "none";
						elmnt.appendChild(node);
						elmnt.appendChild(css);
						content.appendChild(elmnt);
						$("#dropBerkas").css({ opacity: "1" });
					};
					options.error = function (err) {
						alert(JSON.stringify(err));
						console.log(JSON.stringify(err));
					};
					$.ajax(options);
					return true;
				}),
				this.on("thumbnail", function (file, dataUrl) {
					// $(".dz-image")
					// 	.last()
					// 	.find("img")
					// 	.attr({ width: "100%", height: "100%" });
					// $(".dz-image").css({ "border-radius": "inherit" });
					// $(".dz-image").parent().css({ margin: "0" });
					// $(".dz-image").parent().parent().css({ padding: "0" });
				}),
				this.on("success", function (file) {
					// $(".dz-image").css({ width: "100%", height: "100%" });
					var fileExt = file.name.replace(/(?:[\s.](?![^.]+$))+/g, "_");
					if (this.getQueuedFiles().length > 0) {
						this.processQueue();
					} else {
						// console.log(file);
						var $preview = $(file.previewElement).find("img");
						console.log($preview);

						var ext = checkFileExt(file.name); // Get extension
						var newimage = "";

						// Check extension
						if (ext != "png" && ext != "jpg" && ext != "jpeg") {
							if (ext == "pdf") {
								newimage = base_url + "assets/img/icons/pdf_file.png"; // default image path
							} else if (
								ext.indexOf("doc") != -1 ||
								ext.indexOf("docx") != -1
							) {
								newimage = base_url + "assets/img/icons/doc_file.png"; // default image path
								// $(file.previewElement).find(".dz-image img").attr("src", "/Content/Images/word.png");
							} else if (
								ext.indexOf("xls") != -1 ||
								ext.indexOf("xlsx") != -1
							) {
								newimage = base_url + "assets/img/icons/xls_file.png"; // default image path
								// $(file.previewElement).find(".dz-image img").attr("src", "/Content/Images/excel.png");
							}
							$(file.previewElement)
								.find(".dz-image img")
								.attr("src", newimage);
						}

						$(".dz-image").find("img").attr({
							width: "100%",
							height: "100%",
							display: "block",
						});
						$(".dz-details").find("span").css({ display: "block" });

						if ($("#templateErr").hasClass("d-none")) {
							//
						} else {
							$("#templateErr").addClass("d-none");
						}
					}
					// this.createThumbnailFromUrl(file, newimage);
				}),
				this.on("error", function (file, errormessage, xhr) {
					if (xhr) {
						var response = JSON.parse(xhr.responseText);
						alert(response.message);
					}
				}),
				this.on("removedfile", function (file) {
					// console.log(currentFile);
					// var currentFile = file.name.replace(/ /g, "_");
					var currentFile = file.name.replace(
						/(?:[\s.](?![^.]+$))+/g,
						"_"
					);
					// console.log(currentFile);

					$.each($(".path-container"), function (index) {
						var fileUploaded = $(this).attr("file_name");
						// console.log(fileUploaded + ' \ ' + currentFile);
						if (fileUploaded == currentFile) {
							var currentPath = $(this).attr("file_path");
							$.ajax({
								type: "POST",
								dataType: "json",
								url:
									base_url +
									"functions/Form_app_func/removeBerkas",
								data: {
									currentFile: currentFile,
									currentPath: currentPath,
									requested: 2,
								},
								success: function (data) {
									console.log(index);
									//document.getElementById("tempPathSpan").remove();
									//alert(JSON.stringify(data));
								},
								error: function (data) {
									alert(JSON.stringify(data));
									//alert(2);
								},
							});
							$(this).remove();
						}
					});
					// if ($(".path-container").length == 0) {
					// 	$('#templateOptionContainer').find('input[type=radio][name=inlineRadioOptions]').prop("disabled", false);
					// }
				});
			},
		});
		saveUploadBerkas();
	}

	function saveUploadBerkas() {
		// $("#myDynamicModal").on("shown.bs.modal", function (event) {
		$("#saveUploadBerkas").on("click", function () {
			var reg_id = $(this).attr("reg_id");
			var berkas_id = $(this).attr("berkas_id");
			var desc = $(this).attr("desc");
			var file_path = "";
			var file_name = "";
			var real_name = "";
			var url = "";
			var queue_item = "";
			var err = "";


			if ($(this).parent().parent().find(".path-container").length) {
				$.each($(".path-container"), function () {
					if ($(this).length) {
						// var title =
						// 	'Konfirmasi&nbsp;<i class="fas fa-exclamation-circle"></i>';
						// var body = "<p>Yakin untuk menyimpan data ini?</p>";
						// var btn =
						// 	'<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>' +
						// 	'<button class="btn btn-primary" id="saveBerkas" ype="button" berkas_id="' +
						// 	berkas_id +
						// 	'" desc="' +
						// 	desc +
						// 	'" >Oke</button>';

						// $("#myConfirmModal .modal-footer").html(btn);
						// $("#myConfirmModal .modal-body").html(body);
						// $("#myConfirmModal .modal-title").html(title);
						// $("#myConfirmModal").modal({
						// 	backdrop: "static",
						// });
						// $("#myConfirmModal").modal("show");
						file_path = $(this).attr("file_path");
						file_name = $(this).attr("file_name");
						real_name = $(this).attr("real_name");
						queue_item = $(this).attr("queue_item");
						url = file_path + file_name;

						obj_berkas = {'berkas_id':berkas_id, 'reg_id':reg_id, 'file_path':file_path, 'file_name':file_name, 'queue_item': 1, 'url':url, 'template':'Y', 'real_name':real_name};
						list_obj_berkas.push(obj_berkas);

						sessionStorage.setItem("list_obj_berkas_temp",JSON.stringify(list_obj_berkas));
						// console.log(JSON.stringify(obj_berkas));
						$('#myDynamicModal').modal('hide');
				

						// $("#saveBerkas").on("click", function () {
							// var loading =
							// 	"<div style='text-align:center;'><img src='../../assets/img/gif/loader.gif' height='100px' /></div>";
							// title = "Informasi";
							// body =
							// 	"<div class='success-checkmark'>" +
							// 	"<div class='check-icon'>" +
							// 	"<span class='icon-line line-tip'></span>" +
							// 	"<span class='icon-line line-long'></span>" +
							// 	"<div class='icon-circle'></div>" +
							// 	"<div class='icon-fix'></div>" +
							// 	"</div>" +
							// 	"</div>" +
							// 	"<div class='row justify-content-center'>" +
							// 	"<div class='col-7 text-center'>" +
							// 	"Data telah tersimpan" +
							// 	"</div>" +
							// 	"</div>";
							// btn =
							// 	'<button class="btn btn-primary close-modal-btn" type="button" data-dismiss="modal">Oke</button>';

							// $("#myConfirmModal .modal-body").html(loading);
							
							
						// });
					}
				});

			} else {
				err = "File belum diupload!";
				$("#templateErr").html(err);
				$("#templateErr").removeClass("d-none");
			}		
						
			$("#myDynamicModal").on("hidden.bs.modal", function (event) {
				list_obj_berkas_temp = JSON.parse(sessionStorage.getItem('list_obj_berkas_temp'));
				if (list_obj_berkas_temp !== null && list_obj_berkas_temp !== undefined) {
					if (list_obj_berkas_temp.length) {
						// console.log(list_obj_berkas_temp.length);
						// console.log(JSON.stringify(list_obj_berkas_temp));
						
						$.each(list_obj_berkas_temp, function(i,item){	
							// console.log(this.berkas_id)			
							$('#berkas_' + this.berkas_id).find('.fa-check-circle').removeClass('text-white');
							$('#berkas_' + this.berkas_id).find('.fa-check-circle').addClass('text-warning');
						 });
					}
				}
			});

		});
	}

	$("#btn_save_berkas_final").on("click", function () {
		var reg_id =  $(this).attr("reg_id");
		var title =
				'Konfirmasi&nbsp;<i class="fas fa-exclamation-circle"></i>';
		var body = "<p>Yakin untuk menyimpan data ini?</p>";
		var btn =
			'<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>' +
			'<button class="btn btn-primary" id="save_berkas_confirm" ype="button" reg_id="' + reg_id + '">Oke</button>';
		var err = "";

		$("#myDynamicModal .modal-footer").html(btn);
		$("#myDynamicModal .modal-body").html(body);
		$("#myDynamicModal .modal-title").html(title);

		var list_obj_berkas_toSave = [];
		var berkas = {};
		$.each($(".toggle-checkbox:not(.registered):checked"), function () {
			berkas = {'berkas_id':$(this).attr("berkas_id"), 'reg_id':reg_id, 'file_path':"", 'file_name':"", 'queue_item':1, 'url':"", 'template':'N', 'real_name':""}
			list_obj_berkas_toSave.push(berkas);
			
		});
		var list_obj_berkas_upload = JSON.parse(sessionStorage.getItem('list_obj_berkas_temp'));
		if (list_obj_berkas_upload !== null && list_obj_berkas_upload !== undefined) {
			if (list_obj_berkas_upload.length) {
				$.each($(list_obj_berkas_upload), function (index,list) {
					list_obj_berkas_toSave.push(list);
				});
			}
		}
		console.log(list_obj_berkas_toSave.length);
		if (list_obj_berkas_toSave.length > 0) {	
			$("#myDynamicModal").modal("show");
			$("#myDynamicModal").on("shown.bs.modal", function (event) {
				$("#save_berkas_confirm").on("click", function () {	
					var loading =
						"<div style='text-align:center;'><img src='../../assets/img/gif/loader.gif' height='100px' /></div>";
					var title = "Informasi";
					var body =
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
						'<button class="btn btn-primary close-modal-btn" type="button" data-dismiss="modal">Oke</button>';

					$("#myConfirmModal .modal-body").html(loading);
					
					var reg_id =  $(this).attr("reg_id");					
					if (list_obj_berkas_toSave.length) {		
						console.log(JSON.stringify(list_obj_berkas_toSave));
						$("#card-header-alert").addClass("d-none");
						$.ajax({
								type: "POST",
								dataType: "json",
								url: base_url + "functions/Form_app_func/saveBerkasMS",
								data: {
								reg_id: reg_id,
							},
							success: function (data) {
								console.log(data.errMsg);
								//document.getElementById("tempPathSpan").remove();
								if (data.err !== "" && data.err  !== undefined) {
									if (data.err == "001") {
										window.location.href = base_url + "auth";;
									} else if (data.err == "002") {
										window.location.href = base_url + "auth";;
									}
								} else {								
									var trans_id = data.trans_id;
									var queue_item = 0;
									var file_path = "";
									var file_name = "";
									var url = "";
									$.each(list_obj_berkas_toSave, function(index,list){
										// console.log(list.url);
										$.ajax({
											type: "POST",
											dataType: "json",
											url: base_url + "functions/Form_app_func/saveBerkasDT",
											data: {
												reg_id: list.reg_id,
												trans_id: trans_id,
												berkas_id: list.berkas_id,
												queue_item: list.queue_item,
												file_path: list.file_path,
												file_name: list.file_name,
												real_name: list.real_name,
												url: list.url,
												template: list.template,
											},
											success: function (data) {
												if (data.err !== "" && data.err  !== undefined) {
													if (data.err == "001") {
														window.location.href = base_url + "auth";;
													} else if (data.err == "002") {
														window.location.href = base_url + "auth";;
													}
												} else {
													$("#myDynamicModal .modal-title").html(title);
													$("#myDynamicModal .modal-footer").html(btn);
													$("#myDynamicModal .modal-body").html(body);
													$(".close-modal-btn").on("click", function () {
														$("#myDynamicModal").modal("hide");
														location.reload();
														return false;
														// var regid = window.location.hash.slice(1);
														// loaderFunction();
														// loadDetailInpatientFile(regid);
													});
													console.log(JSON.stringify(data));
													
												}
											},
											error: function (data) {
												console.log(JSON.stringify(data));
												//alert(2);
											},
										});	
									});
									
								}
							},
							error: function (data) {
								alert(JSON.stringify(data));
								//alert(2);
							},
						});
					}
					// console.log(JSON.stringify(array_obj_save))
				});
			});
		} else {	
			err = "Tidak ada perubahan data!";
			$("#card-header-alert").html(err);	
			$("#card-header-alert").removeClass("d-none");
		}
	});

	$("#dropBerkas").on("click", ".dz-remove", function () {
		alert($(this).parent().parent().attr("reg_id"));
	});
	
	function detail_berkas() {
		$(".btn_detail_berkas").on("click", function () {
			$("#myDynamicModal .modal-dialog").addClass("modal-lg");
			var desc = $(this).parent().attr("ket");
			var trans_id = $(this).parent().attr("trans_id");
			var berkas_id = $(this).parent().attr("berkas_id");
			var reg_id = $(this).parent().attr("reg_id"); //window.location.hash.slice(1);

			var width = 200;
			var height = 150;
			var startX = 50;
			var startY = 0;

			$.ajax({
				type: "POST",
				dataType: "json",
				url: base_url + "functions/Form_app_func/getRegBerkasDetail",
				data: {
					reg_id: reg_id,
					trans_id: trans_id,
					berkas_id: berkas_id,
					width: width,
					height: height,
					startX: startX,
					startY: startY,
				},
				success: function (data) {
					var url = base_url + data.url;
					// console.log(JSON.stringify(data));
					// makeThumb(url);
					var ext = checkFileExt(data.file_name);
					var cls_file = "";
					if (ext != "png" && ext != "jpg" && ext != "jpeg") {
						if (ext == "pdf") {
							cls_file = "bg-pdf icon-pdf";
						} else if (
							ext.indexOf("doc") != -1 ||
							ext.indexOf("docx") != -1
						) {
							cls_file = "bg-doc icon-doc";
						} else if (
							ext.indexOf("xls") != -1 ||
							ext.indexOf("xlsx") != -1
						) {
							cls_file = "bg-xls icon-xls";
						}
					}
					var substr_name = "";
					if (data.real_name.length > 20) {
						substr_name = data.real_name.substring(0, 20) + "...";
					} else {
						substr_name = data.real_name;
					}

					var title = "Detail" + " " + desc;
					var html = 
							'<div class="card-body">' +
								'<div class="d-flex justify-content-center h-100 p-3 edit-upload-container">' +
								'</div>' +
								'<div class="row">' +
									'<label class="text-muted col-sm-12 col-md-3 col-lg-3 mb-0 mt-md-2 mt-lg-0">Nama File</label>' +
									'<span class="col-sm-12 col-md-9 col-lg-9 mb-md-2 mb-lg-0 font-weight-bold" id="tgl_masuk">&nbsp;&nbsp;' + data.real_name + '</span>' +
								'</div>' +
								'<div class="row">' +
									'<label class="text-muted col-sm-12 col-md-3 col-lg-3 mb-0 mt-md-2 mt-lg-0">Diupload oleh</label>' +
									'<span class="col-sm-12 col-md-9 col-lg-9 mb-md-2 mb-lg-0 font-weight-bold" id="tgl_masuk">&nbsp;&nbsp;' + data.upload_by + '</span>' +
								'</div>' +
								'<div class="row">' +
									'<label class="text-muted col-sm-12 col-md-3 col-lg-3 mb-0 mt-md-2 mt-lg-0">Tanggal Upload</label>' +
									'<span class="col-sm-12 col-md-9 col-lg-9 mb-md-2 mb-lg-0 font-weight-bold" id="tgl_masuk">&nbsp;&nbsp;' + data.upload_date + '</span>' +
								'</div>' +
							'</div>' +
							'<div class="d-flex justify-content-center h-100 p-3 thumb-container">' + 
								'<div class="position-relative">' +	
									'<div class="position-relative">' +	
										'<div class="thumb-wrapper hover-wrapper download">' +				
											data.thumb +
											'<div class="thumb-icon-container d-flex justify-content-center" reg_id="' + data.reg_id + '" trans_id="' + data.trans_id + '" berkas_id="' + berkas_id + '">' +
												'<div class="position-relative">' +
													'<a class="thumb-icon text-decoration-none" href="' +  base_url + data.url + '"  target="_blank" role="button" data-toggle="tooltip" data-placement="bottom" title="Unduh File" ><i class="fas fa-download"></i></a>' +
													'<a class="thumb-icon text-decoration-none edit-uploaded-btn" role="button" data-toggle="tooltip" data-placement="bottom" title="Ubah File"><i class="fa-solid fa-pen"></i></a>' +
													'<a class="thumb-icon text-decoration-none remove-uploaded-btn" role="button" data-toggle="tooltip" data-placement="bottom" title="Hapus File"><i class="fa-solid fa-trash"></i></a>' +
												'</div>' +
											'</div>' +		
										'</div>' +
									'</div>' + 			
									'<div class="rounded-bottom ' + cls_file + ' text-nowrap p-2" style="width:100%;">' + substr_name + '</div>' +
								'</div>';
					html += "</div>";
					var btn = '<button class="btn btn-primary close-modal-btn" type="button" data-dismiss="modal">Oke</button>';

					$("#myDynamicModal .modal-footer").html(btn);
					$("#myDynamicModal .modal-body").html(html);
					$("#myDynamicModal .modal-title").html(title);
					$("#myDynamicModal").modal("show");
					$(".edit-uploaded-btn").on("click", function () {
						var reg_id = $(this).closest(".thumb-icon-container").attr("reg_id");
						var trans_id = $(this).closest(".thumb-icon-container").attr("trans_id");
						var berkas_id = $(this).closest(".thumb-icon-container").attr("berkas_id");
						// console.log(trans_id + ',' + berkas_id);
						var title = "Upload" + " " + desc;
						var html = '<div class="position-relative h-100" id="uploadImage">';
						html += "";
						html +=
							'<form action="' +
							base_url +
							"functions/Form_app_func/uploadBerkas" +
							'" class="dropzone h-100 d-flex justify-content-center" id="dropBerkas" berkas_id="' +
							berkas_id +
							'" reg_id="' +
							reg_id +
							'" style="opacity:0.7; border: none;"></form>';
						html += "</div>";
						var btn =
							'<div class="alert alert-danger d-none" id="templateErr" role="alert">' +
							"A simple danger alert—check it out!" +
							"</div>" +
							'<button class="btn btn-primary" id="saveUploadBerkas" ype="button" berkas_id="' +
							berkas_id +
							'" reg_id="' +
							reg_id +
							'">Oke</button>';

						$("#myDynamicModal .modal-footer").html(btn);
						$("#myDynamicModal .edit-upload-container").html(html);
						$("#myDynamicModal .modal-title").html(title);
						
						dropZoneBerkas(reg_id, berkas_id, desc);

						// $.ajax({
						// 	type: "POST",
						// 	dataType: "json",
						// 	url: base_url + "functions/Form_app_func/updateUploadedBerkas",
						// 	data: {
						// 		trans_id: trans_id,
						// 		berkas_id: berkas_id,
						// 	},
						// 	success: function (data) {
						// 		console.log(JSON.stringify(data));
						// 		//alert(2);
						// 	},
						// 	error: function (data) {
						// 		console.log(JSON.stringify(data));
						// 		//alert(2);
						// 	},
						// });

					});
				},
				error: function (data) {
					console.log(JSON.stringify(data));
					//alert(2);
				},
			});

		});
	};

	// Get file extension
	function checkFileExt(filename) {
		filename = filename.toLowerCase();
		return filename.split(".").pop();
	}

	$(document).click(function (event) {
		var $target = $(event.target);
		if (
			!$target.closest("#btnAddBerkas").length &&
			$("#btnAddBerkas").hasClass("active")
		) {
			$("#btnAddBerkas").removeClass("active");
		}
	});

	function typeOf(obj) {
		return {}.toString.call(obj).split(' ')[1].slice(0, -1).toLowerCase();
	}
	Dropzone.discover();
})(jQuery); // End of use strict
