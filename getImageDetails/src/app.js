const cors = require('cors');

const express = require('express');
const app = express();

app.use(cors());

app.use((req, res, next) => {
    express.json()(req, res, err => {
        if (err) {
            console.error(err);

            // Bad Request
            res.status(400).json({
                statusCode: 400,
                message: "Bad Request"
            });
        }

        next();
    })
})

const anaRoute = require("./routes/AnaRoute");
app.use('/api/ana', anaRoute);

module.exports = app;