# POC for ELMO Thrift RPC Microservices Framework #

Steps
------------------
 1. run `composer install` (if you get any error, esp. on windows, try running that command in windows command prompt. not git-bash)
 2. run the server with `bin/console server:run localhost:8080`
 3. in a separate terminal, browse to directory `cd ThriftClient`
 4. run the client `php PhpClient.php --http`

 You should see the following output
 
 ```
ping()
1+1=2
InvalidOperation: Cannot divide by 0
15-10=5
Log: PHP is stateless!
```

Enjoy!