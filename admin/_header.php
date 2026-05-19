<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$current = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin SkinWise</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <aside class="col-md-3 col-lg-2 admin-sidebar p-3">
        <h5 class="text-white mb-4">SkinWise Admin</h5>
        <a class="<?= $current==='dashboard.php'?'active':'' ?>" href="dashboard.php">Dashboard</a>
        <a class="<?= $current==='gejala.php'?'active':'' ?>" href="gejala.php">Gejala/Kondisi</a>
        <a class="<?= $current==='jenis_kulit.php'?'active':'' ?>" href="jenis_kulit.php">Jenis Kulit</a>
        <a class="<?= $current==='aturan.php'?'active':'' ?>" href="aturan.php">Aturan</a>
        <a class="<?= $current==='rekomendasi.php'?'active':'' ?>" href="rekomendasi.php">Rekomendasi</a>
        <a href="logout.php">Logout</a>
      </aside>
      <main class="col-md-9 col-lg-10 p-4">
