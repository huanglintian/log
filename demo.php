<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 16/3/17
 * Time: 09:28
 */
if (!function_exists('fastcgi_finish_request()')) {
    function fastcgi_finish_request(){
    }
}

function alex()
{
    fastcgi_finish_request();
    sleep(9);
    file_put_contents('log.txt', date('Y-m-d H:i:s'));
}

echo "hello world";
register_shutdown_function('alex');