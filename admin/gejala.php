<?php include '_header.php';
$edit = null;
if (isset($_GET['delete'])) {
  $pdo->prepare("DELETE FROM gejala WHERE id_gejala=?")->execute([$_GET['delete']]);
  redirect('gejala.php');
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $data = [$_POST['id_gejala'], $_POST['nama_gejala'], $_POST['pertanyaan']];
  if ($_POST['mode']==='edit') {
    $pdo->prepare("UPDATE gejala SET nama_gejala=?, pertanyaan=? WHERE id_gejala=?")->execute([$_POST['nama_gejala'], $_POST['pertanyaan'], $_POST['id_gejala']]);
  } else {
    $pdo->prepare("INSERT INTO gejala (id_gejala,nama_gejala,pertanyaan) VALUES (?,?,?)")->execute($data);
  }
  redirect('gejala.php');
}
if (isset($_GET['edit'])) {
  $stmt=$pdo->prepare("SELECT * FROM gejala WHERE id_gejala=?");
  $stmt->execute([$_GET['edit']]);
  $edit=$stmt->fetch();
}
$data = get_all($pdo,'gejala','id_gejala ASC');
?>
<h2 class="fw-bold mb-3">Kelola Gejala/Kondisi Kulit</h2>
<div class="row g-4">
  <div class="col-lg-4">
    <div class="feature-card p-4">
      <h5><?= $edit?'Edit':'Tambah' ?> Gejala</h5>
      <form method="POST">
        <input type="hidden" name="mode" value="<?= $edit?'edit':'add' ?>">
        <div class="mb-3">
          <label class="form-label">ID Gejala</label>
          <input class="form-control" name="id_gejala" value="<?= e($edit['id_gejala'] ?? '') ?>" <?= $edit?'readonly':'' ?> required placeholder="G001">
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Gejala</label>
          <input class="form-control" name="nama_gejala" value="<?= e($edit['nama_gejala'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Pertanyaan</label>
          <textarea class="form-control" name="pertanyaan" rows="4" required><?= e($edit['pertanyaan'] ?? '') ?></textarea>
        </div>
        <button class="btn btn-rose">Simpan</button>
        <?php if($edit): ?>
          <a class="btn btn-light" href="gejala.php">Batal</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="feature-card p-4">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Pertanyaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data as $r): ?>
              <tr>
                <td><?= e($r['id_gejala']) ?></td>
                <td><?= e($r['nama_gejala']) ?></td>
                <td><?= e($r['pertanyaan']) ?></td>
                <td class="action-cell">
                  <a class="btn btn-sm btn-outline-secondary" href="?edit=<?= e($r['id_gejala']) ?>">Edit</a>
                  <a class="btn btn-sm btn-outline-danger confirm-delete" href="?delete=<?= e($r['id_gejala']) ?>">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include '_footer.php'; ?>
