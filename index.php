<?php
session_start();

//kita pakai session admin_logged_in
if(!isset($_SESSION['admin_logged_in'])) {
    // ini artinya jika tidak ada / false $_SESSION['admin_logged_in'] maka arahkan ke login.php
    header("Location: login.php");
    exit;
}

require_once "includes/config.php";

define('MY_APP', true); //ini berfungsi untuk proteksi, ada dihalaman pages.
//jadi dashboard.php tidak dapat diakses langsung dari url: localhost/pages/dashboard.php dia harus melewati index.php
//jadi localhost/index.php?hal=dashbaard

// Untuk mendapatakan halaman 
$page = isset($_GET['hal']) ? $_GET['hal'] : 'dashboard';
// ini untuk title header. ucwords untuk merubah misal ucwords("halaman login") menjadi Halaman Login
//str_replcae digunakan untuk mereplace, misalkan str_replace("-", " ", "halaman-login") menjadi halaman login
$title = ucwords(str_replace('-', ' ', $page));
?>

<!DOCTYPE html>
<html lang="en">
    <!-- ini untuk menempatkan header.php -->
    <?php include "includes/header.php" ?>

    <body class="sb-nav-fixed">
        <!-- ini untuk navbar -->
        <?php include "includes/nav.php" ?>

        <div id="layoutSidenav">
            <!-- ini untuk sidebar -->
            <?php include "includes/sidebar.php" ?>
            <div id="layoutSidenav_content">
                <main>
                    <!-- ini untuk pemanggilan index.php?hal=dashboard  -->
                    <?php 
                    $file = "pages/" . $page . ".php";
                    // jika aada maka
                    if(file_exists($file)) {
                        // include "pages/dashboard.php"
                        include $file;
                    } else {
                        // jika tidak ada maka tampilkan ini.
                        echo "<h1 class='text-center mt-5'>Halaman tidak ditemukan!</h1>";
                    }
                    ?>
                </main>
                <!-- ini untuk footer -->
                <?php include "includes/footer.php" ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/datatables-simple-demo.js"></script>
    </body>
</html>
