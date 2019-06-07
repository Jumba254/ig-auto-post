<?php

require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;
use \PHPHtmlParser\Dom;

function get_random_image ($query) {
    file_put_contents('temp.jpg', file_get_contents('https://source.unsplash.com/featured/?'.$query));
}

function get_hashtag ($query,$ua) {
    $curl = new Curl();
    $curl->setUserAgent($ua);
    $curl->post('https://www.all-hashtag.com/library/contents/ajax_generator.php', array(
        'keyword' => $query,
        'filter' => 'random',
    ));
    $dom = new Dom;
    $dom->load($curl->response);
    return $dom->find('#copy-hashtags')[0]->text;
}

$arts = "
 _                         _                              _   
(_) __ _        __ _ _   _| |_ ___        _ __   ___  ___| |_ 
| |/ _` |_____ / _` | | | | __/ _ \ _____| '_ \ / _ \/ __| __|
| | (_| |_____| (_| | |_| | || (_) |_____| |_) | (_) \__ \ |_\
|_|\__, |      \__,_|\__,_|\__\___/      | .__/ \___/|___/\__|
   |___/                                 |_|                  
";
