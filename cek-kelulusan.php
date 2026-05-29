<?php
// 1. Atur Zona Waktu Server ke WITA
date_default_timezone_set("Asia/Makassar");

$waktu_sekarang = time();
$waktu_buka = strtotime("2026-05-29 15:55:00"); // Sesuaikan jadwal pengumuman asli

// 2. Proteksi Waktu (Cegah akses ilegal sebelum waktunya)
if ($waktu_sekarang < $waktu_buka) {
    die("
    <div style='text-align:center; padding:50px; font-family:sans-serif;'>
        <h2 style='color:#d32f2f;'>Akses Ditolak</h2>
        <p>Waktu pengumuman kelulusan resmi belum dibuka di server.</p>
        <a href='index.php'>Kembali</a>
    </div>
    ");
}

// 3. Tangkap data input NISN
$nisn_input = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';

if (empty($nisn_input)) {
    header("Location: index.php");
    exit;
}

// 4. Membaca Data dari File CSV secara Efisien
$siswa_ditemukan = false;
$hasil_pencarian = null;
$nama_file_csv = "data-siswa.csv";

if (file_exists($nama_file_csv)) {
    // Buka file CSV dengan mode read-only
    if (($handle = fopen($nama_file_csv, "r")) !== FALSE) {
        // Lewati baris pertama (header tabel: NISN, NAMA, STATUS, KETERANGAN)
        fgetcsv($handle, 1000, ",");
        
        // Looping membaca baris demi baris sampai ketemu NISN yang cocok
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // $data[0] = NISN, $data[1] = Nama, $data[2] = Status, $data[3] = Keterangan
            if (trim($data[0]) === $nisn_input) {
                $siswa_ditemukan = true;
                $hasil_pencarian = [
                    "nama" => $data[1],
                    "status" => $data[2],
                    "keterangan" => $data[3]
                ];
                break; // Hentikan pencarian jika sudah ketemu (Sangat efisien untuk server)
            }
        }
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kelulusan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .status-box { margin: 20px 0; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 1.4rem; }
        .lulus { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .tidak-lulus { background-color: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
        .tidak-ditemukan { background-color: #fff3e0; color: #ef6c00; border: 1px solid #ffcc80; }
        .detail-siswa { text-align: left; background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .detail-siswa p { margin-bottom: 8px; color: #333; }
        .btn-back { display: inline-block; width: 100%; text-decoration: none; text-align: center; padding: 14px; background: #1e3c72; color: white; border-radius: 8px; font-weight: 600; transition: background 0.3s; }
        .btn-back:hover { background: #11274c; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="header-sekolah">
                <h2>HASIL STATUS KELULUSAN</h2>
                <h3>TAHUN AJARAN 2025/2026</h3>
            </div>
            
            <hr class="divider">

            <?php if ($siswa_ditemukan): ?>
                <div class="detail-siswa">
                    <p><strong>NISN :</strong> <?php echo htmlspecialchars($nisn_input); ?></p>
                    <p><strong>Nama Siswa :</strong> <?php echo htmlspecialchars($hasil_pencarian['nama']); ?></p>
                </div>

                <?php if (strtoupper($hasil_pencarian['status']) === "LULUS"): ?>
                    <div class="status-box lulus">DINYATAKAN: LULUS</div>
                <?php else: ?>
                    <div class="status-box tidak-lulus">DINYATAKAN: TIDAK LULUS</div>
                <?php endif; ?>

                <p style="color: #555; font-size: 0.95rem; margin-bottom: 25px; line-height: 1.5;">
                    <?php echo htmlspecialchars($hasil_pencarian['keterangan']); ?>
                </p>

            <?php else: ?>
                <div class="status-box tidak-ditemukan">DATA TIDAK DITEMUKAN</div>
                <p style="color: #666; font-size: 0.95rem; margin-bottom: 25px;">
                    Maaf, data dengan NISN <strong><?php echo htmlspecialchars($nisn_input); ?></strong> tidak terdaftar dalam sistem kami.
                </p>
            <?php endif; ?>

            <a href="index.php" class="btn-back">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>