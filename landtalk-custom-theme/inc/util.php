<?php

/*
*   Extracts YouTube ID from link and creates embed code.
*/

function landtalk_get_youtube_embed( $url ) {

    $re = "/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/ ]{11})/";
    $matches = array();
    preg_match( $re, $url, $matches );
    if ( isset( $matches[1] ) ) return $matches[1];

}
