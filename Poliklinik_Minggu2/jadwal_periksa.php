<?php
include 'koneksi.php';

$id_dokter = '';
$hari = '';
$jam_mulai = '';
$jam_selesai = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli,
        "SELECT * FROM jadwal_periksa 
        WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $id_dokter = $row['id_dokter'];
        $hari = $row['hari'];
        $jam_mulai = $row['jam_mulai'];
        $jam_selesai = $row['jam_selesai'];
    }
?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<?php
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                        id_dokter = '" . $_POST['id_dokter'] . "',
                                        hari = '" . $_POST['hari'] . "',
                                        jam_mulai = '" . $_POST['jam_mulai'] . "',
                                        jam_selesai = '" . $_POST['jam_selesai'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) 
        VALUES (
                                        '" . $_POST['id_dokter'] . "',
                                        '" . $_POST['hari'] . "',
                                        '" . $_POST['jam_mulai'] . "',
                                        '" . $_POST['jam_selesai'] . "'
                                                                            )");
    }

    echo "<script> 
    document.location='index.php?page=jadwal_periksa';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
    } else if ($_GET['aksi'] == 'ubah_status') {
        $ubah_status = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                        status = '" . $_GET['status'] . "' 
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
    document.location='index.php?page=jadwal_periksa';
            </script>";
}
?>

<div class="container">
    <div class="header">
        <h1>Jadwal Periksa</h1>
    </div>
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-3">
            <div class="form-container">
                <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">
                            Nama Dokter
                        </label>
                        <select class="form-control" name="id_dokter">
                            <?php
                            $selected = '';
                            $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
                            while ($data = mysqli_fetch_array($dokter)) {
                                $selected = ($data['id'] == $id_dokter) ? 'selected="selected"' : '';
                                ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputHari" class="form-label fw-bold">
                            Hari
                        </label>
                        <input type="text" class="form-control" name="hari" id="inputHari" placeholder="Hari" value="<?php echo $hari ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputJam_mulai" class="form-label fw-bold">
                            Jam Mulai
                        </label>
                        <input type="time" class="form-control" name="jam_mulai" id="inputJam_mulai" placeholder="Jam mulai" value="<?php echo $jam_mulai ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputJam_selesai" class="form-label fw-bold">
                            Jam Selesai
                        </label>
                        <input type="time" class="form-control" name="jam_selesai" id="inputJam_selesai" placeholder="Jam selesai" value="<?php echo $jam_selesai ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-submit-btn" name="simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Table -->
        <div class="col-md-8 table-container">
            <table class="custom-table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Jam Mulai</th>
                        <th scope="col">Jam Selesai</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT dp.*, p.nama as 'nama_dokter' FROM jadwal_periksa dp LEFT JOIN dokter p ON (dp.id_dokter=p.id) ORDER BY id ASC");

                    if (!$result) {
                        die("Error: " . mysqli_error($mysqli));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $data['nama_dokter'] . "</td>";
                            echo "<td>" . $data['hari'] . "</td>";
                            echo "<td>" . $data['jam_mulai'] . "</td>";
                            echo "<td>" . $data['jam_selesai'] . "</td>";
                            echo "<td>";
                            echo '<a class="btn btn-success rounded-pill px-3" href="index.php?page=jadwal_periksa&id=' . $data['id'] . '">Ubah</a>';
                            echo '<a class="btn btn-danger rounded-pill px-3" href="index.php?page=jadwal_periksa&id=' . $data['id'] . '&aksi=hapus">Hapus</a>';
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
