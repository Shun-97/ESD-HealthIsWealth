import socket
import os
from threading import Thread, Lock
import _thread

clients = set()
clients_lock = Lock()

def listener(client, address):
    print("Accepted connection from: ", address)
    with clients_lock:
        clients.add(client)
    try:    
        while True:
            data = client.recv(1024)
            if not data:
                break
            else:
                print(repr(data))
                with clients_lock:
                    for c in clients:
                        c.sendall(data)
    finally:
        with clients_lock:
            clients.remove(client)
            client.close()

host ='localhost'
port = 12345

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
s.bind((host,port))
s.listen(3)
th = []

while True:
    print("Server is listening for connections...")
    client, address = s.accept()
    th.append(Thread(target=listener, args = (client,address)).start())

s.close()