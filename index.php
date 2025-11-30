<?php
// === KONFIGURASI PENGIRIMAN EMAIL ===

// Alamat email tujuan (penerima pesan)
$email_tujuan = "rotiiiaokaaa@gmail.com";

// Subjek default jika tidak ada subjek yang diisi
$subjek_default = "Pesan dari Formulir Kontak Website SMP Muhammadiyah Loa Kulu";

// Cek apakah data formulir sudah dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Ambil data dari formulir
    $nama = htmlspecialchars(trim($_POST['nama']));
    $email_pengirim = htmlspecialchars(trim($_POST['email_pengirim']));
    $subjek = htmlspecialchars(trim($_POST['subjek']));
    $pesan = htmlspecialchars(trim($_POST['pesan']));

    // 2. Validasi sederhana
    if (empty($nama) || empty($email_pengirim) || empty($subjek) || empty($pesan)) {
        die("Semua kolom harus diisi!");
    }
    
    // Cek format email yang valid
    if (!filter_var($email_pengirim, FILTER_VALIDATE_EMAIL)) {
        die("Format email pengirim tidak valid.");
    }

    // 3. Susun isi email
    $isi_pesan = "Anda menerima pesan baru dari formulir kontak website.\n\n";
    $isi_pesan .= "Nama Pengirim: " . $nama . "\n";
    $isi_pesan .= "Email Pengirim: " . $email_pengirim . "\n";
    $isi_pesan .= "Subjek: " . $subjek . "\n\n";
    $isi_pesan .= "Isi Pesan:\n" . $pesan . "\n";

    // 4. Susun Header Email
    // Header ini penting agar penerima tahu siapa yang mengirim
    $headers = "From: " . $nama . " <" . $email_pengirim . ">\r\n";
    $headers .= "Reply-To: " . $email_pengirim . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. Kirim Email menggunakan fungsi mail() PHP
    $berhasil = mail($email_tujuan, $subjek, $isi_pesan, $headers);

    // 6. Beri respon kepada pengguna
    if ($berhasil) {
        echo "<h2>Pesan Berhasil Terkirim!</h2>";
        echo "<p>Terima kasih, " . $nama . ". Pesan Anda telah berhasil dikirim ke " . $email_tujuan . ".</p>";
        echo "<a href='index.html'>Kembali ke Beranda</a>";
    } else {
        echo "<h2>Pesan Gagal Terkirim</h2>";
        echo "<p>Maaf, terjadi kesalahan saat mencoba mengirim pesan. Silakan coba lagi nanti.</p>";
        echo "<a href='index.html'>Kembali ke Formulir</a>";
    }

} else {
    // Jika ada akses langsung ke file ini tanpa POST
    header("Location: index.html");
    exit;
}
?>