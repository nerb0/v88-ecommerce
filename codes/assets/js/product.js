$(document).ready(function () {
	$("#productImageSub").scroll(function (e) {
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
	const getPage = (page) => {
		$.get(`/api/html/products/catalog/get/page/${page}`,
			$("#searchFilter,#catalogFilter").serialize(),
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
	setTimeout(() => getPage(1), 2000);
	$(document).on("click", ".catalog-page-btn", function (e) {
		const page = this.id;
		getPage(page);
	});
	$(document).on(
		"change keyup keydown",
		"#searchProduct, #catalogFilter input, #catalogFilter select",
		function (e) {
			getPage(1);
		}
	);

	$(document).on("submit", "#addToCartForm", function (e) {
		e.preventDefault();
		$.post(
			"/cart/add",
			$(this).serialize(),
			function (res) {
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
			function (res) {
				$("#cartTotalPrice").html(res.data.total);
				refreshToken(res.token);
			},
			"json"
		);
	};

	$(document).on("change", "#cartSelectAll", function (e) {
		if (this.checked) {
			$("#userCart input[type='checkbox']").prop("checked", "true");
		} else {
			$("#userCart input[type='checkbox']").prop("checked", "");
		}
		calculateTotalPrice();
	});
	$(document).on("change", ".cart-checkbox", function (e) {
		if (!this.checked) {
			$("#cartSelectAll").prop("checked", "");
		} else {
			let is_all_selected = true;
			$(this)
				.parent()
				.siblings()
				.find(".cart-checkbox")
				.each(function () {
					if (!this.checked) is_all_selected = false;
				});
			if (is_all_selected) $("#cartSelectAll").prop("checked", "true");
		}
		calculateTotalPrice();
	});

	$(document).on("change", ".cart-quantity", function (e) {
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
	$(document).on("click", ".cart-remove", function (e) {
		const id = this.id;
		$.get(
			`/api/html/cart/remove/${id}`,
			function (res) {
				openModal(res.data);
				calculateTotalPrice();
			},
			"json"
		);
	});

	$(document).on("submit", "#cartRemoveForm", function (e) {
		e.preventDefault();
		$.post(
			$(this).attr("action"),
			$(this).serialize(),
			function (res) {
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
			function (res) {
				$("#cartItemList").html(res.data.items);
			},
			"json"
		);
	};
	fetchCartItems();

	const updateBilling = () => {
		$("#billingAddressForm input").each(function () {
			const field = $(this).attr("data-field");
			const value = $(`input[name='shipping_${field}']`).val();
			$(this).val(value);
			if (value) $(this).parent().addClass("has-value");
		});
	}
	$(document).on("change", "#shippingAddressForm input", function (e) {
		if ($("#setSameBillingBtn").prop("checked") == true) {
			updateBilling();
		}
	});
	$(document).on("keydown keyup", "#shippingAddressForm input", function (e) {
		$(".shipping-selected").removeClass("shipping-selected");
		if ($("#setSameBillingBtn").prop("checked") == true) {
			updateBilling();
		}
	});
	$(document).on("change", "#setSameBillingBtn", function (e) {
		if (this.checked) {
			$("#billingAddressForm input").each(function () {
				$(this).attr("readonly", "");
			});
			updateBilling();
		} else {
			$("#billingAddressForm input").each(function () {
				$(this).parent().removeClass("has-value");
				$(this).removeAttr("readonly");
				$(this).val("");
			});
		}
	});

	$(document).on("click", "#checkoutAddressList .shipping-card", function (e) {
		const selected = $(".shipping-selected").attr("id");
		const id = this.id;
		if (selected != id) {
			$.get(`/api/json/user/address/get/${id}`, (res) => {
				if (res.status != 200) {
					createMessage(res.message, "error");
				} else {
					$(".shipping-selected").removeClass("shipping-selected");
					$(this).addClass("shipping-selected");
					for (const field in res.data) {
						$(`input[name='shipping_${field}']`).val(res.data[field]);
					}
					$("#shippingAddressForm input").change();
				}
			}, "json");
		}
	});
});
