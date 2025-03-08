<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>get_list</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="src/style.css">

</head>
<body class="bg-gray-100">
    <header class="flex justify-center py-6">
        <h1 class="text-3xl font-bold">Daftar Film Rating Tertinggi</h1>
    </header>

    <div class="ml-4 mb-8">
        <a href="index.php" 
        class="inline-block bg-green-500 hover:bg-blue-600 text-white 
        px-6 py-3 rounded-lg text-lg font-semibold no-underline shadow-md 
        hover:shadow-lg transition-all duration-300">Kembali</a>
    </div>

    <?php
    // URL API yang akan diakses (menggunakan API TMDB sebagai contoh)
    $api_key = "862e89bda8a15b743d5c811125a53609"; // Ganti dengan API key TMDB Anda
    $api_url = "https://api.themoviedb.org/3/movie/top_rated?api_key=" . $api_key;

    // Inisialisasi CURL untuk mengambil data dari API
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Eksekusi CURL dan simpan responsenya
    $response = curl_exec($curl);
    
    // Tutup koneksi CURL
    curl_close($curl);

    // Decode JSON response menjadi array PHP
    $data = json_decode($response, true);

    // Cek apakah data berhasil diambil
    if(isset($data['results'])) {
        echo '<div class="px-4 ">';
        echo '<table class="w-full mx-auto bg-white rounded-lg overflow-hidden shadow-lg">';
        echo '<thead>
                <tr class="bg-gray-500 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Film</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Rilis</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Overview</th>
                </tr>
              </thead>
              <tbody>';
        
        // Loop untuk menampilkan setiap film dalam tabel
        $no = 1;
        foreach($data['results'] as $movie) {
            $rowClass = $no % 2 === 0 ? 'bg-gray-50' : 'bg-white';
            echo "<tr class='{$rowClass} hover:bg-gray-100 transition-colors duration-200'>";
            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $no . "</td>";
            echo "<td class='px-6 py-4 text-sm text-gray-900 font-medium'>" . $movie['title'] . "</td>";
            echo "<td class='px-6 py-4 text-sm text-gray-500'>" . $movie['release_date'] . "</td>";
            echo "<td class='px-6 py-4 text-sm text-gray-900'>" . $movie['vote_average'] . "</td>";
            echo "<td class='px-6 py-4 text-sm text-gray-500'>" . $movie['overview'] . "</td>";
            // Tambahkan kolom rating
            echo "<td class='px-6 py-4'>
                <form action='add_rating.php' method='POST' class='space-y-2'>
                    <input type='hidden' name='movie_id' value='" . $movie['id'] . "'>
                    <div class='flex items-center gap-2'>
                        <div class='flex items-center space-x-1'>
                            <select name='rating' class='rounded-md border px-2 py-1 bg-white'>
                                <option value='1'>⭐</option>
                                <option value='2'>⭐⭐</option>
                                <option value='3'>⭐⭐⭐</option>
                                <option value='4'>⭐⭐⭐⭐</option>
                                <option value='5'>⭐⭐⭐⭐⭐</option>
                            </select>
                            <button type='submit' 
                                class='bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300'>
                                Rate
                            </button>
                        </div>
                    </div>
                </form>
            </td>";
            echo "</tr>";
            $no++;
        }
        
        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-center text-red-500 text-lg mt-4'>Gagal mengambil data dari API</p>";
    }
    ?>

</body>
</html>
    