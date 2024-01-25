<?php
include_once("koneksi.php");

$username = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $registrationMessage = "Username sudah digunakan. Silakan coba username lain.";
    } else {
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if (mysqli_query($mysqli, $query)) {
            $registrationMessage = "Registrasi berhasil. Silakan login.";
            // header("Location: login.php");
        } else {
            $registrationMessage = "Registrasi gagal. Silakan coba lagi.";
        }
    }
}
?>
   
<!-- Main Content -->
<main role="main" class="container">
    <div class="login-text-center">
        <h1>Register</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="login-form-container">
                <form class="login-form" method="POST" action="index.php?page=register">
                    <div class="login-form-group">
                        <label for="username">Username</label>
                        <input required="" name="username" id="username" type="text" value="<?php echo $username ?>">
                    </div>
                    <div class="login-form-group">
                        <label for="password">Password</label>
                        <input required="" name="password" id="password" type="password" value="<?php echo $password ?>">
                    </div>
                    <div class="login-form-group">
                        <label for="role">Choose a role:</label>
                        <select name="role" id="role">
                            <option value="dokter">Dokter</option>
                            <option value="admin">Admin</option>
                            <option value="pasien">Pasien</option>
                        </select>
                    </div>
                    <p>Already have an account? <a href="index.php?page=login">Login</a></p>
                    <button type="submit" class="login-form-submit-btn" name="register">Register</button>
                </form>
                <?php
                if (isset($registrationMessage)) {
                    if (strpos($registrationMessage, 'berhasil') !== false) {
                        echo '<div class="alert alert-success" role="alert">' . $registrationMessage . '</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">' . $registrationMessage . '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>