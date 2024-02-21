const express = require('express');
const jwt = require('jsonwebtoken');
const router = express.Router();

router.get('/admin', (req, res) => {
    res.render('admin');
});

router.post('/admin', (req, res) => {
    const user = { id: 1 }; // Giả sử đã xác thực thành công
    const token = jsonwebtoken.sign({ user }, 'your-secret-key');
    res.cookie('auth-token', token);
    res.redirect('/admin-dashboard');
});

module.exports = router;