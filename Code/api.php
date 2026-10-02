<?php
header('Content-Type: application/json');

$host = 'bapenda-db';
$db   = 'db_bapenda_pajak';
$user = 'bapenda_admin';
$pass = 'pajakJatim2026!';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("
        SELECT no_transaksi, jenis_pajak, status_pembayaran,
               pgp_sym_decrypt(nik_encrypted, 'bapenda_sec_key') AS nik_decoded
        FROM wajib_pajak
    ");
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => "Koneksi database gagal: " . $e->getMessage()]);
}
?>