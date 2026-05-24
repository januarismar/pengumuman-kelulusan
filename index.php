<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Kelulusan Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="card">
            <!-- Header Sekolah -->
            <div class="header-sekolah">
                <h2>PENGUMUMAN KELULUSAN</h2>
                <h3>TAHUN AJARAN 2025/2026</h3>
            </div>
            
            <hr class="divider">

            <!-- Area Hitung Mundur -->
            <div id="countdown-area">
                <p class="info-text">Pengumuman dapat diakses dalam:</p>
                <div class="countdown-wrapper">
                    <div class="time-box"><span id="hari">00</span><p>Hari</p></div>
                    <div class="time-box"><span id="jam">00</span><p>Jam</p></div>
                    <div class="time-box"><span id="menit">00</span><p>Menit</p></div>
                    <div class="time-box"><span id="detik">00</span><p>Detik</p></div>
                </div>
            </div>

            <!-- Form Input (Tersembunyi secara default, muncul via JS) -->
            <div id="form-area" class="hidden">
                <p class="info-text-ready">Silakan masukkan Nomor Induk Siswa Nasional (NISN) Anda untuk melihat status kelulusan.</p>
                <form action="cek-kelulusan.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="nisn" placeholder="Masukkan 10 Digit NISN" maxlength="10" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <button type="submit" class="btn-submit">Cek Status Kelulusan</button>
                </form>
            </div>

            <div class="footer">
                <p>&copy; 2026 Tim Data & Informatika Sekolah</p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>