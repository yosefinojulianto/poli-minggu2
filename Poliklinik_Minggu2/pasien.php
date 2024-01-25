<?php
include 'koneksi.php';

$nama = '';
$alamat = '';
$no_ktp = '';
$no_hp = '';
$no_rm = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_ktp = $row['no_ktp'];
        $no_hp = $row['no_hp'];
        $no_rm = $row['no_rm'];
    }
    ?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<?php
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                        nama = '" . $_POST['nama'] . "',
                                        alamat = '" . $_POST['alamat'] . "',
                                        no_ktp = '" . $_POST['no_ktp'] . "',
                                        no_hp = '" . $_POST['no_hp'] . "',
                                        no_rm = '" . $_POST['no_rm'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                                        VALUES (
                                            '" . $_POST['nama'] . "',
                                            '" . $_POST['alamat'] . "',
                                            '" . $_POST['no_ktp'] . "',
                                            '" . $_POST['no_hp'] . "',
                                            '" . $_POST['no_rm'] . "'
                                        )");
    }

    echo "<script> 
        document.location='index.php?page=pasien';
    </script>";
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    echo "<script> 
        document.location='index.php?page=pasien';
    </script>";
}
?>

<div class="container">
    <div class="header">
        <h1>Data Pasien</h1>
    </div>
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-3">
            <div class="form-container">
                <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputAlamat" class="form-label fw-bold">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputKTP" class="form-label fw-bold">Nomor KTP</label>
                        <input type="text" class="form-control" name="no_ktp" id="inputAlamat" placeholder="Nomor KTP" value="<?php echo $no_ktp ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputHP" class="form-label fw-bold">Nomor Handphone</label>
                        <input type="text" class="form-control" name="no_hp" id="inputAlamat" placeholder="Nomor Handphone" value="<?php echo $no_hp ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputRM" class="form-label fw-bold">Nomor RM</label>
                        <input type="text" class="form-control" name="no_rm" id="inputAlamat" placeholder="Nomor RM" value="<?php echo $no_rm ?>">
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
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor KTP</th>
                        <th scope="col">Nomor Handphone</th>
                        <th scope="col">Nomor RM</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM pasien ORDER BY id");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_ktp'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td><?php echo $data['no_rm'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=pasien&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
