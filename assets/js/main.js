(function ($) {
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

	// multiple step form

	$.fn.multiStepForm = function (args) {
		var form = this;

		var fieldset = form.find("fieldset");
		var progress = $("#progressbar li");

		form.navigateTo = function (i) {
			atTheEnd = i >= fieldset.length - 1;
			fieldset.removeClass("current").eq(i).addClass("current");
			form.find(".previous").toggle(i > 0);
			atTheEnd = i >= fieldset.length - 1;
			form.find(".next").toggle(!atTheEnd);
			fixStepIndicator(curIndex());
			return form;
		};

		function fixStepIndicator(n) {
			var p = progress.filter(".active").length;
			if (n >= p) {
				progress.eq(n).addClass("active");
			} else {
				progress.eq(p - 1).removeClass("active");
			}
		}

		function curIndex() {
			/*Return the current index by looking at which section has the class 'current'*/
			return fieldset.index(fieldset.filter(".current"));
		}

		form.find(".next").click(function (event) {
			event.preventDefault();
			if (
				"validations" in args &&
				typeof args.validations === "object" &&
				!$.isArray(args.validations)
			) {
				if (
					!("noValidate" in args) ||
					(typeof args.noValidate === "boolean" && !args.noValidate)
				) {
					form.validate(args.validations);
					if (form.valid() == true) {
						form.navigateTo(curIndex() + 1);
						return true;
					}
					return false;
				}
			}
			form.navigateTo(curIndex() + 1);
		});

		form.find(".previous").click(function (event) {
			event.preventDefault();
			form.navigateTo(curIndex() - 1);
		});
		// $(".next").click(function (event) {
		// 	event.preventDefault();
		// 	current_fs = $(this).parent();
		// 	next_fs = $(this).parent().next();

		// 	//Add Class Active
		// 	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		// 	//show the next fieldset
		// 	next_fs.show();
		// 	//hide the current fieldset with style
		// 	current_fs.animate(
		// 		{ opacity: 0 },
		// 		{
		// 			step: function (now) {
		// 				// for making fielset appear animation
		// 				opacity = 1 - now;

		// 				current_fs.css({
		// 					display: "none",
		// 					position: "relative",
		// 				});
		// 				next_fs.css({ opacity: opacity });
		// 			},
		// 			duration: 600,
		// 		}
		// 	);
		// });

		// $(".previous").click(function (event) {
		// 	event.preventDefault();
		// 	current_fs = $(this).parent();
		// 	previous_fs = $(this).parent().prev();

		// 	//Remove class active
		// 	$("#progressbar li")
		// 		.eq($("fieldset").index(current_fs))
		// 		.removeClass("active");

		// 	//show the previous fieldset
		// 	previous_fs.show();

		// 	//hide the current fieldset with style
		// 	current_fs.animate(
		// 		{ opacity: 0 },
		// 		{
		// 			step: function (now) {
		// 				// for making fielset appear animation
		// 				opacity = 1 - now;

		// 				current_fs.css({
		// 					display: "none",
		// 					position: "relative",
		// 				});
		// 				previous_fs.css({ opacity: opacity });
		// 			},
		// 			duration: 600,
		// 		}
		// 	);
		// });
	};

	$(".submit").click(function () {
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate(
			{ opacity: 0 },
			{
				step: function (now) {
					// for making fielset appear animation
					opacity = 1 - now;

					current_fs.css({
						display: "none",
						position: "relative",
					});
					next_fs.css({ opacity: opacity });
				},
				duration: 600,
			}
		);
	});
})(jQuery); // End of use strict
