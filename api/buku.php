<?php
session_start(); 
require_once '../includes/config.php';

//buat fungsi untuk respon json

function response($status, $msg, $data = null) {
    //format response yang akan kita kirim ke client (android app)
    echo json_encode([
        'status' => $status,
        'message' => $msg,
        'data' => $data
    ]);
    exit; // ini untuk menghentikan semua proses
}

//pastikan semua method yg digunakan adalah GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    response("error", "Gunakan metode GET.");
}

$result = $mysqli->query("SELECT id_buku, judul, penulis, cover_buku FROM buku ORDER BY id_buku DESC");

$daftar = [];
while ($row = $result->fetch_assoc()) {
    $daftar[] = [
        "id_buku" => $row['id_buku'],
        "judul" => $row['judul'],
        "penulis" => $row['penulis'],
        "cover" => "http://192.168.100.7/perpus-uts/uploads/buku/".$row['cover_buku']
    ];  
}
response("success", "Daftar buku ditemukan.", $daftar);
//sekarang kita bisa bisa mencoba rest api yang kita buat


// response("success", "Data buku ditemukan.", $data);
//buku.php <--getAllBuku
// $result = $mysqli->query("SELECT id_buku, judul, tahun_terbit, cover_buku FROM buku ORDER BY id_buku DESC");