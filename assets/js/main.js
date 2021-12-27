(function ($) {
	"use strict"; // Start of use strict
	var base_url = $('#baseUrl').val();

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
				//pageInit();
			},
			error: function (data) {
				alert(JSON.stringify(data));
				//pageInit();
			},
		});
	});

	// multiple step form

	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;

	$(".next").click(function(){

		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
		step: function(now) {
		// for making fielset appear animation
		opacity = 1 - now;

		current_fs.css({
		'display': 'none',
		'position': 'relative'
		});
		next_fs.css({'opacity': opacity});
		},
		duration: 600
		});
	});

	$(".previous").click(function(){

	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	//Remove class active
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();

	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
	step: function(now) {
	// for making fielset appear animation
	opacity = 1 - now;

	current_fs.css({
	'display': 'none',
	'position': 'relative'
	});
	previous_fs.css({'opacity': opacity});
	},
	duration: 600
	});
	});

	$('.radio-group .radio').click(function(){
	$(this).parent().find('.radio').removeClass('selected');
	$(this).addClass('selected');
	});

	$(".submit").click(function(){
	return false;
	})

	// Autocomplete

	$( "#inputBorrower" ).autocomplete({
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
		}
    });
	
})(jQuery); // End of use strict
