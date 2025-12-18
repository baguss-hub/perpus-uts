<?php
session_start();
require_once '../includes/config.php';

function response($status, $msg, $data = null) {
    echo json_encode([
        'status' => $status,
        'message' => $msg,
        'data' => $data
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    response("error", "Gunakan metode GET.");
}

if (isset($_GET['id'])) {
    
    $id = intval($_GET['id']);
    $stmt = $mysqli->prepare("SELECT * FROM buku WHERE id_buku = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $buku = $stmt->get_result()->fetch_assoc();

    if (!$buku) {
        response("error", "Buku tidak ditemukan.");
    }

    $stmt2 = $mysqli->prepare("
        SELECT k.nama_kategori 
        FROM buku_kategori bk
        JOIN kategori k ON bk.id_kategori = k.id_kategori
        WHERE bk.id_buku = ?    
    ");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();

    $kategori = [];
    $stmt2->bind_result($nama);
    while ($stmt2->fetch()) {
        $kategori[] = $nama;
    }

    $data = [
        "id_buku" => $buku['id_buku'],
        "judul" => $buku['judul'],
        "penulis" => $buku['penulis'],
        "tahun_terbit" => $buku['tahun_terbit'],
        "kategori" => $kategori,
        "cover" => "http://localhost/perpus-uts/uploads/buku/".$buku['cover_buku']
    ];

    response("success", "Data buku ditemukan.", $data);
}

//buku.php <--getAllBuku
// $result = $mysqli->query("SELECT id_buku, judul, tahun_terbit, cover_buku FROM buku ORDER BY id_buku DESC");