<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];
    
    try {
        // Konversi rating dari skala 1-5 ke skala 0.5-10
        $tmdb_rating = $rating * 2;
        
        // Siapkan data untuk dikirim
        $data = json_encode([
            'value' => $tmdb_rating
        ]);

        // Inisialisasi CURL
        $curl = curl_init();

        // Set opsi CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/movie/{$movie_id}/rating",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4NjJlODliZGE4YTE1Yjc0M2Q1YzgxMTEyNWE1MzYwOSIsIm5iZiI6MTc0MDY3MjM1MS4wNzAwMDAyLCJzdWIiOiI2N2MwOGQ1ZmMwMjkxMzliMGUzNWIwMjkiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.S2JX7kkj_StXx6FNab8xWeVkNXlJ51x44vtDIZdzUyg',
                'Content-Type: application/json',
                'accept: application/json'
            ]
        ]);

        // Eksekusi CURL
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Tutup koneksi CURL
        curl_close($curl);

        // Cek status response
        if ($http_status === 200 || $http_status === 201) {
            header("Location: get_list.php?status=success&message=Rating berhasil ditambahkan");
        } else {
            $error_message = json_decode($response, true);
            throw new Exception($error_message['status_message'] ?? 'Unknown error occurred');
        }
        
    } catch (Exception $e) {
        header("Location: get_list.php?status=error&message=Gagal menambahkan rating: " . $e->getMessage());
    }
}
?> 