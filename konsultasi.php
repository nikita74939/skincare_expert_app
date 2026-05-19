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
          <p class="text-muted">Jawab pertanyaan satu per satu sesuai kondisi wajah yang paling sering kamu alami.</p>
          <div class="progress mb-4"><div id="consultProgress" class="progress-bar" style="width:0%">0%</div></div>
          <form action="proses_konsultasi.php" method="POST" id="consultForm">
            <?php foreach ($gejala as $index => $g): ?>
              <div class="question-step <?= $index === 0 ? 'active' : '' ?>" data-step="<?= e($index) ?>">
                <div class="question-item">
                  <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <span class="badge badge-soft rounded-pill px-3 py-2">Pertanyaan <?= e($index + 1) ?> dari <?= e(count($gejala)) ?></span>
                    <span class="mini-muted text-end"><?= e($g['nama_gejala']) ?></span>
                  </div>
                  <h4 class="fw-bold mb-4"><?= e($g['pertanyaan']) ?></h4>
                  <div class="answer-actions">
                    <label class="answer-choice">
                      <input class="form-check-input answer-radio" type="radio" name="jawaban[<?= e($g['id_gejala']) ?>]" value="ya" required>
                      <span>Ya</span>
                    </label>
                    <label class="answer-choice">
                      <input class="form-check-input answer-radio" type="radio" name="jawaban[<?= e($g['id_gejala']) ?>]" value="tidak" required>
                      <span>Tidak</span>
                    </label>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="mt-4 d-flex justify-content-between align-items-center gap-3">
              <button class="btn btn-outline-secondary rounded-pill px-4" type="button" id="prevQuestion">Sebelumnya</button>
              <button class="btn btn-rose rounded-pill px-4 d-none" type="submit" id="submitConsult">Lihat Hasil</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
