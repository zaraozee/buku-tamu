<?php
// memulai session
session_start();

if(isset($_SESSION['login'])){
    header('Location: index.php');
}

require 'koneksi.php';

$error = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query cek username
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) == 1) {
        // Ambil data user
        $row = mysqli_fetch_assoc($result);

        // Cek password
    if(password_verify($password, $row['password'])) {
        // set session
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        header('Location: index.php');
        exit;
    }
    if(password_verify($password, $row['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $row['user_role']; // contoh: 'admin' atau 'operator'

    header('Location: index.php');
    exit;
    }
    
    }
    // Jika username/password salah
    $error = true;

    }


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Notifikasi Error -->
        <?php 
        if(isset($error)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Username atau password salah!
            </div>
        <?php
         endif; 
        ?>

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        <img src="assets/images/login-page.png" alt="">
                    </div>

                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>

                            <form method="post" action="" class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username ..." required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password ..." required>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                        <label class="custom-control-label" for="remember">Remember Me</label>
                                    </div>
                                </div>

                                <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>