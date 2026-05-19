<?php include '_header.php';
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM aturan WHERE id_aturan=?")->execute([$_GET['delete']]);
  redirect('aturan.php');
}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $pdo->prepare("INSERT IGNORE INTO aturan (id_jenis,id_gejala) VALUES (?,?)")->execute([$_POST['id_jenis'],$_POST['id_gejala']]);
  redirect('aturan.php');
}
$jenis=get_all($pdo,'jenis_kulit','id_jenis ASC'); $gejala=get_all($pdo,'gejala','id_gejala ASC');
$data=$pdo->query("SELECT a.id_aturan,jk.id_jenis,jk.nama_jenis,g.id_gejala,g.nama_gejala FROM aturan a JOIN jenis_kulit jk ON jk.id_jenis=a.id_jenis JOIN gejala g ON g.id_gejala=a.id_gejala ORDER BY jk.id_jenis,g.id_gejala")->fetchAll();
?>
<h2 class="fw-bold mb-3">Kelola Aturan Produksi</h2>
<div class="row g-4">
  <div class="col-lg-4">
    <div class="feature-card p-4">
      <h5>Tambah Aturan</h5>
      <p class="mini-muted">Format: IF gejala dipilih THEN jenis kulit tertentu.</p>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Jenis Kulit</label>
          <select class="form-select" name="id_jenis" required>
            <?php foreach($jenis as $j): ?>
              <option value="<?= e($j['id_jenis']) ?>"><?= e($j['id_jenis'].' - '.$j['nama_jenis']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Gejala</label>
          <select class="form-select" name="id_gejala" required>
            <?php foreach($gejala as $g): ?>
              <option value="<?= e($g['id_gejala']) ?>"><?= e($g['id_gejala'].' - '.$g['nama_gejala']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button class="btn btn-rose">Tambah Aturan</button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="feature-card p-4">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Jenis Kulit</th>
            <th>Gejala</th>
            <th>Aturan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data as $r): ?>
            <tr>
              <td><?= e($r['id_jenis'].' - '.$r['nama_jenis']) ?></td>
              <td><?= e($r['id_gejala'].' - '.$r['nama_gejala']) ?></td>
              <td>IF <?= e($r['nama_gejala']) ?> THEN <?= e($r['nama_jenis']) ?></td>
              <td>
                <a class="btn btn-sm btn-outline-danger confirm-delete" href="?delete=<?= e($r['id_aturan']) ?>">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '_footer.php'; ?>
