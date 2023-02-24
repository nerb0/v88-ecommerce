$(document).ready(function () {
	fetch(1, "products");

	const categories = {};
	$(".category-option-input").each(function () {
		const categoryId = $(this).attr("data-id");
		categories[categoryId] = $(this).val();
	});
	$("#updatedCategories").prop("value", JSON.stringify(categories));

	$(document).on("click", ".admin-edit-category", function (e) {
		e.stopPropagation();
		const input = $(this).siblings(".category-option-input");
		if (input.attr("readonly")) {
			input.removeAttr("readonly");
		} else {
			input.attr("readonly", "");
		}
		$(this)
			.parent()
			.siblings()
			.find(".category-option-input")
			.attr("readonly", "");
	});

	const updateCategories = () => {
		const categories = {};
		$(".category-option-input").each(function () {
			const categoryId = $(this).attr("data-id");
			categories[categoryId] = $(this).val();
		});
		$("#updatedCategories").removeAttr("disabled");
		$("#updatedCategories").prop("value", JSON.stringify(categories));
	};

	$(document).click(function (e) {
		if (e.target.className != "dropdown" && !$(e.target).parents(".dropdown-list").hasClass("dropdown-list")) {
			$(".category-option-input").attr("readonly", "");
		}
	});
	$(document).on("click", ".admin-delete-category", function (e) {
		e.stopPropagation();
		$(this).parent().remove();
		updateCategories();
		const newCategory = $($(".category-option-input")["0"]);
		$("#mainCategoryText").text(newCategory.val());
		$("#selectedCategory").prop("value", newCategory.attr("data-id"));
	});

	$(document).on(
		"change keydown keyup",
		".category-option-input",
		function (e) {
			const selectedCategory = $("#mainCategoryText");
			if ($(this).attr("data-id") == selectedCategory.attr("data-id")) {
				selectedCategory.text($(this).val());
			}
			updateCategories();
		}
	);
	$(document).on("click", "input.category-option-input", function (e) {
		e.stopPropagation();
		if ($(this).attr("readonly")) {
			$("#mainCategoryText").text($(this).val());
			$("#mainCategoryText").attr("data-id", $(this).attr("data-id"));
			$("#selectedCategory").val($(this).attr("data-id"));
			hideDropDown();
		}
	});
	$(document).on("click", ".category-option", function (e) {
		e.stopPropagation();
		const input = $(this).find("input.category-option-input");
		if (input.attr("readonly")) {
			$("#mainCategoryText").text(input.val());
			$("#mainCategoryText").attr("data-id", input.attr("data-id"));
			$("#selectedCategory").val(input.attr("data-id"));
			hideDropDown();
		}
	});
});
