<?php
// Bagian 1: Mengambil data dari Database
include 'services/aboutmedb.php';

// Siapkan dua array kosong untuk menampung data chart
$labels = [];
$data_chart = [];

$sql = "SELECT projectname, total FROM projectdone";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    // Loop untuk setiap baris data dari database
    while($row = $result->fetch_assoc()) {
        // Masukkan 'projectname' ke dalam array labels
        $labels[] = $row["projectname"];
        // Masukkan 'total' ke dalam array data_chart
        $data_chart[] = (int)$row["total"]; // (int) untuk memastikan datanya adalah angka
    }
}
$koneksi->close();
?>

<canvas id="projectChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Bagian 2: Inisialisasi Chart dengan data dari PHP
function initCharts() {
    const projectCtx = document.getElementById('projectChart').getContext('2d');
    const projectChart = new Chart(projectCtx, {
        type: 'bar',
        data: {
            // Gunakan json_encode untuk 'mencetak' array PHP ke JavaScript
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Jumlah Proyek',
                // Gunakan json_encode untuk 'mencetak' array PHP ke JavaScript
                data: <?php echo json_encode($data_chart); ?>,
                backgroundColor: [
                    'rgba(0, 188, 212, 0.8)',
                    'rgba(0, 188, 212, 0.7)',
                    'rgba(0, 188, 212, 0.6)',
                    'rgba(0, 188, 212, 0.5)',
                    'rgba(0, 188, 212, 0.4)'
                ],
                borderColor: '#00bcd4',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#fff' // Ganti warna sesuai tema Anda
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Ganti warna sesuai tema Anda
                    },
                    grid: {
                        color: '#333'
                    }
                },
                x: {
                    ticks: {
                        color: '#fff' // Ganti warna sesuai tema Anda
                    },
                    grid: {
                        color: '#333'
                    }
                }
            }
        }
    });
}

// Panggil fungsi untuk menggambar chart saat halaman dimuat
document.addEventListener('DOMContentLoaded', initCharts);
</script>