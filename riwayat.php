<?php
require 'config/database.php';
$stmt = $pdo->query("SELECT k.*, jk.nama_jenis FROM konsultasi k LEFT JOIN jenis_kulit jk ON jk.id_jenis=k.id_jenis_hasil ORDER BY k.tanggal_konsultasi DESC LIMIT 50");
$data = $stmt->fetchAll();
include 'includes/header.php';
?>
<section class="py-5"><div class="container"><div class="feature-card p-4"><h2 class="fw-bold mb-3">Riwayat Konsultasi</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>ID</th><th>Tanggal</th><th>Hasil</th><th>Aksi</th></tr></thead><tbody><?php foreach($data as $row): ?><tr><td><?= e($row['id_konsultasi']) ?></td><td><?= e($row['tanggal_konsultasi']) ?></td><td><?= e($row['nama_jenis'] ?? 'Tidak ditentukan') ?></td><td><a class="btn btn-sm btn-outline-secondary" href="hasil.php?id=<?= e($row['id_konsultasi']) ?>">Detail</a></td></tr><?php endforeach; ?></tbody></table></div></div></div></section>
<?php include 'includes/footer.php'; ?>
