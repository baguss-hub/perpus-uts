<?php
//proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

//disini tidak menggunakan id untuk get, tetapi menggunakan id_anggota
//ini dulu yang di eksekusi
//kalau ini gagal dieksekusi maka tidak akan bisa di post
if (isset($_GET['id_anggota']) && !empty($_GET['id_anggota'])) {
    $id_anggota = $_GET['id_anggota'];
    $sql = "SELECT * FROM anggota WHERE id_anggota = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $id_anggota);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows ==  1){
                $anggota = $result->fetch_assoc();
            }else{
                //ini tidak bisa digunakan untuk header location
                echo "Data Gagal Terambil";
                exit(); 
            }
            $stmt->close();
        }
    }else{
        echo "Query Gagal";
        exit();
    }
}else{
    echo "Anggota Tidak Ditemukan";
    exit();
}


//sekarang kita ke proses ubah passsword
//baru ini
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //jika ada methode post jalankan blok ini
    $password = md5($_POST['password']); 
    // query
    $sql = "UPDATE anggota SET password = ? WHERE id_anggota = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("si", $password, $id_anggota);
        if($stmt->execute()){
            $pesan = "Password <b>".$anggota['nama_lengkap']."</b> Berhasil Di Ubah";
        }else {
            $pesan_error = "Password <b>".$anggota['nama_lengkap']."</b> Gagal Di Ubah";
        }
        
        $stmt->close();
    }
    $mysqli->close();
}



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Password</li>
    </ol>
    <?php if(!empty($pesan)) : ?>
    <div class="alert alert-success" role="alert">
        <?php echo $pesan ?>
    </div>
    <?php endif ?>

    <?php if(!empty($pesan_error)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $pesan_error  ?>
    </div>
    <?php endif ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $anggota['nama_lengkap'] ?>" placeholder="Nama Lengkap" required disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Anggota</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $anggota['email'] ?>" placeholder="Email Anggota" required disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Masukkan Password Baru Anda</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password Anggota" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?hal=daftar-anggota" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>