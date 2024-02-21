const express = require('express');
const app = express();
const path = require('path');
app.use(express.json()); 
app.use(express.urlencoded({ extended: true })); 
const authController = require('./src/controllers/authController');

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, '/src/views'));

const jwt = require('jsonwebtoken');

// Serve static files from the "public" folder
app.use(express.static('public'));

// Controllers
app.use(authController);

// Start the server
const port = 5000;
app.listen(port, () => {
  console.log(`Server is running on port http://localhost:${port}`);
});
