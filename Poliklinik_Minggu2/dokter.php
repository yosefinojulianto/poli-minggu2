<?php
include 'koneksi.php';

$nama = '';
$alamat = '';
$no_hp = '';
$id_poli = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli,
        "SELECT * FROM dokter 
        WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_hp = $row['no_hp'];
        $id_poli = $row['id_poli'];
    }
?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<?php
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                        nama = '" . $_POST['nama'] . "',
                                        alamat = '" . $_POST['alamat'] . "',
                                        no_hp = '" . $_POST['no_hp'] . "',
                                        id_poli = '" . $_POST['id_poli'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp, id_poli) 
        VALUES (
                                        '" . $_POST['nama'] . "',
                                        '" . $_POST['alamat'] . "',
                                        '" . $_POST['no_hp'] . "',
                                        '" . $_POST['id_poli'] . "'
                                                                            )");
    }

    echo "<script> 
    document.location='index.php?page=dokter';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    } else if ($_GET['aksi'] == 'ubah_status') {
        $ubah_status = mysqli_query($mysqli, "UPDATE dokter SET 
                                        status = '" . $_GET['status'] . "' 
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
    document.location='index.php?page=dokter';
            </script>";
}
?>

<div class="container">
    <div class="header">
        <h1>Data Dokter</h1>
    </div>
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-3">
            <div class="form-container">
                <form class="form" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">Nama Dokter</label>
                        <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputAlamat" class="form-label fw-bold">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputNo_hp" class="form-label fw-bold">Nomor Handphone</label>
                        <input type="text" class="form-control" name="no_hp" id="inputNo_hp" placeholder="Nomor Handphone" value="<?php echo $no_hp ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">Nama Poli</label>
                        <select class="form-control" name="id_poli">
                            <?php
                            $selected = '';
                            $poli = mysqli_query($mysqli, "SELECT * FROM poli");
                            while ($data = mysqli_fetch_array($poli)) {
                                $selected = ($data['id'] == $id_poli) ? 'selected="selected"' : '';
                                ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama_poli'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
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
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor Handphone</th>
                        <th scope="col">Nama Poli</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query(
                        $mysqli, "SELECT dokter.*, poli.nama_poli as 'nama_poli' FROM dokter LEFT JOIN poli  ON (dokter.id_poli=poli.id) ORDER BY id"
                    );
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
