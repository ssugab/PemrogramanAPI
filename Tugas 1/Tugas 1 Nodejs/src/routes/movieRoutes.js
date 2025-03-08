const express = require('express');
const router = express.Router();
const { getPopularMovies, searchMovies } = require('../controllers/movieController');

// Route untuk halaman utama (pencarian)
router.get('/', (req, res) => {
    res.render('index');
});

// Route untuk halaman film populer
router.get('/popular', async (req, res) => {
    try {
        const movies = await getPopularMovies();
        res.render('popular', { movies });
    } catch (error) {
        res.status(500).render('popular', { 
            movies: [], 
            error: 'Terjadi kesalahan saat mengambil data film' 
        });
    }
});

// Route untuk pencarian film (API)
router.get('/search', async (req, res) => {
    try {
        const { query } = req.query;
        const results = await searchMovies(query);
        res.json(results);
    } catch (error) {
        res.status(500).json({ 
            error: 'Terjadi kesalahan saat mencari film' 
        });
    }
});

module.exports = router; 