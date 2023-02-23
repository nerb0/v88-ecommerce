const fetch = (page, field) => {
	$.get(`/api/html/${field}/get/page/${page}?${$(".admin-header").serialize()}`, (res) => {
		$("#adminList").html(res.data.list);
		$("#adminPagination").html(res.data.pagination);
	}, "json");
}
$(document).ready(function() {
	let uploadCounter = 0;
	$(document).on("click", ".admin-action", function(e) {
		const id = $(this).attr("data-product-id") || "";
		const url = $(this).attr("data-url");
		$.get(
			`${url}/${id}`,
			function(res) {
				openModal(res.data);
				$("#editImageList").sortable({
					placeholder: "edit-image-placeholder",
					handle: ".edit-image-drag",
					update: function(e) {
						// NOTE: This is to identify the index of the images
						// The variables are seperated since I can't combine the links of the already uploaded images
						// and the content from $_FILES 
						let oldImageIndex = 0;
						let newImageIndex = 0;
						let imageSortedIndex = {};
						$(".edit-image-set-main").each(function(index) {
							if ($(this).hasClass("edit-new-image")) {
								// NOTE: IGNORE!
								// This is only for the clickability of the label
								$(this).attr("id", newImageIndex);
								$(this).parent("label").attr("for", newImageIndex);

								// NOTE: This is to identify if the new image is the selected main
								$(this).attr("value", newImageIndex);

								// NOTE: This is to identify the estimated index of the image
								// based on their position
								if (!this.checked)
									imageSortedIndex[index] = { new: newImageIndex++ };
							} else if (!this.checked) imageSortedIndex[index] = { old: oldImageIndex++ };
						});
						$("#imageSort").prop("value", JSON.stringify(imageSortedIndex));
					},
				});
				// NOTE: Reset the count for the estimated id of the upload files
				// Applies to both product EDIT and ADD
				uploadCounter = 0;
			},
			"json"
		);
	});

	$(document).on("click", ".admin-page-btn", function(e) {
		fetch(this.id, $(this).attr("data-field"));
	});

	$(document).on("keyup keydown change", ".admin-header", function(e) {
		fetch(1, $(this).attr("data-field"));
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
		fileReader.addEventListener("load", function(e) {
			// NOTE: To assign its estimated id base on previous images,
			// Necessary for assigning the main picture
			let lastId = document.querySelectorAll(".edit-image-set-main");
			lastId = parseInt($(lastId[lastId.length - 1]).attr("id")) + 1 || 1;

			const name = `image${lastId}`;
			const imageRow = `
				<li class="edit-image-row">
					<svg class="edit-image-drag" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.5 3a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm-4-10a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1z"></path>
					</svg><!--
					--><img src="${e.target.result
				}" alt="image${lastId}" class="edit-image-preview" /><!--
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
	$(document).on("change", "#uploadImage", function(e) {
		for (let i = 0; i < this.files.length; i++) {
			readUrl(this.files.item(i));
		}
	});

	// For Temporarily deleting images
	$(document).on("click", ".edit-image-remove", function(e) {
		$(this).parent().remove();
	});
	
	$(document).on("click", ".submit-product-btn", function(e) {
		e.preventDefault();
		const formData = new FormData($(".product-form")[0])
		$.post({
			url: $(this).attr("data-url"),
			dataType: "json",
			processData: false,
			contentType: false,
			cache: false,
			data: formData,
			}, "json").then((res) => {
				const type = (res.status !== 200) ? "error" : "";
				createMessage(res.message, type);
				if (res.status == 200) {
					fetchProduct();
					$(".modal-close").click();
				}
			})
	});
});
