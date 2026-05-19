CREATE DATABASE IF NOT EXISTS sistem_pakar_skincare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistem_pakar_skincare;

DROP TABLE IF EXISTS detail_konsultasi;
DROP TABLE IF EXISTS konsultasi;
DROP TABLE IF EXISTS rekomendasi;
DROP TABLE IF EXISTS aturan;
DROP TABLE IF EXISTS jenis_kulit;
DROP TABLE IF EXISTS gejala;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE gejala (
    id_gejala CHAR(5) PRIMARY KEY,
    nama_gejala VARCHAR(150) NOT NULL,
    pertanyaan TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE jenis_kulit (
    id_jenis CHAR(5) PRIMARY KEY,
    nama_jenis VARCHAR(100) NOT NULL,
    deskripsi TEXT
) ENGINE=InnoDB;

CREATE TABLE aturan (
    id_aturan INT AUTO_INCREMENT PRIMARY KEY,
    id_jenis CHAR(5) NOT NULL,
    id_gejala CHAR(5) NOT NULL,
    UNIQUE KEY unik_aturan (id_jenis, id_gejala),
    CONSTRAINT fk_aturan_jenis FOREIGN KEY (id_jenis) REFERENCES jenis_kulit(id_jenis) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_aturan_gejala FOREIGN KEY (id_gejala) REFERENCES gejala(id_gejala) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE rekomendasi (
    id_rekomendasi INT AUTO_INCREMENT PRIMARY KEY,
    id_jenis CHAR(5) NOT NULL,
    kandungan_disarankan TEXT,
    produk_disarankan TEXT,
    kandungan_dihindari TEXT,
    tips_perawatan TEXT,
    CONSTRAINT fk_rekomendasi_jenis FOREIGN KEY (id_jenis) REFERENCES jenis_kulit(id_jenis) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE konsultasi (
    id_konsultasi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NULL,
    tanggal_konsultasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_jenis_hasil CHAR(5) NULL,
    CONSTRAINT fk_konsultasi_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_konsultasi_jenis FOREIGN KEY (id_jenis_hasil) REFERENCES jenis_kulit(id_jenis) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE detail_konsultasi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_konsultasi INT NOT NULL,
    id_gejala CHAR(5) NOT NULL,
    jawaban ENUM('ya','tidak') NOT NULL,
    CONSTRAINT fk_detail_konsultasi FOREIGN KEY (id_konsultasi) REFERENCES konsultasi(id_konsultasi) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detail_gejala FOREIGN KEY (id_gejala) REFERENCES gejala(id_gejala) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (nama, email, password, role) VALUES
('Administrator', 'admin@skinwise.test', '$2y$12$eIL7Zr8zgYVgVE5ABo3ae.SsA6gMHWWCgwtzdJJLnnGiFwNQ/ntdy', 'admin');

INSERT INTO gejala (id_gejala, nama_gejala, pertanyaan) VALUES
('G001', 'Wajah terasa mengkilap', 'Apakah wajah Anda sering terasa mengkilap atau berminyak?'),
('G002', 'Pori-pori besar terlihat jelas', 'Apakah pori-pori wajah Anda terlihat besar atau jelas?'),
('G003', 'Mudah berjerawat', 'Apakah kulit wajah Anda mudah berjerawat?'),
('G004', 'Banyak komedo', 'Apakah wajah Anda memiliki banyak komedo?'),
('G005', 'Kulit terasa kasar', 'Apakah permukaan kulit wajah Anda terasa kasar?'),
('G006', 'Kulit terasa ketarik setelah cuci muka', 'Apakah kulit terasa tertarik setelah mencuci wajah?'),
('G007', 'Kulit mudah mengelupas', 'Apakah kulit wajah Anda mudah mengelupas?'),
('G008', 'Kulit tampak kusam', 'Apakah kulit wajah Anda tampak kusam?'),
('G009', 'Area T-zone berminyak', 'Apakah area dahi, hidung, dan dagu terasa berminyak?'),
('G010', 'Pipi terasa kering', 'Apakah area pipi terasa kering?'),
('G011', 'Mudah kemerahan', 'Apakah kulit wajah Anda mudah kemerahan?'),
('G012', 'Mudah iritasi', 'Apakah kulit wajah Anda mudah mengalami iritasi?'),
('G013', 'Kulit terasa perih', 'Apakah kulit terasa perih saat menggunakan produk tertentu?'),
('G014', 'Jarang mengalami masalah kulit', 'Apakah kulit Anda jarang mengalami masalah kulit?'),
('G015', 'Tekstur kulit halus dan lembut', 'Apakah tekstur kulit wajah terasa halus dan lembut?'),
('G016', 'Memiliki garis halus dan kerutan', 'Apakah terdapat garis halus atau kerutan pada wajah?'),
('G017', 'Memiliki noda hitam', 'Apakah terdapat noda hitam atau bekas jerawat pada wajah?');

INSERT INTO jenis_kulit (id_jenis, nama_jenis, deskripsi) VALUES
('K001', 'Kulit Normal', 'Jenis kulit yang relatif seimbang, teksturnya halus, dan jarang mengalami masalah kulit.'),
('K002', 'Kulit Berminyak', 'Jenis kulit dengan produksi sebum berlebih, sering tampak mengkilap, pori-pori terlihat besar, dan rentan komedo atau jerawat.'),
('K003', 'Kulit Kering', 'Jenis kulit yang kekurangan kelembapan, dapat terasa kasar, tertarik, kusam, atau mudah mengelupas.'),
('K004', 'Kulit Kombinasi', 'Jenis kulit dengan area T-zone berminyak tetapi area pipi cenderung kering.'),
('K005', 'Kulit Sensitif', 'Jenis kulit yang mudah kemerahan, iritasi, atau terasa perih terhadap produk tertentu.');

INSERT INTO aturan (id_jenis, id_gejala) VALUES
-- Normal
('K001','G014'),('K001','G015'),
-- Berminyak
('K002','G001'),('K002','G002'),('K002','G003'),('K002','G004'),('K002','G008'),('K002','G016'),('K002','G017'),
-- Kering
('K003','G005'),('K003','G006'),('K003','G007'),('K003','G008'),('K003','G016'),('K003','G017'),
-- Kombinasi
('K004','G002'),('K004','G003'),('K004','G004'),('K004','G009'),('K004','G010'),
-- Sensitif
('K005','G011'),('K005','G012'),('K005','G013');

INSERT INTO rekomendasi (id_jenis, kandungan_disarankan, produk_disarankan, kandungan_dihindari, tips_perawatan) VALUES
('K001', 'Hyaluronic Acid, Niacinamide ringan, Ceramide', 'Facial wash gentle cleanser, hydrating moisturizer, sunscreen SPF 30+', 'Eksfoliasi berlebihan dan produk yang terlalu keras', 'Pertahankan basic skincare: cleanser, moisturizer, dan sunscreen setiap pagi.'),
('K002', 'Salicylic Acid, Niacinamide, Zinc PCA, Green Tea', 'Oil control facial wash, salicylic acid serum, niacinamide serum, sunscreen SPF 30+, non-comedogenic moisturizer', 'Produk terlalu greasy, mineral oil berlebih, scrub kasar', 'Gunakan produk non-comedogenic dan hindari mencuci wajah terlalu sering agar skin barrier tidak terganggu.'),
('K003', 'Hyaluronic Acid, Glycerin, Ceramide, Panthenol', 'Facial wash gentle cleanser, hydrating moisturizer, sunscreen SPF 30+', 'Alkohol tinggi, exfoliating acid terlalu sering, facial wash yang membuat kulit ketarik', 'Fokus pada hidrasi dan perbaikan skin barrier. Pakai moisturizer saat kulit masih sedikit lembap.'),
('K004', 'Niacinamide, Hyaluronic Acid, Salicylic Acid ringan', 'Salicylic acid serum, niacinamide serum, sunscreen SPF 30+, non-comedogenic moisturizer', 'Produk terlalu berat di T-zone dan produk terlalu drying di area pipi', 'Rawat area wajah sesuai kebutuhan: kontrol minyak di T-zone dan jaga hidrasi di area pipi.'),
('K005', 'Centella Asiatica, Panthenol, Ceramide, Aloe Vera', 'Soothing toner, hydrating moisturizer, sunscreen SPF 30+', 'Fragrance, alkohol tinggi, essential oil, eksfoliasi dosis tinggi', 'Gunakan produk minimalis dan lakukan patch test sebelum mencoba skincare baru.');
