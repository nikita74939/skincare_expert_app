<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (is_admin()) {
    redirect('dashboard.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? OR nama=? LIMIT 1");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id_user'=>$user['id_user'], 'nama'=>$user['nama'], 'role'=>$user['role']];
        redirect('dashboard.php');
    }
    $error = 'Username atau password admin salah.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"></head><body><section class="py-5"><div class="container"><div class="row justify-content-center"><div class="col-md-5"><div class="feature-card p-4 p-md-5"><h3 class="fw-bold mb-2">Login Admin</h3><p class="text-muted">Masuk untuk mengelola basis pengetahuan.</p><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="POST"><div class="mb-3"><label class="form-label">Email/Username</label><input class="form-control" name="username" required></div><div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div><button class="btn btn-rose w-100">Login</button></form></div></div></div></div></section></body></html>
