<?php
//proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama_lengkap = $_POST['nama_lengkap']; 
    $alamat = $_POST['alamat']; 
    $no_telepon = $_POST['no_telepon']; 
    $email = $_POST['email']; 
    $password = md5($_POST['password']);  
    // Cover Section
    $foto_profil = null;
    if(!empty($_FILES['foto_profil']['name'])){
        $target_dir = "uploads/users/";
        $file_name = time() . "_" . basename($_FILES['foto_profil']['name']); // add name biar tidak bentrok
        $target_file = $target_dir . $file_name;

        // proses upload
        if(move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)){
            $foto_profil = $file_name;
        }
    }

    // database upload 
    $sql = "INSERT INTO anggota (nama_lengkap, email, password, alamat, no_telepon, foto_profil) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("ssssss", $nama_lengkap, $email, $password, $alamat, $no_telepon, $foto_profil);

        if($stmt->execute()){
            $pesan = "Anggota Dengan Nama <b>". $nama_lengkap ."</b> Berhasil Ditambahkan";
        } else {
            $pesan_error = "Anggota Dengan Nama <b>". $nama_lengkap ."</b> Gagal Ditambahkan";
        }
        $stmt->close();
    }
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Anggota</li>
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
            <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap Anggota" required>
        </div>
        <div class="col mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Anggota" required>
        </div>
        <div class="mb-3">
          <label for="no_telepon" class="form-label">No Telepon</label>
          <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Nomor Telepon" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email Anggota" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password Anggota" required>
        </div>
        <div class="col mb-4">
            <label for="foto_profil" class="form-label">Upload Foto Profil</label>
            <input type="file" class="form-control" id="foto_profil" name="foto_profil">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?hal=daftar-anggota" class="btn btn-danger">Kembali</a>
        </div>
            </form>
        </div>
    </div>
</div>