<?php
require 'config/database.php';
require_once 'includes/functions.php';
$gejala = get_all($pdo, 'gejala', 'id_gejala ASC');
include 'includes/header.php';
?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="question-card p-4 p-md-5">
          <h2 class="fw-bold mb-2">Konsultasi Kondisi Kulit</h2>
          <p class="text-muted">Pilih jawaban sesuai kondisi wajah yang paling sering kamu alami.</p>
          <div class="progress mb-4"><div id="consultProgress" class="progress-bar" style="width:0%">0%</div></div>
          <form action="proses_konsultasi.php" method="POST">
            <div class="row g-3">
              <?php foreach ($gejala as $g): ?>
              <div class="col-md-6">
                <div class="question-item h-100">
                  <div class="fw-semibold mb-2"><?= e($g['id_gejala']) ?> - <?= e($g['nama_gejala']) ?></div>
                  <p class="mini-muted mb-3"><?= e($g['pertanyaan']) ?></p>
                  <div class="d-flex gap-3">
                    <label class="form-check"><input class="form-check-input answer-radio" type="radio" name="jawaban[<?= e($g['id_gejala']) ?>]" value="ya" required> Ya</label>
                    <label class="form-check"><input class="form-check-input answer-radio" type="radio" name="jawaban[<?= e($g['id_gejala']) ?>]" value="tidak" required> Tidak</label>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="mt-4 d-flex justify-content-end">
              <button class="btn btn-rose rounded-pill px-4" type="submit">Lihat Hasil</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
