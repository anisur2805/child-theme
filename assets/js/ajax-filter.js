(function ($) { 
	$(".cat-list_item").on("click", function () {
		$(".cat-list_item").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			type: "POST",
			url: "/wp-admin/admin-ajax.php",
			dataType: "html",
			data: {
				action: "filter_movie_reviews",
				category: $(this).data("slug"),
				type: $(this).data("type"),
			},
			success: function (res) {
				$(".project-tiles").html(res);
			},
		});
	});
})(jQuery);
