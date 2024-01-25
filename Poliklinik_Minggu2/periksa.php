<?php
include 'koneksi.php';

$id_daftar_poli = '';
$tgl_periksa = '';
$catatan = '';
$biaya_periksa = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $id_daftar_poli = $row['id_daftar_poli'];
        $tgl_periksa = $row['tgl_periksa'];
        $catatan = $row['catatan'];
        $biaya_periksa = $row['biaya_periksa'];
    }
    ?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
}

if (isset($_POST['simpan'])) {

    $tgl_jam_periksa = date('Y-m-d H:i:s', strtotime($_POST['tgl_jam_periksa']));

    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
            id_daftar_poli = '" . $_POST['id_daftar_poli'] . "',
            tgl_periksa = '" . $tgl_jam_periksa . "',
            catatan = '" . $_POST['catatan'] . "',
            biaya_periksa = '" . $_POST['biaya_periksa'] . "'
            WHERE
            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) 
            VALUES (
                '" . $_POST['id_daftar_poli'] . "',
                '" . $tgl_jam_periksa . "',
                '" . $_POST['catatan'] . "',
                '" . $_POST['biaya_periksa'] . "'
            )");
    }

    echo "<script> 
        document.location='index.php?page=periksa';
    </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    } else if ($_GET['aksi'] == 'ubah_status') {
        $ubah_status = mysqli_query($mysqli, "UPDATE periksa SET 
                                        status = '" . $_GET['status'] . "' 
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
        document.location='index.php?page=periksa';
    </script>";
}
?>

<div class="container">
    <div class="header">
        <h1>Periksa</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-container">
                <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="form-group">
                        <label for="inputIDDaftarPoli" class="form-label fw-bold">ID Daftar Poli</label>
                        <select class="form-control" name="id_daftar_poli">
                            <?php
                            $selected = '';
                            $daftar_poli = mysqli_query($mysqli, "SELECT * FROM daftar_poli");
                            while ($data = mysqli_fetch_array($daftar_poli)) {
                                if ($data['id'] == $id_daftar_poli) {
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                            ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['id_pasien'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                <div class="form-group">
                    <label for="inputTglJamPeriksa" class="form-label fw-bold">Tanggal dan Jam Periksa</label>
                    <input type="datetime-local" class="form-control" name="tgl_jam_periksa" id="inputTglJamPeriksa" value="<?php echo $tgl_periksa ?>" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
                </div>

                    <div class="form-group">
                        <label for="inputCatatan" class="form-label fw-bold">Catatan</label>
                        <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputBiayaPeriksa" class="form-label fw-bold">Biaya Periksa</label>
                        <input type="number" class="form-control" name="biaya_periksa" id="inputBiayaPeriksa" placeholder="Biaya Periksa" value="<?php echo $biaya_periksa ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-submit-btn" name="simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8 table-container">
            <table class="custom-table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Daftar Poli</th>
                        <th scope="col">Tanggal Periksa</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Biaya Periksa</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT periksa.*, daftar_poli.id_pasien as 'id_pasien' FROM periksa LEFT JOIN daftar_poli ON (periksa.id_daftar_poli=daftar_poli.id) ORDER BY id ASC");

                    if (!$result) {
                        die("Error: " . mysqli_error($mysqli));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $data['id_daftar_poli'] . "</td>";
                            echo "<td>" . $data['tgl_periksa'] . "</td>";
                            echo "<td>" . $data['catatan'] . "</td>";
                            echo "<td>" . $data['biaya_periksa'] . "</td>";
                            echo "<td>";
                            echo '<a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=' . $data['id'] . '">Ubah</a>';
                            echo '<a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=' . $data['id'] . '&aksi=hapus">Hapus</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No rows returned.</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
