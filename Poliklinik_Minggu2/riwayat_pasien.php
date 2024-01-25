<?php
include 'koneksi.php';

$id_pasien = '';
$id_jadwal = '';
$keluhan = '';
$no_antrian = '';
$id_daftar_poli = '';
$tgl_periksa = '';
$catatan = '';
$biaya_periksa = '';

if (isset($_GET['id'])) {
    $ambil_daftar_poli = mysqli_query($mysqli, "SELECT * FROM daftar_poli WHERE id='" . $_GET['id'] . "'");
    while ($row_daftar_poli = mysqli_fetch_array($ambil_daftar_poli)) {
        $id_pasien = $row_daftar_poli['id_pasien'];
        $id_jadwal = $row_daftar_poli['id_jadwal'];
        $keluhan = $row_daftar_poli['keluhan'];
        $no_antrian = $row_daftar_poli['no_antrian'];
    }

    $ambil_periksa = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id_daftar_poli='" . $_GET['id'] . "'");
    while ($row_periksa = mysqli_fetch_array($ambil_periksa)) {
        $id_daftar_poli = $row_periksa['id_daftar_poli'];
        $tgl_periksa = $row_periksa['tgl_periksa'];
        $catatan = $row_periksa['catatan'];
        $biaya_periksa = $row_periksa['biaya_periksa'];
    }
    ?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
}
?>
<div class="container">
    <div class="header">
        <h1>Riwayat Pasien</h1>
    </div>
    <div class="row">
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <br>
            <br>
            <!-- Table-->
            <table class="custom-table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">ID Jadwal</th>
                        <th scope="col">Keluhan</th>
                        <th scope="col">No Antrian</th>
                        <th scope="col">ID Daftar Poli</th>
                        <th scope="col">Tanggal Periksa</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Biaya Periksa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "
                        SELECT dp.*, p.nama as 'nama_pasien', p.id as 'id_pasien', pr.*
                        FROM daftar_poli dp
                        LEFT JOIN pasien p ON dp.id_pasien = p.id
                        LEFT JOIN periksa pr ON dp.id = pr.id_daftar_poli
                        ORDER BY dp.id ASC");

                    if (!$result) {
                        die("Error: " . mysqli_error($mysqli));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . (isset($data['nama_pasien']) ? $data['nama_pasien'] : '') . "</td>";
                            echo "<td>" . (isset($data['id_jadwal']) ? $data['id_jadwal'] : '') . "</td>";
                            echo "<td>" . (isset($data['keluhan']) ? $data['keluhan'] : '') . "</td>";
                            echo "<td>" . (isset($data['no_antrian']) ? $data['no_antrian'] : '') . "</td>";
                            echo "<td>" . (isset($data['id_daftar_poli']) ? $data['id_daftar_poli'] : '') . "</td>";
                            echo "<td>" . (isset($data['tgl_periksa']) ? $data['tgl_periksa'] : '') . "</td>";
                            echo "<td>" . (isset($data['catatan']) ? $data['catatan'] : '') . "</td>";
                            echo "<td>" . (isset($data['biaya_periksa']) ? $data['biaya_periksa'] : '') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No rows returned.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
