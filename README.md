# log
showes how to use function "register_shutdown_function" and "fastcgi_finish_request" to build php log

日志是任何系统都必须要具备的基本功能，特别是功能上线后，为了系统安全必须屏蔽所有错误，并且记录日志到文件，以便维护系统。
# 1. register_shutdown_function
当我们要做一个日志功能时，php里面的register_shutdown_function函数就非常合适，在此函数里面注册的callback，会在脚本执行
完成或者eixt()或者意外退出时被调用。
# 2. fastcgi_finish_request
当我们注册退出函数，并且在函数里面做写日志的操作时，用户端浏览器并不能得到服务端的响应，必须要等到服务端写完日志才可以得到响应，
也就是说register_shutdown_function中注册的函数的执行时间点为脚本代码执行完后，返回客户端响应前，然而写日志操作，对用户来说没有任何
意义，却直接的拖慢了响应的速度，此时我们可以使用fastcgi_finish_request函数来提前把用户需要的数据响应给用户，而写日志的php进程则在后台
继续执行,不过这里要特别注意，此方法只在fpm环境下存在，另外根据php手册，因为继续运行的php进程没有结束，可能会造成fpm进程池全部用光，而出现
apache无法和fpm通讯的情况，而且还可能要注意，session的处理，因为会堵塞后面的请求，手册提示如下：

There are some pitfalls  you should be aware of when using this function.

The script will still occupy a FPM process after fastcgi_finish_request(). So using it excessively for long running tasks may occupy all your FPM threads up to pm.max_children. This will lead to gateway errors on the webserver.

Another important thing is session handling. Sessions are locked as long as they're active (see the documentation for session_write_close()). This means subsequent requests will block until the session is closed.

You should therefore call session_write_close() as soon as possible (even before fastcgi_finish_request()) to allow subsequent requests and a good user experience.

This also applies for all other locking techniques as flock or database locks for example. As long as a lock is active subsequent requests might bock.
