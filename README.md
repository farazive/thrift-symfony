# POC for Thrift RPC Microservices Framework over Sockets and HTTP #

Steps for communication via HTTP/Socket
------------------
 1. run `composer install` (if you get any error, esp. on windows, try running that command in windows command prompt. not git-bash)
 2. For communications via http run the server with `bin/console server:run`. For comms via socket, browse to 
 project folder `ThriftClient` and run `php ThriftComms/PhpSocketServer.php`
 4. In a terminal, run the client `php ThriftComms/PhpClient.php --http` if your server is listening over http or 
 run `php ThriftComms/PhpClient.php` if its listening over sockets. 

 You should see the following output
 
 ```
ping()
1+1=2
InvalidOperation: Cannot divide by 0
15-10=5
Log: PHP is stateless!
```

Enjoy!