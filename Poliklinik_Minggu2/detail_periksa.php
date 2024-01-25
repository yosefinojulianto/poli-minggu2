<?php
include 'koneksi.php';

$id_periksa = '';
$id_obat = '';

if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM detail_periksa WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $id_periksa = $row['id_periksa'];
        $id_obat = $row['id_obat'];
    ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE detail_periksa SET 
                                        id_periksa = '" . $_POST['id_periksa'] . "',
                                        id_obat = '" . $_POST['id_obat'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO detail_periksa (id_periksa, id_obat) 
                                        VALUES (
                                            '" . $_POST['id_periksa'] . "',
                                            '" . $_POST['id_obat'] . "'
                                        )");
    }

    echo "<script> 
            document.location='index.php?page=detail_periksa';
          </script>";
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $hapus = mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id = '" . $_GET['id'] . "'");
    
    echo "<script> 
            document.location='index.php?page=detail_periksa';
          </script>";
}
?>
<div class="container">
    <div class="header">
        <h1>Detail Periksa</h1>
    </div>
    <div class="row">
        <!-- Form Input -->
        <div class="col-md-3">
            <div class="form-container">
                <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">
                            Id Periksa
                        </label>
                        <select class="form-control" name="id_periksa">
                            <?php
                            $selected = '';
                            $periksa = mysqli_query($mysqli, "SELECT * FROM Periksa");
                            while ($data = mysqli_fetch_array($periksa)) {
                                $selected = ($data['id'] == $id_periksa) ? 'selected="selected"' : '';
                                ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['biaya_periksa'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputNama" class="form-label fw-bold">
                            Obat
                        </label>
                        <select class="form-control" name="id_obat">
                            <?php
                            $selected = '';
                            $obat = mysqli_query($mysqli, "SELECT * FROM obat");
                            while ($data = mysqli_fetch_array($obat)) {
                                $selected = ($data['id'] == $id_obat) ? 'selected="selected"' : '';
                                ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['harga'] ?></option>
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
                        <th scope="col">Periksa</th>
                        <th scope="col">Obat</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT detail_periksa.*, periksa.biaya_periksa as 'biaya_periksa', obat.harga as 'harga' FROM detail_periksa LEFT JOIN periksa ON (detail_periksa.id_periksa=periksa.id) LEFT JOIN obat ON (detail_periksa.id_obat=obat.id) ORDER BY id ASC");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                        $total_biaya = $data['biaya_periksa'] + $data['harga'];
                    ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $data['biaya_periksa'] ?></td>
                            <td><?php echo $data['harga'] ?></td>
                            <td><?php echo $total_biaya ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=detail_periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=detail_periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
