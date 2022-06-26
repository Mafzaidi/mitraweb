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

	// When the user scrolls the page, execute myFunction
	window.onscroll = function () {
		navbarScrollFunction();
	};

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
		// Dropzone.autoDiscover = false;
		if (segments[6] !== "" && segments[6] == "poli-monitor") {
		} else if (segments[6] !== "" && segments[6] == "report-mr-brw") {
			// var date = new Date();
			// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		} else if (segments[6] !== "" && segments[6] == "mr-return") {
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
					alert(JSON.stringify(data));
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
	function initMrReturn() {
		$("#select_pageSize_mr_return").on("change", function (e) {
			e.preventDefault();
			var pageno = $("#mrReturn-pagination")
				.find(".active")
				.find(".page-link")
				.html();
			var page_start = 1;
			var per_page = $("#select_pageSize_mr_return option:selected").val();
			var pageselect = $("#select_pageSize_mr_return option:selected").val();
			var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
			var showitem = 1;
			var status = "not return";
			var from_date = "";
			var to_date = "";
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
				to_date
			);
			console.log(
				page_start,
				per_page,
				func_url,
				showitem,
				status,
				from_date,
				to_date
			);
		});

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
				to_date
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
			"</div>" +
			"</div>" +
			"<div class='form-group row mb-2' id='divCatatan'>" +
			"<label class='col-sm-4 col-form-label-sm pr-0 mb-2' for='returnDesc'>Keterangan :</label>" +
			"<div class='col-sm-8 pl-0'>" +
			"<input type='text' class='form-control-sm w-100 border-top-0 border-right-0 border-left-0 upper-text' id='inputReturnDesc' placeholder='keterangan' name='returnDesc'>" +
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
				var returnDesc = $("#inputReturnDesc").val();

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
						returnDesc: returnDesc,
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
					"<button class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

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
				"<button class='btn btn-primary' type='button' data-dismiss='modal'>Oke</button>";

			$("#myDynamicModal .modal-footer").html(btn);
			$("#myDynamicModal .modal-body").html(error);
			$("#myDynamicModal .modal-title").html(title);
			$("#myDynamicModal").modal("show");
		}
	});

	$("#select_pageSize_mr_return").on("change", function (e) {
		e.preventDefault();
		// alert(123);
		var pageno = 1;
		var page_start = 1;
		var pageselect = $("#select_pageSize_mr_return option:selected").val();
		var per_page = $("#select_pageSize_mr_return option:selected").val();
		var func_url = base_url + "functions/Medrec_func/loadPinjamMR";
		var showitem = 1;
		var status = "not return";
		var from_date = "";
		var to_date = "";
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

		loadPinjamMR(
			page_start,
			per_page,
			func_url,
			showitem,
			status,
			from_date,
			to_date
		);
		console.log(
			page_start,
			per_page,
			func_url,
			showitem,
			status,
			from_date,
			to_date
		);

		// if (pageselect !== "" && pageselect !== undefined) {
		// 	if (pageno !== "" && pageno !== undefined) {
		// 		page_start = (pageno - 1) * pageselect + 1;
		// 		func_url =
		// 			base_url + "functions/Form_app_func/loadInpatientFile/" + pageno;
		// 	} else {
		// 		pageno = 0;
		// 		page_start = 1;
		// 	}
		// } else {
		// 	per_page = "";
		// }

		// loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
		// console.log(pageno, pageselect, page_start, per_page, func_url);
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

	// $('#inputTxtSearchInpatient').keypress(function (e) {
	// 	if (e.which == 13) {
	// 		var page_start = 1;
	// 		var per_page = '';
	// 		var func_url = base_url + "functions/Form_app_func/loadInpatientFile";
	// 		var key_word = ''
	// 		var reg_id = $(this).attr("reg_id");
	// 		loadInpatientFile(page_start, per_page, func_url, key_word, reg_id);
	// 		return false;    //<---- Add this line
	// 	}
	//   });

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
					tb +=
						'<div class="row tb-row hover border-hover hover-event border-bottom ' +
						oddEven +
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
				console.log(page_start, per_page, data.count, num1, num2);

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

				console.log(JSON.stringify(data.per_page));
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
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "functions/Form_app_func/getInpatientFile",
			data: {
				reg_id: reg_id,
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

				var dropList = "";
				var rcount = data.dropmenu.length;
				for (var i = 0; i < rcount; i++) {
					dropList +=
						'<a class="dropdown-item" id="' +
						data.dropmenu[i].berkas_id +
						'" ket="' +
						data.dropmenu[i].keterangan +
						'">';
					dropList +=
						'<i class="far fa-file-alt fa-sm fa-fw mr-2 text-gray-400"></i>';
					dropList += data.dropmenu[i].keterangan + "</a>";
				}
				$("#dropdownBerkas").html(dropList);

				$("#rowsInpatientFile").toggleClass("d-none");
				$("#detailInpatientFile").toggleClass("d-none");
				console.log(JSON.stringify(data));
				pageInit();
			},
			error: function (data) {
				// console.log(JSON.stringify(data));
				alert(JSON.stringify(data));
				// pageInit();
			},
		});
	}

	$("#btnAddBerkas").on("click", function () {
		$(this).toggleClass("active");
		// alert(2154);
	});

	$("#dropdownBerkas").on("click", ".dropdown-item", function () {
		// alert($(this).attr("id"));
		Dropzone.autoDiscover = false;
		var desc = $(this).attr("ket");
		var berkas_id = $(this).attr("id");
		var reg_id = window.location.hash.slice(1);

		var title = "Upload" + " " + desc;
		var html = '<div class="position-relative image-file" id="uploadImage">';
		html += "";
		html +=
			'<form action="' +
			base_url +
			"functions/Form_app_func/uploadBerkas" +
			'" class="dropzone" id="dropBerkas" berkas_id="' +
			berkas_id +
			'" reg_id="' +
			reg_id +
			'" style="opacity:0.7; border: none;"></form>';
		html += "</div>";
		var btn =
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
					var countImg = this.files.length;

					if (this.files.length == 0) {
						alert("file tidak ditemukan");
						return false;
					} else {
					}

					var data = new FormData();
					for (var i = 0; i < countImg; i++) {
						data.append("imageFile", this.files[i]);
					}
					data.append("reg_id", reg_id);
					data.append("berkas_id", berkas_id);
					data.append("ket", desc);

					var options = {};
					options.url = base_url + "functions/Form_app_func/uploadBerkas";
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
						var content = document.getElementById("uploadImage");
						var css = document.createElement("style");
						css.type = "text/css";
						var styles = "span {display:none}";

						if (css.styleSheet) css.styleSheet.cssText = styles;
						else css.appendChild(document.createTextNode(styles));

						elmnt.setAttribute("id", "tempPathSpan" + result.filecount);
						elmnt.setAttribute("class", "path-container");
						elmnt.setAttribute("fPath", result.path);
						elmnt.setAttribute("fName", result.imgName);
						elmnt.setAttribute("berkas", result.berkas);
						elmnt.setAttribute("queue", result.filecount);
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

						var ext = checkFileExt(file.name); // Get extension
						var newimage = "";

						// Check extension
						if (ext != "png" && ext != "jpg" && ext != "jpeg") {
							newimage = base_url + "assets/img/icons/pdf_file.png"; // default image path
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
						var currentFile = file.name.replace(/ /g, "_");
						// console.log(currentFile);

						$.each($(".path-container"), function () {
							// // alert($(this).attr("path"));
							if ($(this).attr("fName") == currentFile) {
								// console.log($(this).attr("path") + currentFile);
								var currentPath = $(this).attr("fPath");
								$.ajax({
									type: "POST",
									dataType: "json",
									url: base_url + "functions/Form_app_func/removeBerkas",
									data: {
										currentFile: currentFile,
										currentPath: currentPath,
										requested: 2,
									},
									success: function (data) {
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
					}),
					this.on("removedfile", function (file) {
						var currentFile = file.name.replace(/ /g, "_");
						// console.log(currentFile);

						$.each($(".path-container"), function () {
							// // alert($(this).attr("path"));
							if ($(this).attr("imgName") == currentFile) {
								// console.log($(this).attr("path") + currentFile);
								var currentPath = $(this).attr("path");
								$.ajax({
									type: "POST",
									dataType: "json",
									url: base_url + "functions/Form_app_func/removeBerkas",
									data: {
										currentFile: currentFile,
										currentPath: currentPath,
										requested: 2,
									},
									success: function (data) {
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
						// var currentPath = document.getElementById('tempPathSpan').getAttribute('path');
					});
			},
		});
		saveUploadBerkas();
	}

	// Get file extension
	function checkFileExt(filename) {
		filename = filename.toLowerCase();
		return filename.split(".").pop();
	}

	function saveUploadBerkas() {
		// $("#myDynamicModal").on("shown.bs.modal", function (event) {
		$("#saveUploadBerkas").on("click", function () {
			var reg_id = $(this).attr("reg_id");
			var berkas_id = $(this).attr("berkas_id");

			if ($(this).parent().parent().find(".path-container").length) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_url + "functions/Form_app_func/saveBerkasMS",
					data: {
						reg_id: reg_id,
					},
					success: function (data) {
						//document.getElementById("tempPathSpan").remove();
						var trans_id = data.trans_id;
						var queue_item = 0;
						var file_path = "";
						var file_name = "";
						var url = "";
						$.each($(".path-container"), function () {
							if ($(this).length) {
								// console.log($(this).attr("path") + $(this).attr("imgname"));
								file_path = $(this).attr("fPath");
								file_name = $(this).attr("fName");
								queue_item = $(this).attr("queue");
								url = file_path + file_name;
								$.ajax({
									type: "POST",
									dataType: "json",
									url: base_url + "functions/Form_app_func/saveBerkasDT",
									data: {
										reg_id: reg_id,
										trans_id: trans_id,
										berkas_id: berkas_id,
										queue_item: queue_item,
										file_path: file_path,
										file_name: file_name,
										url: url,
									},
									success: function (data) {
										//document.getElementById("tempPathSpan").remove();
										console.log(JSON.stringify(data));
									},
									error: function (data) {
										alert(JSON.stringify(data));
										//alert(2);
									},
								});
							} else {
								// alert("Data tidak ditemukan");
							}
						});
						console.log(JSON.stringify(data));
					},
					error: function (data) {
						alert(JSON.stringify(data));
						//alert(2);
					},
				});
			} else {
				console.log("err");
			}
		});
		// });
	}

	$("#dropBerkas").on("click", ".dz-remove", function () {
		alert($(this).parent().parent().attr("reg_id"));
	});

	$(document).click(function (event) {
		var $target = $(event.target);
		if (
			!$target.closest("#btnAddBerkas").length &&
			$("#btnAddBerkas").hasClass("active")
		) {
			$("#btnAddBerkas").removeClass("active");
		}
	});
	Dropzone.discover();
})(jQuery); // End of use strict
