<?php

set_time_limit(0);
date_default_timezone_set('Asia/Jakarta');

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';
require __DIR__.'/function.php';

$climate = new \League\CLImate\CLImate;
$debug = false;
$truncatedDebug = false;
$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

// login
try {
    $ig->login($username, $password);
    // echo 'Login OK';
} catch (\Exception $e) {
    echo 'Login Error: '.$e->getMessage()."\n";
    die();
}

for ( $x=1; $x<$posting; $x++ ) {
    
    // clear screen
    $climate->clear();

    // print title
    $climate->lightYellow($arts);
    $config = [
        [
        'username: '.$username,
        'password: ***',
        'keyword: '.$keyword,
        'posting: '.$posting,
        ],
    ];
    $climate->table($config);
    $climate->br();

    // set set
    get_random_image($keyword);
    $photoFilename = 'temp.jpg';
    $ua = \Campo\UserAgent::random();

    if (!empty($caption)) {
        $captionText = $caption." ".get_hashtag($keyword,$ua);
    } else {
        $captionText = get_hashtag($keyword,$ua);
    }

    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
    
    try {

        // posting
        $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);   

        // print progress   
        $progress = [
            [
            'progress: '.$x.'/'.$posting,
            'status: posting ok!',
            'sleep: '.$sleep.' second',
            ]
        ];
        $climate->table($progress);
        $climate->br();

        // print hastag
        $climate->out($captionText);
        $climate->br();

    } catch (\Exception $e) {
        echo 'Posting Error: '.$e->getMessage()."\n";
        die();
    }

    sleep($sleep);

}
