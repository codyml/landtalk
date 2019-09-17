<?php

/*
*   Slightly-modified function that calculates distance on Earth
*   between two lat/lng pairs.  Source: https://stackoverflow.com/a/10054282
*/

function landtalk_haversine_great_circle_distance(
    $latitude_from,
    $longitude_from,
    $latitude_to,
    $longitude_to
) {

    $lat_from = deg2rad( $latitude_from );
    $lon_from = deg2rad( $longitude_from );
    $lat_to = deg2rad( $latitude_to );
    $lon_to = deg2rad( $longitude_to );

    $lat_delta = $lat_to - $lat_from;
    $lon_delta = $lon_to - $lon_from;

    $angle = 2 * asin( sqrt( pow( sin( $lat_delta / 2 ), 2 ) +
        cos( $lat_from ) * cos( $lat_to ) * pow( sin( $lon_delta / 2 ), 2 ) ) );

    return $angle * EARTH_RADIUS;

}


/*
*   Given a set of Conversations, returns the set for which the lat/lng
*   is within the given radius of the given lat/lng.
*/

function landtalk_filter_conversations_by_radius(
    $conversations,
    $radius_distance,
    $radius_latitude,
    $radius_longitude
) {

    return array_filter(
        $conversations,
        function( $conversation ) use (
            $radius_distance,
            $radius_latitude,
            $radius_longitude
        ) {

            $lat_lng = get_field( 'location', $conversation )['lat_lng'];
            $latitude_to = (float) $lat_lng['latitude'];
            $longitude_to = (float) $lat_lng['longitude'];
            $distance = landtalk_haversine_great_circle_distance(
                $radius_latitude,
                $radius_longitude,
                $latitude_to,
                $longitude_to
            );

            return $distance <= $radius_distance;

        }
    );
}
