<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List API</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="src/style.css">

</head>
<body class="bg-gray-100 min-h-screen p-8">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Film dari API</h1>

    <section> 

    </section>
    

    <div class="search-container">
        <input 
            type="text" 
            id="searchInput" 
            class="search-input"
            placeholder="Cari film..."
        >
        <button type="submit" 
            class="inline-block bg-blue-500 hover:bg-green-600 px-6 py-2 rounded-lg text-white text-lg font-semibold 
            shadow-md hover:shadow-lg transition-all duration-300" onClick=search()>Search
        </button>
        <span id="loading" class="loading">Mencari...</span>
    </div>

    <div id="movieResults">
        <!-- Hasil pencarian akan ditampilkan di sini -->
    </div>

    <div class="flex items-center mt-10 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">List Film Populer</h1>
        
        <form action="get_list.php" method="GET">
            <button type="submit" name="getMov" id="getMovList" 
            class="inline-block bg-blue-500 hover:bg-green-600 
            text-white px-6 py-2 rounded-lg text-lg font-semibold 
            shadow-md hover:shadow-lg transition-all duration-300">Select</button>
        </form>
    </div>

</body>
</html>

