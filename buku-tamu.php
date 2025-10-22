<?php
require_once('function.php');
include_once('templates/header.php');

// hanya operator yang boleh akses buku-tamu.php
if($_SESSION['role'] != 'operator'){
    echo "<script>alert('Anda tidak memiliki akses');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

<?php
// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    if (tambah_tamu($_POST) > 0) {
?>
        <div class="alert alert-success" role="alert">
            Data berhasil disimpan!
        </div>
<?php
    } else {
?>
        <div class="alert alert-danger" role="alert">
            Data gagal disimpan!
        </div>
<?php
    }
}
?>

                    <!-- DataTables Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
                </span>
                <span class="text">Data Tamu</span>
        </button>
    </div>
    <div class="card-body">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal/th>
                                            <th>Nama Tamu</th>
                                            <th>Alamat</th>
                                            <th>No. Telp/HP</th>
                                            <th>Bertemu Dengan</th>
                                            <th>Kepentingan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    <tbody>
                                        <?php
                                        // penomoran auto-increment
                                        $no = 1;
                                        // Query untuk memanggil semua data dari tabel buku_tamu
                                        $buku_tamu = query("SELECT * FROM buku_tamu");
                                        foreach($buku_tamu as $tamu) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $tamu['tanggal'] ?></td>
                                            <td><?= $tamu['nama_tamu'] ?></td>
                                            <td><?= $tamu['alamat'] ?></td>
                                            <td><?= $tamu['no_hp'] ?></td>
                                            <td><?= $tamu['bertemu'] ?></td>
                                            <td><?= $tamu['kepentingan'] ?></td>
                                            <td>
                                                <a class="btn btn-success" href="edit-tamu.php?id=<?= $tamu['id_tamu']?>">Ubah</a>
                                                <a onclick="confirm('Apakah anda ingin menghapus data ini?')" class="btn btn-danger" 
                                                href="hapus-tamu.php?id=<?=  $tamu['id_tamu']?>">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
 <!-- Page level plugins -->
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/datatables-demo.js"></script>
</div>
<?php
    // mengambil data tamu dari tabel dengan kode terbesar
    $query = mysqli_query($koneksi, "SELECT MAX(id_tamu) as kodeTerbesar FROM buku_tamu");
    $data = mysqli_fetch_array($query);
    $kodeTamu = $data['kodeTerbesar'];
    
    // jika tidak ada data, set kode awal
    if(empty($kodeTamu)) {
        $urutan = 0;
    } else {
        // mengambil angka dari kode tamu terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
        $urutan = (int) substr($kodeTamu, 2, 3);
    }
    
    // nomor yang diambil akan ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membuat kode tamu baru
    // string sprintf("%03s", $urutan); berfungsi untuk membuat string menjadi 3 karakter
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya rt
    $huruf = 'rt';
    $kodeTamu = $huruf . sprintf("%03s", $urutan);
?>

<?php
// Mengambil data tamu dari tabel dengan id_tamu terbesar
$query = mysqli_query($koneksi, "SELECT max(id_tamu) as kodeTerbesar FROM buku_tamu");
$data = mysqli_fetch_array($query);
$kodeTamu = $data['kodeTerbesar'];

// Mengambil angka dari kode tamu terbesar, menggunakan substr dan ubah ke integer
$urutan = (int) substr($kodeTamu, 2, 3); // Misalnya dari "ZT001" ambil "001"

// Tambah 1 untuk nomor urut berikutnya
$urutan++;

// Format ulang menjadi 3 digit, misalnya "002"
$huruf = "zt";
$kodeTamu = $huruf . sprintf("%03s", $urutan);
?>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
  <form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_tamu" id="id_tamu" value="<?= $kodeTamu ?>" />

    <div class="form-group row">
      <label for="nama_tamu" class="col-sm-3 col-form-label">Nama Tamu</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" />
      </div>
    </div>

    <div class="form-group row">
      <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
      <div class="col-sm-8">
        <textarea class="form-control" id="alamat" name="alamat"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="no_hp" class="col-sm-3 col-form-label">No. Telepon</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="no_hp" name="no_hp" />
      </div>
    </div>

    <div class="form-group row">
      <label for="bertemu" class="col-sm-3 col-form-label">Bertemu dg.</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="bertemu" name="bertemu" />
      </div>
    </div>

    <div class="form-group row">
      <label for="kepentingan" class="col-sm-3 col-form-label">Kepentingan</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="kepentingan" name="kepentingan" />
      </div>
    </div>

    <div class="form-group row">
      <label for="gambar" class="col-sm-3 col-form-label">Unggah Foto</label>
      <div class="custom-file col-sm-8">
        <input type="file" class="custom-file-input" id="gambar" name="gambar" />
        <label class="custom-file-label" for="gambar">Choose file</label>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    </div>
  </form>
</div>

<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>