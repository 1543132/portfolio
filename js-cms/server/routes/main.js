const express = require('express');
const router = express.Router();

// Routes
router.get('/', (req, res) => {
    const locals = {
        title: 'Portfolio JS',
        description: 'Portfolio backend made in express'
    };

    res.render('index', { locals });
});

router.get('/about', (req, res) => {
    res.render('about');
});

module.exports = router;