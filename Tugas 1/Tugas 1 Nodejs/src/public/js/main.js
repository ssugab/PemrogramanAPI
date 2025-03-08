$(document).ready(function() {
    const searchInput = $('#searchInput');
    const searchButton = $('#searchButton');
    const loading = $('#loading');
    const movieResults = $('#movieResults');
    const selectPopularBtn = $('#selectPopularBtn');
    const popularMoviesTable = $('#popularMoviesTable');

    // Event handler untuk tombol search
    searchButton.on('click', function() {
        const query = searchInput.val().trim();
        
        if (query.length < 3) {
            movieResults.html('<p class="error">Masukkan minimal 3 karakter</p>');
            return;
        }

        loading.show();
        $.ajax({
            url: '/search',
            data: { query: query },
            method: 'GET',
            success: function(response) {
                loading.hide();
                displayResults(response);
            },
            error: function(xhr) {
                loading.hide();
                movieResults.html('<p class="error">Terjadi kesalahan saat mencari film</p>');
            }
        });
    });

    // Event handler untuk tombol Enter pada input
    searchInput.on('keypress', function(event) {
        if (event.which === 13) { // Kode 13 adalah tombol Enter
            searchButton.click(); // Trigger click pada tombol search
        }
    });

    selectPopularBtn.on('click', function() {
        if (popularMoviesTable.is(':visible')) {
            popularMoviesTable.hide();
        } else {
            $.ajax({
                url: '/popular',
                method: 'GET',
                success: function(response) {
                    popularMoviesTable.show();
                },
                error: function(xhr) {
                    popularMoviesTable.html('<p class="error">Terjadi kesalahan saat mengambil data film populer</p>');
                }
            });
        }
    });

    function displayResults(data) {
        if (!data.results || data.results.length === 0) {
            movieResults.html('<p>Tidak ada film ditemukan</p>');
            return;
        }

        let html = '<table>';
        html += `<tr>
            <th>No</th>
            <th>Judul Film</th>
            <th>Tanggal Rilis</th>
            <th>Rating</th>
            <th>Overview</th>
        </tr>`;

        data.results.forEach((movie, index) => {
            html += `<tr>
                <td>${index + 1}</td>
                <td>${movie.title}</td>
                <td>${movie.release_date || '-'}</td>
                <td>${movie.vote_average}</td>
                <td>${movie.overview || '-'}</td>
            </tr>`;
        });

        html += '</table>';
        movieResults.html(html);
    }
}); 