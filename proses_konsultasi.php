<?php
require 'config/database.php';
require 'includes/functions.php';

$jawaban = $_POST['jawaban'] ?? [];
$selected = array_keys(array_filter($jawaban, fn($v) => $v === 'ya'));
$hasil = forward_chaining($pdo, $selected);

$pdo->beginTransaction();
$stmt = $pdo->prepare("INSERT INTO konsultasi (id_user, id_jenis_hasil) VALUES (NULL, ?)");
$stmt->execute([$hasil['id_jenis'] ?? null]);
$id_konsultasi = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO detail_konsultasi (id_konsultasi, id_gejala, jawaban) VALUES (?, ?, ?)");
foreach ($jawaban as $id_gejala => $nilai) {
    $stmt->execute([$id_konsultasi, $id_gejala, $nilai]);
}
$pdo->commit();

redirect('hasil.php?id=' . $id_konsultasi);
?>
