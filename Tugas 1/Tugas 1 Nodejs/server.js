require('dotenv').config(); // Load environment variables
const express = require('express');
const movieRoutes = require('./src/routes/movieRoutes')

const app = express();
const port = process.env.PORT || 3001;


//Middleware
app.use(express.json());                //Middleware untuk parsing request JSON
app.use(express.static("src/public"));  // Serve static files
app.set('view engine', 'ejs');          // Set EJS as view engine (Templating engine like PHP in original)
app.set('views', './src/views');        //Menentukan folder untuk file template

//Routes
app.use ('/', movieRoutes);

app.get('/', (req, res) => {
    res.redirect('/');
});

app.listen(port, () => {
  console.log(`Server berjalan di http://localhost:${port}`);
})