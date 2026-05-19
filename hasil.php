<?php
require 'config/database.php';
require_once 'includes/functions.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT k.*, jk.nama_jenis, jk.deskripsi FROM konsultasi k LEFT JOIN jenis_kulit jk ON jk.id_jenis = k.id_jenis_hasil WHERE k.id_konsultasi=?");
$stmt->execute([$id]);
$konsultasi = $stmt->fetch();
if (!$konsultasi) die('Data konsultasi tidak ditemukan.');

$stmt = $pdo->prepare("SELECT g.id_gejala, g.nama_gejala, d.jawaban FROM detail_konsultasi d JOIN gejala g ON g.id_gejala=d.id_gejala WHERE d.id_konsultasi=? ORDER BY g.id_gejala");
$stmt->execute([$id]);
$detail = $stmt->fetchAll();

$selected = array_column(array_filter($detail, fn($d) => $d['jawaban'] === 'ya'), 'id_gejala');
$hasil = forward_chaining($pdo, $selected);
include 'includes/header.php';
?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="result-card p-4 p-md-5">
          <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Hasil Konsultasi #<?= e($id) ?></span>
          <?php if ($hasil): ?>
          <h2 class="fw-bold">Jenis Kulit: <span class="text-rose"><?= e($hasil['nama_jenis']) ?></span></h2>
          <p class="text-muted"><?= e($hasil['deskripsi']) ?></p>
          <div class="mb-4">
            <div class="d-flex justify-content-between"><strong>Tingkat Kecocokan Aturan</strong><span><?= e($hasil['persentase']) ?>%</span></div>
            <div class="progress"><div class="progress-bar" style="width:<?= e($hasil['persentase']) ?>%"></div></div>
            <small class="text-muted"><?= e($hasil['jumlah_cocok']) ?> dari <?= e($hasil['total_gejala']) ?> gejala pada aturan cocok dengan jawaban kamu.</small>
          </div>
          <?php $r = $hasil['rekomendasi']; if ($r): ?>
          <div class="row g-3">
            <div class="col-md-6"><div class="p-3 bg-light rounded-4 h-100"><h6>Kandungan Disarankan</h6><p><?= nl2br(e($r['kandungan_disarankan'])) ?></p></div></div>
            <div class="col-md-6"><div class="p-3 bg-light rounded-4 h-100"><h6>Produk Disarankan</h6><p><?= nl2br(e($r['produk_disarankan'])) ?></p></div></div>
            <div class="col-md-6"><div class="p-3 bg-light rounded-4 h-100"><h6>Kandungan Dihindari</h6><p><?= nl2br(e($r['kandungan_dihindari'])) ?></p></div></div>
            <div class="col-md-6"><div class="p-3 bg-light rounded-4 h-100"><h6>Tips Perawatan</h6><p><?= nl2br(e($r['tips_perawatan'])) ?></p></div></div>
          </div>
          <?php endif; ?>
          <?php else: ?>
          <h2 class="fw-bold">Hasil belum dapat ditentukan</h2>
          <p class="text-muted">Tidak ada gejala yang dipilih sebagai “ya”, sehingga sistem belum memiliki fakta untuk diproses.</p>
          <?php endif; ?>
          <hr class="my-4">
          <h5>Jawaban yang Dipilih “Ya”</h5>
          <div class="d-flex flex-wrap gap-2 mb-4">
            <?php foreach ($detail as $d): if ($d['jawaban'] === 'ya'): ?>
              <span class="badge rounded-pill text-bg-light border"><?= e($d['id_gejala']) ?> - <?= e($d['nama_gejala']) ?></span>
            <?php endif; endforeach; ?>
          </div>
          <a href="konsultasi.php" class="btn btn-outline-secondary rounded-pill">Konsultasi Lagi</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
