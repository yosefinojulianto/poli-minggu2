<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once("koneksi.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Data Master</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="index.php?page=pasien">Pasien</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=dokter">Dokter</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=poli">Poli</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=periksa">Periksa</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=obat">Obat</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=daftar_pasien">Daftar Pasien</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=riwayat_pasien">Riwayat Pasien</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=daftar_poli">Daftar Poli</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=detail_periksa">Detail Periksa</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?page=jadwal_periksa">Jadwal Periksa</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION['username'])) {
                    ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username'] ?>)</a>
                        </li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=login">Login</a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <main role="main" class="container">
        <div style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('img/spidey.png'); background-size: cover; background-position: center;">
            <p style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 25px; text-align: center; color: black; text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">
                With Great Power Comes Great Responsibility - Uncle Ben<br>
                Spider Gwen punya Roja
            </p>
        </div>
        <?php
                if (isset($_GET['page'])) {
                    include($_GET['page'] . ".php");
                } else {
                    echo "<br><h2>Selamat Datang di Sistem Informasi Poliklinik";

                    if (isset($_SESSION['username'])) {
                        echo ", " . $_SESSION['username'] . "</h2><hr>";
                    } else {
                        echo "</h2><hr>Silakan Login untuk menggunakan sistem. Jika belum memiliki akun silakan Register terlebih dahulu.";
                    }
                }
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>