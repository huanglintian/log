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
继续执行,不过这里要特别注意，此方法只在fpm环境下存在
