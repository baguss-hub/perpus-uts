<?php
//proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$sql = "SELECT * FROM anggota ORDER BY id_anggota DESC";
$result = $mysqli->query($sql);
if(!$result){
    die("Querry Error: ". $mysqli->error);
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Anggota</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <a href="index.php?hal=tambah-anggota" class="btn btn-primary mb-3">Tambah Anggota</a>
            <table class="table table-striped table-bordered">
                <thead class= "table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <!-- perulangan -->
                    <?php $no = 1 ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if(!empty($row['foto_profil'])) : ?>

                                    <img src="uploads/users/<?php echo $row['foto_profil'] ?>" alt="Foto Profil" width="60" height="80" style="object-fit: cover; border-radius: 5px; margin-right: 10px">
                                   <?php else :  ?>
                                        <div style="width: 60px; height: 80px; background: #ddd; border-radius: 5px; margin-right: 10px; display:flex; align-items-center; justify-content: center; color: #999;">No <br> Foto Profil</div>
                                    <?php endif ?>
                                    <div>
                                        <?php echo $row['nama_lengkap'] ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['alamat'] ?></td>
                            <td><?php echo $row['no_telepon'] ?></td>
                            <td><a href=" index.php?hal=ubah-password&id_anggota=<?php echo urlencode($row['id_anggota']); ?>" class="btn btn-primary btn-sm"><span class="fas fa-key me-1"></span> Ubah</a></td>
                        </tr>
                        <?php $no++ ?>
                        <?php endwhile; $mysqli->close(); ?>
                </tbody>
            </table> 
        </div>
    </div>
</div>