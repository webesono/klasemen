$(document).ready(function () {
	// var ip = $('#ip').val();
	table2 = $("#clubTable").DataTable({
		responsive: true,
		ajax: `klasemen/getClub`,
		columns: [
			{
				data: "no",
			},
			{
				data: "club",
			},
			{
				data: "play",
			},
			{
				data: "win",
			},
			{
				data: "draw",
			},
			{
				data: "lose",
			},
			{
				data: "goal_win_num",
			},
			{
				data: "goal_lose_num",
			},
			{
				data: "point_num",
			},
		],
	});

	$(document).off("click", "#addClub");
	$(document).on("click", "#addClub", function () {
		$("#errName").text("");
		$("#errCity").text("");
		$("#jdlModelClub").text("Tambah Club Baru");
		$(".aksiClub").text("Tambah");
		// $("#iC").val("");
		$("#ClubModal").modal("show");
		$("#formClub")[0].reset();
	});

	$(document).off("click", "#addMatch");
	$(document).on("click", "#addMatch", function () {
		$("#jdlModelMatch").text("Tambah Match Baru");
		$(".aksiMatch").text("Tambah");
		// $("#iC").val("");
		$("#MatchModal").modal("show");
		$("#formModal")[0].reset();
	});

	$(document).off("click", ".aksiClub");
	$(document).on("click", ".aksiClub", function () {
		$("#errName").text("");
		// $("#errCopy").text("");
		$("#errStatus").text("");

		var data = $("#formClub").serialize();
		// console.log(data);
		$.ajax({
			type: "POST",
			url: `klasemen/aksiClub`,
			data: data,
			dataType: "JSON",
			success: function (response) {
				if (response.success) {
					Swal.fire({
						// position: 'top-end',
						icon: "success",
						text: response.message,
						showConfirmButton: false,
						timer: 2000,
					});
					$("#ClubTable").DataTable().ajax.reload();
					$("#ClubModal").modal("hide");
				} else {
					var error = response.message;
					// console.log(error.kurikulum);
					if (error.alert_type == "swal") {
						Swal.fire({
							// position: 'top-end',
							icon: "error",
							text: error.message,
							showConfirmButton: false,
							timer: 2000,
						});
					} else {
						$("#errName").text(error.name_error);
						$("#errCity").text(error.city_error);
					}
					// $("#errCopy").text(error.copy_error);
				}
			},
		});
	});

	$(document).on("click", "#remove_match", function (e) {
		e.preventDefault();
		let listNoLain = $(this).parent().parent();
		$(listNoLain).remove();
	});

	$("#formMatch").on("submit", function (e) {
		e.preventDefault(); //'return false' is deprecated according to jQuery documentation, use this instead.

		$(".match").css({
			border: "",
			"border-radius": "",
		});
		$.ajax({
			url: "klasemen/postMatch",
			type: "POST",
			data: $(this).serialize(),
			dataType: "JSON",
			success: function (response) {
				if (response.success) {
					Swal.fire({
						// position: 'top-end',
						icon: "success",
						text: response.message,
						showConfirmButton: false,
						timer: 2000,
					});
					$("#ClubTable").DataTable().ajax.reload();
					$("#MatchModal").modal("hide");
				} else {
					var error = response.message;
					if (error.target != null) {
						$(`${error.target}`).css({
							border: "2px solid red",
							"border-radius": "5px",
						});
					}
					Swal.fire({
						// position: 'top-end',
						icon: "error",
						text: error.message,
						showConfirmButton: false,
						timer: 2000,
					});
				}
			},
		});
	});
});
