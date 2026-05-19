<?php include '_header.php';
$edit=null;
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM jenis_kulit WHERE id_jenis=?")->execute([$_GET['delete']]);
  redirect('jenis_kulit.php');
}
if($_SERVER['REQUEST_METHOD']==='POST'){
  if($_POST['mode']==='edit') {
    $pdo->prepare("UPDATE jenis_kulit SET nama_jenis=?, deskripsi=? WHERE id_jenis=?")->execute([$_POST['nama_jenis'],$_POST['deskripsi'],$_POST['id_jenis']]);
  } else {
    $pdo->prepare("INSERT INTO jenis_kulit (id_jenis,nama_jenis,deskripsi) VALUES (?,?,?)")->execute([$_POST['id_jenis'],$_POST['nama_jenis'],$_POST['deskripsi']]);
  }
  redirect('jenis_kulit.php');
}
if(isset($_GET['edit'])){
  $stmt=$pdo->prepare("SELECT * FROM jenis_kulit WHERE id_jenis=?");
  $stmt->execute([$_GET['edit']]);
  $edit=$stmt->fetch();
}
$data=get_all($pdo,'jenis_kulit','id_jenis ASC');
?>
<h2 class="fw-bold mb-3">Kelola Jenis Kulit</h2>
<div class="row g-4">
  <div class="col-lg-4">
    <div class="feature-card p-4">
      <h5><?= $edit?'Edit':'Tambah' ?> Jenis Kulit</h5>
      <form method="POST">
        <input type="hidden" name="mode" value="<?= $edit?'edit':'add' ?>">
        <div class="mb-3">
          <label class="form-label">ID Jenis</label>
          <input class="form-control" name="id_jenis" value="<?= e($edit['id_jenis'] ?? '') ?>" <?= $edit?'readonly':'' ?> required placeholder="K001">
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Jenis</label>
          <input class="form-control" name="nama_jenis" value="<?= e($edit['nama_jenis'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" name="deskripsi" rows="5"><?= e($edit['deskripsi'] ?? '') ?></textarea>
        </div>
        <button class="btn btn-rose">Simpan</button>
        <?php if($edit): ?>
          <a class="btn btn-light" href="jenis_kulit.php">Batal</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="feature-card p-4">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data as $r): ?>
            <tr>
              <td><?= e($r['id_jenis']) ?></td>
              <td><?= e($r['nama_jenis']) ?></td>
              <td><?= e($r['deskripsi']) ?></td>
              <td class="action-cell">
                <a class="btn btn-sm btn-outline-secondary" href="?edit=<?= e($r['id_jenis']) ?>">Edit</a>
                <a class="btn btn-sm btn-outline-danger confirm-delete" href="?delete=<?= e($r['id_jenis']) ?>">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '_footer.php'; ?>
