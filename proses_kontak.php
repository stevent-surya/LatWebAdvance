<?php
// Panggil koneksi database dari folder services
require_once 'services/aboutmedb.php';

// Pastikan request yang masuk adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form (sesuai dengan atribut 'name' di form HTML)
    // htmlspecialchars digunakan untuk mencegah XSS
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    // Siapkan query SQL menggunakan Prepared Statement
    $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";
    
    if ($stmt = $koneksi->prepare($sql)) {
        // Bind parameter ke query (sss = string, string, string)
        $stmt->bind_param("sss", $nama, $email, $pesan);
        
        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, beri alert dan kembalikan ke bagian contact
            echo "<script>
                    alert('Terima kasih! Pesan kamu berhasil dikirim.');
                    window.location.href = 'index.php#contact';
                  </script>";
        } else {
            // Jika gagal eksekusi database
            echo "<script>
                    alert('Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
                    window.location.href = 'index.php#contact';
                  </script>";
        }
        
        // Tutup statement
        $stmt->close();
    } else {
         // Jika gagal prepare query
         echo "<script>
                alert('Sistem sedang bermasalah. Hubungi administrator.');
                window.location.href = 'index.php#contact';
              </script>";
    }
    
    // Tutup koneksi database
    $koneksi->close();
    
} else {
    // Jika file diakses langsung lewat URL tanpa submit form, arahkan kembali ke index
    header("Location: index.php");
    exit();
}
?>