<?php
//proteksi agar file tidak dapat diakses langsung
if(!defined('MY_APP')) {
    die('Akses langsung tidak diperbolehkan!');
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $judul = $_POST['judul']; 
    $penulis = $_POST['penulis']; 
    $penerbit = $_POST['penerbit']; 
    $tahun_terbit = $_POST['tahun_terbit']; 
    $stok = $_POST['stok']; 
    // Cover Section
    $cover_name = null;
    if(!empty($_FILES['cover']['name'])){
        $target_dir = "uploads/buku/";
        $file_name = time() . "_" . basename($_FILES['cover']['name']); // add name biar tidak bentrok
        $target_file = $target_dir . $file_name;

        // proses upload
        if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)){
            $cover_name = $file_name;
        }
    }

    // database upload 
    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok, cover_buku) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sssiis", $judul, $penulis, $penerbit, $tahun_terbit, $stok, $cover_name);

        if($stmt->execute()){
            $id_buku = $stmt->insert_id;
            // proses kategori
            if(!empty($_POST['kategori'])){
                foreach($_POST['kategori'] as $id_kategori){
                    $mysqli->query("INSERT INTO buku_kategori (id_buku, id_kategori) VALUES ($id_buku, $id_kategori)");
                }
            }

            $pesan = "Buku Berhasil Ditambahkan";
        } else {
            $pesan_error = "Buku Gagal Ditambahkan";
        }
        $stmt->close();
    }
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Buku</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Buku</li>
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
            <!-- action tidak diisi, karena ini akan dikirim ke file ini sendiri -->
            <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul Buku</label>
          <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul buku" required>
        </div>

        <!-- Kategori Disini -->
        <div class="mb-3">
            <label for="kategori" class="form-label">Pilih Kategori Buku</label><br>
            <?php
                //query kategori
                $sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
                $result_kategori = $mysqli->query($sql_kategori);

            ?>

            <?php while($kat = $result_kategori->fetch_assoc()) : ?>
            <label for="" class="me-3">
                <!-- disini pakai checkbox karena 1 buku bisa memiliki lebih dari 1 kate  -->
                <input type="checkbox" name="kategori[]" value="<?php echo $kat['id_kategori'] ?>"><?php echo $kat['nama_kategori']?></input> 
                
            </label>
            <?php endwhile; $mysqli->close(); ?>
        </div>
        <!-- Batas Kategori -->

        <div class="mb-3">
          <label for="penulis" class="form-label">Penulis Buku</label>
          <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Penulis buku" required>
        </div>
        <div class="mb-3">
          <label for="penerbit" class="form-label">Penerbit Buku</label>
          <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit buku" required>
        </div>
          <div class="col mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit Buku</label>
            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Tahun terbit buku" required>
        </div>
        <div class="col mb-3">
            <label for="stok" class="form-label">Stok Buku</label>
            <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok buku" required>
        </div>
        <!-- ini untuk upload cover -->
        <div class="col mb-4">
            <label for="cover" class="form-label">Upload Cover</label>
            <input type="file" class="form-control" id="cover" name="cover">
            <!-- disini tidak ada require karena cover opsional -->
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?hal=daftar-buku" class="btn btn-danger">Kembali</a>
        </div>
            </form>
        </div>
    </div>
</div>