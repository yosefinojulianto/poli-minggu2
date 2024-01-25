<?php
include 'koneksi.php';

$nama_poli = '';
$keterangan = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM poli WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama_poli = $row['nama_poli'];
        $keterangan = $row['keterangan'];
    }
    ?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                        nama_poli = '" . $_POST['nama_poli'] . "',
                                        keterangan = '" . $_POST['keterangan'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO poli (nama_poli, keterangan) 
                                        VALUES (
                                            '" . $_POST['nama_poli'] . "',
                                            '" . $_POST['keterangan'] . "'
                                        )");
    }
    echo "<script> 
        document.location='index.php?page=poli';
    </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
        document.location='index.php?page=poli';
    </script>";
}
?>

<div class="container">
    <div class="header">
        <h1>Poli</h1>
    </div>
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-3">
            <div class="form-container">
                <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="col">
                        <label for="inputNama" class="form-label fw-bold">Nama Poli</label>
                        <input type="text" class="form-control" name="nama_poli" id="inputNamaPoli" placeholder="Nama Poli" value="<?php echo $nama_poli ?>">
                    </div>
                    <div class="col">
                        <label for="inputKeterangan" class="form-label fw-bold">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="inputKeterangan" placeholder="Keterangan" value="<?php echo $keterangan ?>">
                    </div>
                    <div class="col">
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
                        <th scope="col">Nama Poli</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM poli");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td><?php echo $data['keterangan'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
