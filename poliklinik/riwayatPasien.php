<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nip'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginUser");
    exit;
}
?>
<h2 class="row mt-5" style="margin-left: 5px">Riwayat Pasien</h2>
<br>
<!-- Table-->
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Periksa</th>
            <th scope="col">No RM</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Catatan</th>
            <th scope="col">Obat</th>
            <th scope="col">Biaya</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
        <?php
        $result = mysqli_query($mysqli, "SELECT periksa.*, pasien.nama AS nama_pasien, pasien.no_rm AS no_rm, obat.nama_obat AS nama_obat, detail_periksa.id_obat AS id_obat, daftar_poli.id AS id_dapol, dokter.nama AS nama_dokter, jadwal_periksa.id_dokter AS id_dokter FROM daftar_poli, detail_periksa, pasien, obat, dokter, jadwal_periksa INNER JOIN periksa WHERE pasien.id = daftar_poli.id_pasien && detail_periksa.id_obat = obat.id && periksa.id_daftar_poli = daftar_poli.id && periksa.id = detail_periksa.id_periksa && jadwal_periksa.id_dokter = dokter.id && jadwal_periksa.id = daftar_poli.id_jadwal  && dokter.nama = '". $_SESSION['nip'] ."'");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['tgl_periksa'] ?></td>
                <td><?php echo $data['no_rm'] ?></td>
                <td><?php echo $data['nama_pasien'] ?></td>
                <td><?php echo $data['catatan'] ?></td>
                <td><?php echo $data['nama_obat'] ?></td>
                <td><?php echo $data['biaya_periksa'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>