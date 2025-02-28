const express = require('express');
const router = express.Router();
const Project = require('../models/Project');

//---------------- GET ROUTES ----------------

/**
 * Home GET
 */
router.get('/', async (req, res) => {
    try {
        const locals = {
            title: 'Portfolio JS',
            description: 'Portfolio backend made in express'
        };

        let perPage = 2;
        let page = req.query.page || 1;

        const data = await Project.aggregate([{
            $sort: { createdAt: -1 }
        }])
        .skip(perPage * page - perPage)
        .limit(perPage)
        .exec();

        const count = await Project.countDocuments();
        const nextPage = parseInt(page) + 1;
        const hasNextPage = nextPage <= Math.ceil(count / perPage);

        res.render('index', {
            locals,
            data,
            current: page,
            nextPage: hasNextPage ? nextPage : null,
            currentRoute: '/'
        });
    } catch (error) {
        console.log(error);
    }
});

/**
 * Projects GET
 */
router.get('/projects/:id', async (req, res) => {
    try {
        let slug = req.params.id;
        const data = await Project.findById({
            _id: slug
        });
        const locals = {
            title: data.title,
            description: 'Portfolio backend made in express'
        };

        res.render('project', {
            locals,
            data,
            currentRoute: `/projects/{$slug}`
        });
    } catch (error) {
        console.log(error);
    }
});

/**
 * About GET
 */
router.get('/about', async (req, res) => {
    const locals = {
        title: 'About',
        description: 'Portfolio backend made in express'
    };

    res.render('about', {
        locals,
        currentRoute: `/about`,
    });
});

//---------------- POST ROUTES ----------------

/**
 * Search POST
 */
router.post('/search', async (req, res) => {
   try  {
       const locals = {
           title: 'Search',
           description: 'Portfolio backend made in express'
       }

       let searchTerm = req.body.searchTerm;
       const searchNoSpecialChars = searchTerm.replace(/[^a-zA-Z0-9 ]/g, "");

       const data = await Project.find({
           $or: [
               { title: { $regex: new RegExp(searchNoSpecialChars, 'i') }},
               { body: { $regex: new RegExp(searchNoSpecialChars, 'i') }}
           ]
       });

       res.render('search', {
          data,
          locals
       });
   } catch (error) {
       console.log(error);
   }
});

module.exports = router;