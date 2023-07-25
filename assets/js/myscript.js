const flashdata = $(".flash-data").data("flashdata");
const flashdata_passlama = $(".flash-data_passlama").data("flashdata");
const flashdata_passbaru = $(".flash-data_passbaru").data("flashdata");
const flashdata_pass = $(".flash-data_pass").data("flashdata");
const flashdata_minpass = $(".flash-data_minpass").data("flashdata");
const flashdata_hp = $(".flash-data-hp").data("flashdata");
const flashdata_edit = $(".flash-data-edit").data("flashdata");
const flashdata_foto = $(".flash-data-foto").data("flashdata");

console.log(flashdata);

if (flashdata) {
  Swal.fire({
    title: "Sukses ",
    text: "Data Berhasil " + flashdata,
    icon: "success",
    confirmButtonColor: "#1A9AC6",
  });
}

//password

if (flashdata_passlama) {
  Swal.fire({
    title: "Gagal",
    text: "password Lama Salah ! ",
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_passbaru) {
  Swal.fire({
    title: "Gagal",
    text: "Password Baru Tidak Sama !",
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_pass) {
  Swal.fire({
    title: "Sukses ",
    text: "Data Berhasil Diedit",
    icon: "success",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_minpass) {
  Swal.fire({
    title: "Gagal",
    text: "Panjang Password Minimal 8 karakter !",
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_hp) {
  Swal.fire({
    title: "Gagal",
    text: "No HP Sudah Dipakai!",
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_edit) {
  Swal.fire({
    title: "Gagal",
    text: flashdata,
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}

if (flashdata_foto) {
  Swal.fire({
    title: "Gagal",
    text: flashdata_foto,
    icon: "error",
    confirmButtonColor: "#1A9AC6",
  });
}



