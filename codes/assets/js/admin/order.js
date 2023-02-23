$(document).ready(function() {
	fetch(1, "orders");
	$(document).on("change", ".order-edit-status", function(e) {
		const form = $(this).parent();
		$.post(form.attr("action"), form.serialize(), (res) => {
			const type = (res.status != 200) ? "error" :"";
			createMessage(res.message, type);
		}, "json")
	})
});
