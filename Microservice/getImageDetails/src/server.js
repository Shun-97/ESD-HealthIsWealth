const http = require('http');
const app = require('./app');

const port = process.env.PORT || 7100;

const server = http.createServer(app);
server.listen(port)