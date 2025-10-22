<?php
include_once('templates/header.php');
include_once('koneksi.php');

// Cek apakah tombol tampilkan ditekan
if (isset($_POST['tampilkan'])) {
    $p_awal = $_POST['p_awal'];
    $p_akhir = $_POST['p_akhir'];

    // Link export ke file export-laporan.php dengan parameter tanggal
    $link = "export-laporan.php?cari=true&p_awal=$p_awal&p_akhir=$p_akhir";

    // Query data sesuai tanggal
    $buku_tamu = query("SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$p_awal' AND '$p_akhir' ");
} else {
    // Jika tidak difilter, ambil semua data
    $link = "export-laporan.php";
    $buku_tamu = query("SELECT * FROM buku_tamu ORDER BY tanggal DESC");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Tamu</h1>

    <!-- Form Filter Periode -->
    <div class="row mx-auto d-flex justify-content-center">
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <div class="font-weight-bold text-primary text-uppercase mb-1">
                                    Periode
                                </div>
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control mb-2" name="p_awal" required>
                            </div>
                            <div class="col-auto">
                                <div class="font-weight-bold text-primary mb-1">s.d</div>
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control mb-2" name="p_akhir" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="tampilkan" class="btn btn-primary mb-2">Tampilkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= $link; ?>" target="_blank" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-file-excel"></i>
                </span>
                <span class="text">Export Laporan</span>
            </a>
        </div>

        <!-- Tabel Data Tamu -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. Telp/HP</th>
                            <th>Bertemu Dengan</th>
                            <th>Kepentingan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($buku_tamu as $tamu) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $tamu['tanggal']; ?></td>
                                <td><?= $tamu['nama_tamu']; ?></td>
                                <td><?= $tamu['alamat']; ?></td>
                                <td><?= $tamu['no_hp']; ?></td>
                                <td><?= $tamu['bertemu']; ?></td>
                                <td><?= $tamu['kepentingan']; ?></td>
                                <td>
                                    <a class="btn btn-success" href="edit-tamu.php?id=<?= $tamu['id_tamu']; ?>">Ubah</a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger" href="hapus-tamu.php?id=<?= $tamu['id_tamu']; ?>">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once('templates/footer.php');
?>
