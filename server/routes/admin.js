const express = require('express');
const router = express.Router();
const Project = require('../models/Project');
const User = require('../models/User');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const {locals} = require("express/lib/application");

const adminLayout = '../views/layouts/admin';
const jwtSecret = process.env.JWT_SECRET;

//---------------- MIDDLEWARE ----------------

const authMiddleware = (req, res, next) => {
    const token = req.cookies.token;

    if (!token) {
        return res.status(401).json({ message: 'Unauthorized' });
    }

    try {
        const decoded = jwt.verify(token, jwtSecret);
        req.userId = decoded.userId;
        next();
    } catch (error) {
        return res.status(401).json({ message: 'Unauthorized' });
    }
}

//---------------- GET ROUTES ----------------

/**
 * Admin GET
 */
router.get('/admin', async (req, res) => {
    try {
        const locals = {
            title: 'Admin',
            description: 'Administration'
        }
        res.render('admin/index', {
            locals,
            layout: adminLayout
        });
    } catch (error) {
        console.log(error);
    }
});

/**
 * Dashboard GET
 */
router.get('/dashboard', authMiddleware, async (req, res) => {
    try {
        const locals = {
            title: 'Dashboard',
            description: 'Dashboard'
        }

        const data = await Project.find();

        res.render('admin/dashboard', {
            locals,
            data,
            layout: adminLayout
        });
    } catch (error) {
        console.log(error);
    }
});

/**
 * Add project GET
 */
router.get('/add-project', authMiddleware, async (req, res) => {
    try {
        const locals = {
            title: 'Add Project',
            description: 'Dashboard'
        }

        const data = await Project.find();
        res.render('admin/add-project', {
            locals,
            data,
            layout: adminLayout
        });
    } catch (error) {
        console.log(error);
    }
});

/**
 * Edit project GET
 */
router.get('/edit-project/:id', authMiddleware, async (req, res) => {
   try {
       const locals = {
           title: 'Edit Project',
           description: 'Dashboard'
       }

       const data = await Project.findOne({ _id: req.params.id });

       res.render('admin/edit-project', {
           locals,
           data,
           layout: adminLayout
       })
   } catch (error) {
       console.log(error);
   }
});

router.get('/logout', authMiddleware, async (req, res) => {
    res.clearCookie('token');
    //res.json({ message: 'Logged Out' });
    res.redirect('/');
});

//---------------- POST ROUTES ----------------

/**
 * Admin POST
 */
router.post('/admin', async (req, res) => {
    try {
        const { username, password } = req.body;
        const user = await User.findOne({ username });

        if (!user) {
            return res.status(401).json({ message: 'Invalid credentials' });
        }

        const isPasswordValid = await bcrypt.compare(password, user.password);

        if (!isPasswordValid) {
            return res.status(401).json({ message: 'Invalid credentials' });
        }

        const token = jwt.sign(
            {userId: user._id},
            jwtSecret
        );
        res.cookie('token', token, { httpOnly: true });
        res.redirect('/dashboard');
    } catch (error) {
        console.log(error);
    }
});

/**
 * Register POST
 */
router.post('/register', async (req, res) => {
    try {
        const { username, password } = req.body;
        const hashedPassword = await bcrypt.hash(password, 10);

        try {
            const user = await User.create({
                username,
                password: hashedPassword,
            });
            res.status(201).json({ message: 'User registered successfully', user });
        } catch (error) {
            if (error.code === 11000) {
                res.status(409).json({message: 'User already registered'});
            }
            res.status(500).json({message: 'Something went wrong'});
        }
    } catch (error) {
        console.log(error);
    }
});

/**
 * Add-project POST
 */
router.post('/add-project', authMiddleware, async (req, res) => {
    try {
        try {
            const newProject = new Project({
                title: req.body.title,
                body: req.body.body
            });

            await Project.create(newProject);
            res.redirect('/dashboard');
        } catch (error) {
            console.log(error);
        }
    } catch (error) {
        console.log(error);
    }
});

/**
 * Edit-project POST
 */
router.post('/edit-project/:id', authMiddleware, async (req, res) => {
    try {
        try {
            await Project.findByIdAndUpdate(req.params.id, req.body, {
                title: req.body.title,
                body: req.body.body,
                updatedAt: Date.now()
            });

            res.redirect(`/edit-project/${req.params.id}`);
        } catch (error) {
            console.log(error);
        }
    } catch (error) {
        console.log(error);
    }
});

/**
 * Delete-project POST
 */
router.post('/delete-project/:id', authMiddleware, async (req, res) => {
    try {
        await Project.deleteOne({ _id: req.params.id });
        res.redirect(`/dashboard`);
    } catch (error) {
        console.log(error);
    }
});


module.exports = router;