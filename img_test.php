<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 28/6/17
 * Time: 20:34
 */

//header("Content-type:text/html;charset=utf-8");

$str = '<img class="home-thumb" src="http://www.daixiaorui.com/Public/images/random/20.jpg" width="140px" height="100px" alt="php源码，小程序"/><p><img src="http://www.daixiaorui.com/Public/uploads/20130727/chat2.jpg" style="border:1px solid #aaa;" alt="PHP+Ajax"/><img  src=\'http://www.daixiaorui.com/Public/images/random/20.jpg\' width="140px" height="100px" alt="php源码，小程序"/></p><img src=http://www.daixiaorui.com/Public/images/random/20.jpg />';

$preg = '/(<img.*?src=[\"|\']?)(.*?)([\"|\']?\s.*?>)/i';

preg_match_all($preg, $str, $imgArr);

//echo preg_replace($preg,'${1}黄$3', $str);

echo preg_replace_callback($preg, function($matches){
    return $matches[1] . str_replace('http://', '', $matches[2]) . $matches[3];
}, $str);

//print_r($imgArr);