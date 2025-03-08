<?php
// Fungsi untuk mengambil data dari API
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Data provinsi (contoh beberapa provinsi di Indonesia)
$provinsi = [
    ['id' => '11', 'name' => 'Jawa Timur'],
    ['id' => '12', 'name' => 'Jawa Barat'],
    ['id' => '13', 'name' => 'Jawa Tengah'],
    ['id' => '14', 'name' => 'DKI Jakarta']
];

// Ambil daftar kota jika provinsi dipilih
$kota = [];
if (isset($_GET['provinsi_id'])) {
    $provinsiUrl = "https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=" . $_GET['provinsi_id'];
    $kotaData = fetchData($provinsiUrl);
    $kota = isset($kotaData['result']) ? $kotaData['result'] : [];
}

// Ambil data cuaca jika kota dipilih
if (isset($_GET['kota'])) {
    $city = urlencode($_GET['kota']);
    $apiKey = '49a8cbec34fc417cb2065214252702';
    $weatherUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$city},Indonesia&aqi=no";
    
    $weatherData = fetchData($weatherUrl);
    
    if (isset($weatherData['current'])) {
        $temperature = $weatherData['current']['temp_c'];
        $condition = $weatherData['current']['condition']['text'];
        $humidity = $weatherData['current']['humidity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Cuaca Indonesia</title>
    <link href="./src/app.css" rel="stylesheet">
</head>

<body>
    <div class="min-h-screen flex justify-center items-center">
        <div class="p-10 rounded-md bg-gradient-to-r from-cyan-500 to-blue-500">
            <form method="GET" class="flex flex-col space-y-4">
                <!-- Dropdown Provinsi -->
                <select name="provinsi_id" id="provinsi" class="p-2 rounded-md" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinsi as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= (isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $p['id']) ? 'selected' : '' ?>>
                            <?= $p['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Dropdown Kota -->
                <select name="kota" id="kota" class="p-2 rounded-md" required <?= empty($kota) ? 'disabled' : '' ?>>
                    <option value="">Pilih Kota</option>
                    <?php foreach ($kota as $k) : ?>
                        <option value="<?= $k['text'] ?>" <?= (isset($_GET['kota']) && $_GET['kota'] == $k['text']) ? 'selected' : '' ?>>
                            <?= $k['text'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Cek Cuaca" class="bg-white p-2 rounded-md cursor-pointer hover:bg-gray-100">
            </form>

            <?php if (isset($weatherData['current'])) : ?>
            <div class="mt-4 bg-white p-4 rounded-md">
                <h2 class="text-xl font-bold"><?= $_GET['kota'] ?></h2>
                <p>Suhu: <?= $temperature ?>°C</p>
                <p>Kondisi: <?= $condition ?></p>
                <p>Kelembaban: <?= $humidity ?>%</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Script untuk auto-submit form saat provinsi dipilih
    document.getElementById('provinsi').addEventListener('change', function() {
        this.form.submit();
    });
    </script>
</body>
</html>
// ... existing code ...