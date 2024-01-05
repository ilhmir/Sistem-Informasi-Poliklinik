<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once("koneksi.php");

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'selesai') {
           echo "<script> 
                       document.location='index.php?page=poli';
                       </script>";
    }
}
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px; background-color: green; color: white">Pendaftaran Berhasil!</div>
                <div class="card-body">
                    <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp = '". $_GET['no_ktp'] ."'");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {        
                    ?>
                    <div class="form-group text-center">
                       <label for="inputNama" class="form-label fw-bold">
                           Nama :
                       </label>
                       </br>
                       <td class="form-label fw-bold"><?php echo $data['nama'] ?></td>
                    </div>
                    </br>
                    <div class="form-group text-center">
                       <label for="inputNama" class="form-label fw-bold">
                           Alamat :
                       </label>
                       </br>
                       <td class="form-label fw-bold"><?php echo $data['alamat'] ?></td>
                    </div>
                    </br>
                    <div class="form-group text-center">
                       <label for="inputNama" class="form-label fw-bold">
                           No HP :
                       </label>
                       </br>
                       <td class="form-label fw-bold"><?php echo $data['no_hp'] ?></td>
                    </div>
                    </br>
                    <div class="form-group text-center">
                       <label for="inputNama" class="form-label fw-bold">
                           No Rekam Medis (RM) :
                       </label>
                       </br>
                       <td class="form-label fw-bold"><?php echo $data['no_rm'] ?></td>
                    </div>
                    </br>
                    <div class="text-center">
                         <td>
                             <a class="btn btn-success rounded-pill px-5" href="index.php?page=poliklinik">Selesai</a>
                         </td>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>