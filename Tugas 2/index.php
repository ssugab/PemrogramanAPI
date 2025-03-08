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

// Ambil daftar provinsi
$provinsiUrl = "https://alamat.thecloudalert.com/api/provinsi/get/";
$provData = fetchData($provinsiUrl);
$provId = isset($provData['result']) ? $provData['result'] : [];

// Ambil daftar kota jika provinsi dipilih
$kota = [];
if (isset($_GET['provinsi_id'])) {
    $kotaUrl = "https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=".$_GET['provinsi_id'];
    $kotaData = fetchData($kotaUrl);
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
        $icon = $weatherData['current']['condition']['icon'];
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

<body class="min-h-screen">                                                                         <!-- body dengan min-h-screen untuk memastikan tinggi minimal sesuai viewport -->
    <div class="min-h-screen flex items-center justify-center">                                     <!-- Container flex utama dengan items-center dan justify-center untuk centering sempurna -->
        <div class="w-[500px] p-8">                                                                 <!-- Container dengan width tetap (w-[500px]) dan padding -->
            <div class="p-10 rounded-md bg-[#682d6b]">  <!-- Layer 4: Container konten dengan gradient dan shadow -->
                <h1 class="text-2xl mb-9 text-[#FFF2F2] text-center font-bold">Cek Cuaca Indonesia</h1>
                <form method="GET" class="flex flex-col space-y-4 ">
                    <!-- Dropdown Provinsi -->
                    <select name="provinsi_id" id="provinsi" class="p-2 rounded-md bg-[#FFF2F2] hover:drop-shadow-xl" required>
                        <option value="">Pilih Provinsi</option>
                        <?php foreach ($provId as $p) : ?>
                            <option value="<?= $p['id'] ?>" <?= (isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $p['id']) ? 'selected' : '' ?>>
                                <?= $p['text'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Dropdown Kota -->
                    <select name="kota" id="kota" class="p-2 rounded-md bg-[#FFF2F2]" required <?= empty($kota) ? 'disabled' : '' ?>>
                        <option value="">Pilih Kota</option>
                        <?php foreach ($kota as $k) : ?>
                            <option value="<?= $k['text'] ?>" <?= (isset($_GET['kota']) && $_GET['kota'] == $k['text']) ? 'selected' : '' ?>>
                                <?= $k['text'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="submit" value="Cek Cuaca" class="bg-[#FFF2F2] p-2 rounded-md cursor-pointer hover:bg-gray-300 hover:drop-shadow-xl">
                </form>

                <?php if (isset($weatherData['current'])) : ?>
                <div class="mt-4 bg-[#FFF2F2] p-4 rounded-md">
                <h2 class="text-xl font-bold mt-3 flex items-center gap-2">
                        <img src="https:<?= $icon ?>" alt="<?= $condition ?>" class="w-24 h-24">
                        <p class="text-4xl"><?= $temperature ?> <p class="text-lg">°C</p></p>
                        
                    </h2>
                <h2 class="text-xl font-bold mb-5 mt-5 flex items-center"> <?= $_GET['kota'] ?></h2>
                    <div class="space-y-2">
                        <p class="flex items-center gap-2">
                            <!-- Icon src-->
                            Suhu: <?= $temperature ?>°C
                        </p>
                        <p class="flex items-center gap-2">
                            <!-- Icon src-->
                            Kondisi: <?= $condition ?>
                        </p>
                        <p class="flex items-center gap-2">
                            <!-- Icon src-->
                            Kelembaban: <?= $humidity ?>%
                        </p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    // Auto-submit form saat provinsi dipilih
    document.getElementById('provinsi').addEventListener('change', function() {
        this.form.submit();
    });
    </script>
</body>
</html>