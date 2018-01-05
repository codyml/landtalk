<?php

/*
*   Page template for a single Conversation post.
*/

get_header();
while ( have_posts() ): the_post();

    


?>

<!-- Images -->
<div class="full-bleed-container">
    <div class="columns is-gapless">
        <div class="column is-half">
            <div class=" conversation-image" style="background-image: url('<?php echo get_field('historical_image')['image_file']['url']; ?>');"></div>
        </div>
        <div class="column is-half">
            <div class=" conversation-image" style="background-image: url('<?php echo get_field('current_image')['image_file']['url']; ?>');"></div>
        </div>
    </div>
</div>

<!-- Image Titles -->
<div class="container conversation-image-titles">
    <div class="columns is-centered">
        <div class="column is-5 has-text-left">
            <div class="has-text-weight-bold"><?php the_field('place_name'); ?>, <?php echo get_field('historical_image')['year_taken']; ?></div>
            <div class="conversation-image-description"><?php echo get_field('historical_image')['description']; ?></div>
        </div>
        <div class="column is-2"></div>
        <div class="column is-5 has-text-right">
            <div class="has-text-weight-bold"><?php the_field('place_name'); ?>, <?php echo get_field('current_image')['year_taken']; ?></div>
            <div class="conversation-image-description"><?php echo get_field('current_image')['description']; ?></div>
        </div>
    </div>
</div>

<!-- Post Title -->
<div class="container">
    <div class="columns level">
        <div class="column is-7 level-item is-size-2 has-text-weight-light"><?php the_field('place_name'); ?></div>
        <a href="/conversations/#<?php the_ID(); ?>" class="column is-5 level-item react-component mini-conversation-map" data-component-name="MiniConversationMap" data-post-id="<?php the_ID(); ?>"></a>
    </div>
</div>

<!-- Conversation Section -->
<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 collapsible-section">
            <div class="section-title is-size-4 has-text-weight-light">Conversation</div>
            <hr>
            <div class="columns">
                <div class="column is-two-thirds">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo landtalk_get_youtube_embed( get_field('youtube_url') ); ?>?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                </div>
                <div class="column is-one-third">
                    <div><?php the_field('summary'); ?></div>
                    <br>
                    <div class="conversation-meta">
                        <?php if ( get_field('observer_full_name') ): ?>
                            <strong>Observer: </strong><?php the_field('observer_full_name'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="conversation-meta"><strong>Interviewer: </strong><?php the_field('interviewer_full_name'); ?></div>
                    <div class="conversation-meta"><strong>Interview Date: </strong><?php the_field('date'); ?></div>
                    <div class="conversation-meta"><strong>Submission Date: </strong><?php the_date(); ?></div>
                    <div class="conversation-meta"><strong>Keywords: </strong><? echo implode( ', ', landtalk_get_keywords( $post ) ); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About This Place Section -->
<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 collapsible-section">
            <div class="section-title is-size-4 has-text-weight-light">About This Place</div>
            <hr>
            <div class="conversation-response">
                <strong>Historic Appearance</strong>
                <div><?php the_field('used_to_look'); ?></div>
            </div>
            <div class="conversation-response">
                <strong>Changes over Time</strong>
                <div><?php the_field('has_changed'); ?></div>
            </div>
            <div class="conversation-response">
                <strong>Historic Activities</strong>
                <div><?php the_field('used_to_do_here'); ?></div>
            </div>
            <div class="conversation-response">
                <strong>Current Activities</strong>
                <div><?php the_field('does_here_now'); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Share & Report -->
<div class="container">
    <div class="columns is-centered">
        <div class="column is-one-third">
            <div class="level">
                <div class="level-item">
                    <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
                </div>
                <div class="level-item">
                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-size="large">Tweet</a>
                </div>
                <div class="level-item">
                    <a href="mailto:?subject=Land%20Talk%20Conversation&body=<?php the_permalink(); ?>" class="email-share-link">share by email</a>
                </div>
            </div>
        </div>
    </div>
    <div class="columns is-centered">
        <div class="column is-two-thirds has-text-centered">
            <a href="/report-conversation?conversation=<?php the_ID(); ?>" class="has-text-grey is-underlined">If this conversation violates Land Talk submission standards, click here to report it.</a>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
