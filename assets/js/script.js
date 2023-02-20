// import "./jquery.min.js";
// import "./jquery-ui.min.js";

$(document).ready(function () {
	$(document).on(
		"change keyup keydown",
		".input-default > input, .input-default > textarea",
		function (e) {
			if ($(this).val()) {
				$(this).parent().addClass("has-value");
			} else {
				$(this).parent().removeClass("has-value");
			}
		}
	);

	$(".light-effect-container").mouseout(function (e) {
		const lightEffect = $(this).find("span#lightEffect")["0"];
		const { offsetX, offsetY } = e;
		$(lightEffect).addClass("light-hidden");
		$(lightEffect).attr(
			"style",
			`top: ${offsetY}px;
			left: ${offsetX}px;
			--radius: ${lightEffect.offsetHeight}px`
		);
	});
	$(".light-effect-container").mousemove(function (e) {
		const lightEffect = $(this).find("span#lightEffect")["0"];
		const { offsetX, offsetY } = e;
		$(lightEffect).removeClass("light-hidden");
		$(lightEffect).attr(
			"style",
			`top: ${offsetY}px;
			left: ${offsetX}px;
			--radius: ${lightEffect.offsetHeight}px`
		);
	});

	const passwordOpen =
		'<svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M.5 7.5l-.464-.186a.5.5 0 000 .372L.5 7.5zm14 0l.464.186a.5.5 0 000-.372L14.5 7.5zm-7 4.5c-2.314 0-3.939-1.152-5.003-2.334a9.368 9.368 0 01-1.449-2.164 5.065 5.065 0 01-.08-.18l-.004-.007v-.001L.5 7.5l-.464.186v.002l.003.004a2.107 2.107 0 00.026.063l.078.173a10.368 10.368 0 001.61 2.406C2.94 11.652 4.814 13 7.5 13v-1zm-7-4.5l.464.186.004-.008a2.62 2.62 0 01.08-.18 9.368 9.368 0 011.449-2.164C3.56 4.152 5.186 3 7.5 3V2C4.814 2 2.939 3.348 1.753 4.666a10.367 10.367 0 00-1.61 2.406 6.05 6.05 0 00-.104.236l-.002.004v.001H.035L.5 7.5zm7-4.5c2.314 0 3.939 1.152 5.003 2.334a9.37 9.37 0 011.449 2.164 4.705 4.705 0 01.08.18l.004.007v.001L14.5 7.5l.464-.186v-.002l-.003-.004a.656.656 0 00-.026-.063 9.094 9.094 0 00-.39-.773 10.365 10.365 0 00-1.298-1.806C12.06 3.348 10.186 2 7.5 2v1zm7 4.5a68.887 68.887 0 01-.464-.186l-.003.008-.015.035-.066.145a9.37 9.37 0 01-1.449 2.164C11.44 10.848 9.814 12 7.5 12v1c2.686 0 4.561-1.348 5.747-2.665a10.366 10.366 0 001.61-2.407 6.164 6.164 0 00.104-.236l.002-.004v-.001h.001L14.5 7.5zM7.5 9A1.5 1.5 0 016 7.5H5A2.5 2.5 0 007.5 10V9zM9 7.5A1.5 1.5 0 017.5 9v1A2.5 2.5 0 0010 7.5H9zM7.5 6A1.5 1.5 0 019 7.5h1A2.5 2.5 0 007.5 5v1zm0-1A2.5 2.5 0 005 7.5h1A1.5 1.5 0 017.5 6V5z"></path></svg>';
	const passwordClose =
		'<svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 9C5.186 9 3.561 7.848 2.497 6.666a9.368 9.368 0 01-1.449-2.164 5.065 5.065 0 01-.08-.18l-.004-.007v-.001L.5 4.5l-.464.186v.002l.003.004a2.107 2.107 0 00.026.063l.078.173a10.367 10.367 0 001.61 2.406C2.94 8.652 4.814 10 7.5 10V9zm7-4.5a68.887 68.887 0 01-.464-.186l-.003.008-.015.035-.066.145a9.37 9.37 0 01-1.449 2.164C11.44 7.848 9.814 9 7.5 9v1c2.686 0 4.561-1.348 5.747-2.666a10.365 10.365 0 001.61-2.406 6.164 6.164 0 00.104-.236l.002-.004v-.001h.001L14.5 4.5zM8 12V9.5H7V12h1zm-6.646-1.646l2-2-.708-.708-2 2 .708.708zm10.292-2l2 2 .708-.708-2-2-.708.708z"></path></svg>';
	$(".input-password > span#passwordToggle")
		.attr("data-state", "closed")
		.html(passwordClose)
		.click(function (e) {
			e.stopPropagation();
			if ($(this).attr("data-state") == "closed") {
				$(this.previousElementSibling).attr("type", "text");
				$(this).attr("data-state", "open");
				$(this).html(passwordOpen);
			} else {
				$(this.previousElementSibling).attr("type", "password");
				$(this).attr("data-state", "closed");
				$(this).html(passwordClose);
			}
		});

	$(document).click(function (e) {
		if (e.target.className != "dropdown") {
			const button = $(this).find(".dropdown-toggle-btn")["0"];
			$(button).addClass("dropdown-toggle-closed");
			$(".dropdown-list").addClass("transparent");
		}
	});
	$(".dropdown-toggle").click(function (e) {
		e.stopPropagation();
		const button = $(this).find(".dropdown-toggle-btn")["0"];
		if ($(button).hasClass("dropdown-toggle-closed")) {
			$(button).removeClass("dropdown-toggle-closed");
			$(this.nextElementSibling).removeClass("transparent");
		} else {
			$(button).addClass("dropdown-toggle-closed");
			$(this.nextElementSibling).addClass("transparent");
		}
	});

	const featuredSlide = document.getElementById("featuredSlide");
	$(document).on("click", ".featured-btn:not(.selected)", function (e) {
		const index = $(this).attr("data-index");
		$(this).siblings().removeClass("selected");
		$(this).addClass("selected");
		$(featuredSlide).attr("style", `transform: translateX(-${100 * index}%)`);
	});

	$("#changePasswordToggle").click(function (e) {
		const fieldset = $(this).siblings("fieldset");
		if (fieldset.attr("disabled")) {
			fieldset.removeAttr("disabled");
			fieldset.removeClass("hidden");
			fieldset.find("[name='change_password']").val("1");
		} else {
			fieldset.attr("disabled", "disabled");
			fieldset.addClass("hidden");
			fieldset.find("[name='change_password']").val("0");
		}
	});

	const cartSelectAll = document.getElementById("cartSelectAll");
	$(cartSelectAll).change(function (e) {
		if (this.checked) {
			$("#userCart input[type='checkbox']").prop("checked", "true");
		} else {
			$("#userCart input[type='checkbox']").prop("checked", "");
		}
	});

	const setSameBillingBtn = document.getElementById("setSameBillingBtn");
	$(setSameBillingBtn).change(function (e) {
		if (this.checked) {
			$("#billingAddressForm").addClass("hidden");
		} else {
			$("#billingAddressForm").removeClass("hidden");
		}
	});


	// NOTE: This is for disabling sibling checkbox from selecting the main image
	// Decided to use radio box since the logic already is applicable to radio boxes
	// $(document).on("change", ".edit-image-set-main", function (e) {
	// 	if ($(this).prop("checked")) {
	// 		$(this)
	// 			.parents(".edit-image-row")
	// 			.siblings()
	// 			.find(".edit-image-set-main")
	// 			.prop("checked", "")
	// 			.attr("disabled", "true");
	// 	} else {
	// 		$(this)
	// 			.parents(".edit-image-row")
	// 			.siblings()
	// 			.find(".edit-image-set-main")
	// 			.prop("checked", "")
	// 			.removeAttr("disabled");
	// 	}
	// });

	// NOTE: To assign its estimated id base on previous images,
	// Necessary for assigning the main picture

	const body = $("body");
	const modalContainer = $("#modalContainer");
	const modal = $("#modal");
	let uploadCounter = 0;
	const openModal = (content) => {
		body.addClass("overflow-hidden");
		modalContainer.removeClass("hidden");
		modal.html(content);

		$("#editImageList").sortable({
			placeholder: "edit-image-placeholder",
			handle: ".edit-image-drag",
			update: function (e) {
				$(".edit-new-image").each(function (index) {
					$(this).attr("value", index);
					$(this).attr("id", index);
					$(this).parent("label").attr("for", index);
				});
			},
		});

		// NOTE: Reset the count for the estimated id of the upload files
		// Applies to both product EDIT and ADD
		uploadCounter = 0;
	};
	$(document).on("click", ".modal-close", function (e) {
		body.removeClass("overflow-hidden");
		modalContainer.addClass("hidden");
		modal.html("");

		// NOTE: Remove all locally stored files once the modal is closed,
		// Applies to both product EDIT and ADD
		uploadCounter = 0;
	});

	$(".product-edit").click(function (e) {
		const id = $(this).attr("data-id");
		$.get(
			`/api/html/products/edit/${id}`,
			function (res) {
				openModal(res.response);
			},
			"json"
		);
	});

	$("#addProductBtn").click(function (e) {
		$.get(
			`/api/html/products/add`,
			function (res) {
				openModal(res.response);
			},
			"json"
		);
	});

	// NOTE: For temporarily reading the image uploaded so it can be displayed
	// even without storing it to the database
	const readUrl = (file) => {
		const fileContainer = new DataTransfer();
		fileContainer.items.add(file);
		const inputFile = $(
			'<input type="file" name="new_images[]" class="hidden" />'
		).prop("files", fileContainer.files);

		const fileReader = new FileReader();
		fileReader.addEventListener("load", function (e) {
			let lastId = document.querySelectorAll(".edit-image-set-main");
			lastId = parseInt($(lastId[lastId.length - 1]).attr("id")) + 1 || 1;
			const name = `image${lastId}`;
			const imageRow = `
				<li class="edit-image-row">
					<svg class="edit-image-drag" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.5 3a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm-4-10a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1z"></path>
					</svg><!--
					--><img src="${e.target.result}" alt="image${lastId}" class="edit-image-preview" /><!--
					--><p class="edit-image-name">${file.name}</p><!--
					--><svg class="edit-image-remove" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 .5H1.5a1 1 0 00-1 1V4M6 .5h3m2 0h2.5a1 1 0 011 1V4M.5 6v3m14-3v3m-14 2v2.5a1 1 0 001 1H4M14.5 11v2.5a1 1 0 01-1 1H11m-7-7h7m-5 7h3"></path>
					</svg><!--
					--><label for="${lastId}">
						<input type="radio" name="main_image" class="edit-new-image edit-image-set-main" id="${lastId}" value="${uploadCounter++}" /> main
					</label>
				</li>
			`;
			$("#editImageList").append($(imageRow).append(inputFile));
		});
		fileReader.readAsDataURL(file);
	};

	// NOTE: For storing the images locally.
	// Necessary for when uploading multiple files seperately
	$(document).on("change", "#uploadImage", function (e) {
		for (let i = 0; i < this.files.length; i++) {
			readUrl(this.files.item(i));
		}
	});
});
