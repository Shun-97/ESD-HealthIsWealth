#!/usr/bin/env python

import asyncio
import websockets

connected = set()

async def server(websocket, path):
    #register a new websocket
    connected.add(websocket)
    try:
        # Implement logic here.
        async for message in websocket:
            for conn in connected:
                if conn != websocket:
                    await conn.send(f'boo hoo new message here tang ina mo {message}')

    finally:
        # Unregister.
        connected.remove(websocket)
    

start_server = websockets.serve(server, "localhost", 8765)

asyncio.get_event_loop().run_until_complete(start_server)
asyncio.get_event_loop().run_forever()