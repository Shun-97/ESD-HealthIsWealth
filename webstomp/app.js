const express = require('express');
const webstomp = require('webstomp-client');
const WebSocket = require('ws');

const app = express();
const port = 8889;
const client = webstomp.over(new WebSocket('ws://127.0.0.1:15674/ws'));

function onError(user, err){
    console.log(`Disconnected`, user.name, error);

}

// let message = `Hi tang ina mo `;
function onConnect(user, err){
    console.log(`Connected`, user.name);
    // client.send('/exchange/web-service-endpoint', message, {'content-type' : 'text/plain'});
}

client.connect('guest','guest', onConnect, onError, '/');

app.listen(port, () => console.log(`App listening on port ${port}`));