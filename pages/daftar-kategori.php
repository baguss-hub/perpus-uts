<?php
//proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}

$sql = "SELECT * FROM kategori ORDER BY id_kategori ASC";
$result = $mysqli->query($sql);
if(!$result){
    die("Querry Error: ". $mysqli->error);
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Kategori</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Kategori</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
         <a href="index.php?hal=tambah-kategori" class="btn btn-success mb-3">Tambah Katgori</a>

            <table class="table table-striped table-bordered ">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- disini perulangan -->
                    <?php $no = 1 ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $row['nama_kategori'] ?></td>
                            <td><a href="index.php?hal=ubah-kategori&id=<?php echo urlencode($row['id_kategori']); ?>" class="btn btn-warning btn-sm">ubah</a>
                            </tr>
                        <?php $no++ ?>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
