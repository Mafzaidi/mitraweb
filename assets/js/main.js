(function ($) {
	"use strict"; // Start of use strict

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

		
})(jQuery); // End of use strict
