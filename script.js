// Target waktu pengumuman (Format: YYYY-MM-DDTHH:mm:ss)
// Menggunakan standar ISO dengan offset Waktu Indonesia Tengah (WITA = UTC+8) -> +08:00
const targetWaktu = new Date("2026-05-28T10:00:00+08:00").getTime();

const hitungMundur = setInterval(function() {
    const sekarang = new Date().getTime();
    const selisih = targetWaktu - sekarang;

    // Kalkulasi matematika untuk konversi waktu
    const hari = Math.floor(selisih / (1000 * 60 * 60 * 24));
    const jam = Math.floor((selisih % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
    const detik = Math.floor((selisih % (1000 * 60)) / 1000);

    // Tempelkan angka ke HTML dengan format dua digit jika di bawah 10 (misal: 05)
    document.getElementById("hari").innerText = hari < 10 ? "0" + hari : hari;
    document.getElementById("jam").innerText = jam < 10 ? "0" + jam : jam;
    document.getElementById("menit").innerText = menit < 10 ? "0" + menit : menit;
    document.getElementById("detik").innerText = detik < 10 ? "0" + detik : detik;

    // Jika waktu hitung mundur selesai / habis
    if (selisih < 0) {
        clearInterval(hitungMundur);
        
        // Sembunyikan konter hitung mundur dan munculkan form NISN
        document.getElementById("countdown-area").classList.add("hidden");
        document.getElementById("form-area").classList.remove("hidden");
    }
}, 1000);