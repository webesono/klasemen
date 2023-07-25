<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- jika menggunakan bootstrap4 gunakan css ini  -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

<!-- Modal Data Club -->
<div class="modal fade" id="ClubModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jdlModelClub">Tambah Club</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formClub">
                    <!-- <input type="hidden" class="form-control" name="ref_file_old" id="ref_file_old" value=""> -->
                    <input type="hidden" class="form-control" name="iC" id="iC" value="">
                    <div>
                        <label for="">Nama Club <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama club" aria-describedby="basic-addon1">
                        <small class="text-danger" id="errName"></small>
                    </div>
                    <div>
                        <label for="">Kota<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Masukkan nama kota" aria-describedby="basic-addon1">
                        <small class="text-danger" id="errCity"></small>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="" class="btn btn-primary aksiClub">Tambah</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Data Match -->
<div class="modal fade" id="MatchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jdlModelMatch">Tambah Match</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formMatch">
                    <input id="countMatch" type="hidden" value='0'>
                    <div class="match0 d-flex justify-content-between match" style="margin-bottom: 3px;">
                        <div class="playerPertama">
                            <div>
                                <label for="">Nama Club <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="match[0][player1][club]" id="match[0][player1][club]">
                                    <option value="">--pilih--</option>
                                    <?php foreach ($clubs as $club) : ?>
                                        <option value="<?= $club['id'] ?>"><?= $club['club_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="">Score<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="match[0][player1][goal]" name="match[0][player1][goal]" placeholder="masukkan score pertandingan" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <h1>VS</h1>
                        </div>
                        <div class="playerKedua">
                            <div>
                                <label for="">Nama Club <span class="text-danger">*</span></label>
                                <select class="form-select form-control" name="match[0][player2][club]" id="match[0][player2][club]">
                                    <option value="">--pilih--</option>
                                    <?php foreach ($clubs as $club) : ?>
                                        <option value="<?= $club['id'] ?>"><?= $club['club_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="">Score<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="match[0][player2][goal]" name="match[0][player2][goal]" placeholder="masukkan score" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div id="ac_match" class="d-flex justify-content-between mt-3">
                        <button id="add_match" type="button" class="btn btn-success">
                            Add
                        </button>
                        <button id="save_match" type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<style>
    /* a {
        color: inherit;
        text-decoration: inherit;
    } */

    button {
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }

    .w-fit {
        width: -moz-fit-content;
        width: fit-content;
    }

    .h-fit {
        height: -moz-fit-content;
        height: fit-content;
    }

    .m-5 {
        margin: 1.25rem;
    }

    .flex {
        display: flex;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .items-center {
        align-items: center;
    }

    .justify-center {
        justify-content: center;
    }

    .text-center {
        text-align: center;
    }

    .border-b-2 {
        border-bottom-width: 2px;
    }

    .w-full {
        width: 100%;
    }

    .h-\[114px\] {
        height: 114px;
    }

    .w-\[114px\] {
        width: 114px;
    }

    .rounded-full {
        border-radius: 9999px;
    }
</style>


<!-- DataTables Club -->

<div class="w-full">
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive" style="margin:10px;">
            <div class="d-flex gap-3">
                <button style="float: left;" type="button" class="btn btn-primary" id="addClub">
                    <i class="fa fa-lg fa-fw fa-plus" aria-hidden="true"></i>Tambah Klub
                </button>
                <button style="float: left;" type="button" class="btn btn-danger" id="addMatch">
                    <i class="fa fa-lg fa-fw fa-plus" aria-hidden="true"></i>Tambah Pertandingan
                </button>
            </div>
            <table class="table table-hover table-striped align-middle" id="clubTable" style="width: 100%;max-width:100%;">
                <thead class="">
                    <tr>
                        <th>No</th>
                        <th>Klub</th>
                        <th>Main</th>
                        <th>Menang</th>
                        <th>Seri</th>
                        <th>Kalah</th>
                        <th>Goal Menang</th>
                        <th>Goal Kalah</th>
                        <th>Point</th>
                    </tr>
                </thead>
                <tbody id="tbl_data">

                </tbody>
            </table>
            <!-- Paginate -->
            <div class="pagination"></div>
        </div>
    </div>
</div>


<!-- </div> -->
<!-- </div> -->


<script src="<?= base_url('assets/js/index.js'); ?>"></script>
<script src="<?= base_url('assets/js/slick.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/landingpage.js'); ?>"></script>
<script src="<?= base_url('assets/js/match.js'); ?>"></script>

<script>
    $("#add_match").off("click");
    $(document).on("click", "#add_match", function(e) {
        e.preventDefault();
        $("#countMatch").val(parseInt($("#countMatch").val()) + 1);
        var count = $("#countMatch").val();

        $(
            "#ac_match"
        ).before(`<div class="row "><div class="match${count} d-flex justify-content-between match" style="margin-bottom: 3px;">
		<div class="player1">
			<div>
				<label for="">Nama Club <span class="text-danger">*</span></label>
				<select class="form-select form-control" name="match[${count}][player1][club]" id="match[${count}][player1][club]">
					<option value="">--pilih--</option>
					<?php foreach ($clubs as $club) : ?>
						<option value="<?= $club['id'] ?>"><?= $club['club_name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="">Score<span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="match[${count}][player1][goal]" name="match[${count}][player1][goal]" placeholder="masukkan score pertandingan" aria-describedby="basic-addon1">
			</div>
		</div>
		<div class="d-flex align-items-center">
			<h1>VS</h1>
		</div>
		<div class="player2">
			<div>
				<label for="">Nama Club <span class="text-danger">*</span></label>
				<select class="form-select form-control" name="match[${count}][player2][club]" id="match[${count}][player2][club]">
					<option value="">--pilih--</option>
					<?php foreach ($clubs as $club) : ?>
                                        <option value="<?= $club['id'] ?>"><?= $club['club_name'] ?></option>
                                    <?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="">Score<span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="match[${count}][player2][goal]" name="match[${count}][player2][goal]" placeholder="masukkan score pertandingan" aria-describedby="basic-addon1">
			</div>
		</div>
	</div>
	      <div class="col-auto">
	        <button type="button" id="remove_match" class="btn btn-danger"><i class="fa-solid fa-xmark fs-6"></i></button>
	      </div></div>`);
    });
</script>