<?php include '_header.php';
$counts=[]; foreach(['gejala','jenis_kulit','aturan','rekomendasi','konsultasi'] as $t){$counts[$t]=$pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();}
?>
<h2 class="fw-bold mb-4">Dashboard</h2><div class="row g-3"><?php foreach($counts as $k=>$v): ?><div class="col-md-4"><div class="feature-card p-4"><div class="mini-muted"><?= e(ucwords(str_replace('_',' ',$k))) ?></div><div class="display-6 fw-bold text-rose"><?= e($v) ?></div></div></div><?php endforeach; ?></div><div class="alert alert-info mt-4">Panel ini dipakai untuk mengelola knowledge base: gejala/kondisi, jenis kulit, aturan produksi, dan rekomendasi.</div>
<?php include '_footer.php'; ?>
