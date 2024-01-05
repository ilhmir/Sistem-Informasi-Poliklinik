<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once("koneksi.php");

$poliId = isset($_GET['poli_id']) ? $_GET['poli_id'] : null; 
$idPoli = $_GET['poli_id'];

$dataJadwal = mysqli_query($mysqli, "SELECT dokter.nama as nama_dokter, jadwal_periksa.hari as hari, jadwal_periksa.id as id_jp, jadwal_periksa.jam_mulai as jam_mulai, jadwal_periksa.jam_selesai as jam_selesai FROM dokter INNER JOIN jadwal_periksa WHERE dokter.id_poli = $idPoli && jadwal_periksa.id_dokter = dokter.id");

if(mysqli_num_rows($dataJadwal) == 0){
    echo '<option>Tidak ada jadwal</option>';
}else{
   while($jd = mysqli_fetch_array($dataJadwal)){
       echo '<option value="' .$jd['id_jp'] . '"> Dokter '. $jd['nama_dokter'] .' - ' . $jd['hari'] . ', ' . $jd['jam_mulai'] . ' - '. $jd['jam_selesai'] .'</option>';
   }
}
?>