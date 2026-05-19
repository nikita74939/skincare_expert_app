<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function require_admin() {
    if (!is_admin()) redirect('login.php');
}

function get_all($pdo, $table, $order = '') {
    $sql = "SELECT * FROM $table" . ($order ? " ORDER BY $order" : '');
    return $pdo->query($sql)->fetchAll();
}

function forward_chaining($pdo, array $selected_gejala) {
    if (empty($selected_gejala)) return null;

    $placeholders = implode(',', array_fill(0, count($selected_gejala), '?'));
    $sql = "
        SELECT jk.id_jenis, jk.nama_jenis, jk.deskripsi,
               COUNT(a.id_gejala) AS jumlah_cocok,
               total.total_gejala,
               ROUND((COUNT(a.id_gejala) / total.total_gejala) * 100, 2) AS persentase
        FROM aturan a
        JOIN jenis_kulit jk ON jk.id_jenis = a.id_jenis
        JOIN (
            SELECT id_jenis, COUNT(*) AS total_gejala
            FROM aturan
            GROUP BY id_jenis
        ) total ON total.id_jenis = a.id_jenis
        WHERE a.id_gejala IN ($placeholders)
        GROUP BY jk.id_jenis, jk.nama_jenis, jk.deskripsi, total.total_gejala
        ORDER BY persentase DESC, jumlah_cocok DESC, total.total_gejala ASC
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($selected_gejala);
    $hasil = $stmt->fetch();
    if (!$hasil) return null;

    $stmt = $pdo->prepare("SELECT * FROM rekomendasi WHERE id_jenis = ? LIMIT 1");
    $stmt->execute([$hasil['id_jenis']]);
    $hasil['rekomendasi'] = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT g.* FROM aturan a JOIN gejala g ON g.id_gejala = a.id_gejala WHERE a.id_jenis = ? ORDER BY g.id_gejala");
    $stmt->execute([$hasil['id_jenis']]);
    $hasil['basis_gejala'] = $stmt->fetchAll();

    return $hasil;
}
?>
