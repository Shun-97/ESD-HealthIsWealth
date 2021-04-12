import socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect(('localhost', 12345))
s.sendall(b'Hello, world')
while True:
    data = s.recv(1024)
    print('Received', repr(data))
s.close()