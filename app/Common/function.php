<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 22:27
 * description:
 */

function is_url($url)
{
    $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
    if (preg_match($r, $url)) {
        return true;
    } else {
        return false;
    }
}


function getUrlByPath($url) {
    if (!is_url($url)) {
        return  env("APP_URL").$url;
    }
    return $url;
}
