<?php

/*
*   Registers the "caption" shortcode.
*/

function landtalk_caption_shortcode( $atts, $content = null ) {

    $content = wptexturize( $content );
    $content = wpautop( $content );
    $content = do_shortcode( $content );
    return '<div class="caption">' . $content . '</div>';

}

add_shortcode( 'caption', 'landtalk_caption_shortcode' );


/*
*   Registers the "conversation" shortcode.  Supports two styles:
*   "video" style, which shows the video with a caption, and "card"
*   style, which is used elsewhere on the site.
*/

function landtalk_conversation_shortcode( $atts ) {

    $a = shortcode_atts( array(
        'style' => 'card',
        'slug' => null,
    ), $atts );

    $conversation = get_page_by_path( $a['slug'], 'OBJECT', CONVERSATION_POST_TYPE );
    if ( empty( $conversation ) ) return;

    $output = '';
    if ( $a['style'] === 'card' ) {

        ob_start();
        ?>

<a href="<?php echo get_permalink( $conversation ); ?>" class="conversation-excerpt">
    <div class="card" style="width: 350px;">
        <div class="card-image">
            <figure class="image is-3by2" style="background-image: url(<?php echo get_field( 'historical_image', $conversation )['image_file']['url'] ?>);" />
        </div>
        <div class="card-content">
            <div class="is-size-5 has-text-weight-light has-space-below">
                <?php echo get_field( 'place_name', $conversation ); ?>
            </div>
            <div class="content">
                <?php echo wp_trim_words( get_field( 'summary', $conversation ), 35 ); ?>
            </div>
            <div class="link" href="<?php echo get_permalink( $conversation ); ?>">Click for conversation</div>
        </div>
    </div>
</a>

        <?php
        $output = ob_get_clean();

    } else if ( $a['style'] === 'video' ) {

        ob_start();
        ?>

<iframe width="100%" height="600" src="https://www.youtube.com/embed/<?php echo landtalk_get_youtube_embed( get_field( 'youtube_url', $conversation )['url'] ); ?>?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
<div class="caption">
    <strong><?php echo get_the_title( $conversation ); ?>: </strong>
    <span><?php echo get_field( 'summary', $conversation, false ); ?></span>
</div>

        <?php
        $output = ob_get_clean();

    }

    return $output;

}

add_shortcode( 'conversation', 'landtalk_conversation_shortcode' );
