$(document).ready(function() {
	$("#productImageSub").scroll(function(e) {
		const maxScroll = this.scrollWidth - this.clientWidth;
		if (this.scrollLeft > 10) {
			$(this).addClass("product-image-sub-left");
		} else {
			$(this).removeClass("product-image-sub-left");
		}

		if (this.scrollLeft < maxScroll - 10) {
			$(this).addClass("product-image-sub-right");
		} else {
			$(this).removeClass("product-image-sub-right");
		}
	});

	const catalogList = $("#catalogList");
	const catalogPage = $("#catalogPage");
	const catalogBottomPage = $("#catalogBottomPage");
	let filter = "";
	const getPage = (page) => {
		$.get(
			`/api/html/products/catalog/get/page/${page}`,
			filter,
			(res) => {
				catalogList.html(res.data);
				catalogPage.html(res.pages);
				catalogBottomPage.html(res.pages);
				$(`.catalog-page-btn#${page}`).siblings().removeClass("active");
				$(`.catalog-page-btn#${page}`).addClass("active");
			},
			"json"
		);
	};
	getPage(1);
	$(document).on("click", ".catalog-page-btn", function(e) {
		const page = this.id;
		getPage(page);
	});
	$(document).on(
		"change keyup keydown",
		"#searchProduct, #catalogFilter input",
		function(e) {
			filter = $("#searchFilter,#catalogFilter").serialize();
			getPage(1);
		}
	);

	$(document).on("submit", "#addToCartForm", function(e) {
		e.preventDefault();
		$.post(
			"/cart/add",
			$(this).serialize(),
			function(res) {
				let type = "error";
				if (res.status == 200) {
					if (res.data.count) $("#cartCount").html(res.data.count);
					type = "";
				}
				createMessage(res.message, type);
				refreshToken(res.token);
			},
			"json"
		);
	});

	const calculateTotalPrice = () => {
		$.post(
			"/api/json/cart/total",
			$("#userCart").serialize(),
			function(res) {
				$("#cartTotalPrice").html(res.data.total);
				refreshToken(res.token);
			},
			"json"
		);
	};

	$(document).on("change", "#cartSelectAll", function(e) {
		if (this.checked) {
			$("#userCart input[type='checkbox']").prop("checked", "true");
		} else {
			$("#userCart input[type='checkbox']").prop("checked", "");
		}
		calculateTotalPrice();
	});
	$(document).on("change", ".cart-checkbox", function(e) {
		if (!this.checked) {
			$("#cartSelectAll").prop("checked", "");
		} else {
			let is_all_selected = true;
			$(this)
				.parent()
				.siblings()
				.find(".cart-checkbox")
				.each(function() {
					if (!this.checked) is_all_selected = false;
				});
			if (is_all_selected) $("#cartSelectAll").prop("checked", "true");
		}
		calculateTotalPrice();
	});

	$(document).on("change", ".cart-quantity", function(e) {
		const token = `csrf_test_name=${$("input[name='csrf_test_name']").val()}`;
		console.log($("#userCart").serialize());
		const id = this.id;
		$.post(
			`/cart/edit/${id}`,
			`quantity=${$(this).val()}&${$("#userCart").serialize()}`,
			(res) => {
				if (res.status == 200) {
					$(`#${id}.cart-item-total-price`).text(res.data.item_total_price);
				}
				calculateTotalPrice();
				refreshToken(res.token);
			},
			"json"
		);
	});
	$(document).on("click", ".cart-remove", function(e) {
		const id = this.id;
		$.get(
			`/api/html/cart/remove/${id}`,
			function(res) {
				openModal(res.data);
				calculateTotalPrice();
			},
			"json"
		);
	});

	$(document).on("submit", "#cartRemoveForm", function(e) {
		e.preventDefault();
		$.post(
			$(this).attr("action"),
			$(this).serialize(),
			function(res) {
				console.log(res);
				$("#cartItemList").html(res.data.items);
				$("#cartCount").html(res.data.count);
				calculateTotalPrice();
				createMessage(res.message);
				closeModal();
			},
			"json"
		);
	});
	const fetchCartItems = () => {
		$.get(
			"/api/html/cart/list",
			function(res) {
				$("#cartItemList").html(res.data.items);
			},
			"json"
		);
	};
	fetchCartItems();

	const setSameBillingBtn = document.getElementById("setSameBillingBtn");
	$(setSameBillingBtn).change(function(e) {
		if (this.checked) {
			$("#billingAddressForm input").each(function() {
				const field = $(this).attr("data-field");
				const value = $(`input[name='shipping_${field}']`).val();
				$(this).val(value);
				if (value) $(this).parent().addClass("has-value");
			});
		} else {
			$("#billingAddressForm input").each(function() {
				$(this).parent().removeClass("has-value");
				$(this).val("");
			});
		}
	});
});
