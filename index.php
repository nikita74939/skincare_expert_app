<?php include 'includes/header.php'; ?>
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Sistem Pakar • Forward Chaining</span>
        <h1 class="display-5 fw-bold mb-3">Rekomendasi skincare berdasarkan kondisi kulit.</h1>
        <p class="lead text-muted mb-4">Jawab beberapa pertanyaan kondisi kulit, lalu sistem akan mencocokkan jawaban dengan basis pengetahuan untuk menentukan jenis kulit dan rekomendasi perawatan.</p>
        <a href="konsultasi.php" class="btn btn-rose btn-lg rounded-pill px-4">Mulai Konsultasi</a>
      </div>
      <div class="col-lg-5">
        <div class="card hero-card p-4">
          <div class="display-1 text-center">🧴</div>
          <h4 class="fw-bold text-center">SkinWise Expert</h4>
          <p class="text-center text-muted mb-0">Normal, berminyak, kering, kombinasi, atau sensitif? Sistem kecil ini siap jadi kompas perawatanmu.</p>
        </div>
      </div>
    </div>
    <div class="row g-3 mt-5">
      <div class="col-md-4"><div class="feature-card p-4"><h5>Basis Pengetahuan</h5><p class="text-muted mb-0">Gejala, jenis kulit, aturan, dan rekomendasi tersimpan di database.</p></div></div>
      <div class="col-md-4"><div class="feature-card p-4"><h5>Forward Chaining</h5><p class="text-muted mb-0">Jawaban “ya” diproses sebagai fakta untuk mencocokkan aturan.</p></div></div>
      <div class="col-md-4"><div class="feature-card p-4"><h5>Panel Admin</h5><p class="text-muted mb-0">Admin dapat mengelola data tanpa mengubah kode program.</p></div></div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
