<?php
    get_header();  

    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('team');?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Alle Mannschaften
                    </a> 
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <div class="generic-content">
<?php           the_field('main_body_content'); ?>
            </div>

<?php       $relatedPlayer = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'member',
            'meta_key' => 'lastname',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                'key' => 'related_team',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
                )
            )
            ));        

            if ($relatedPlayer->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Spieler</h2>'; 
                
                echo '<ul class="player-cards">';
                while ($relatedPlayer->have_posts()) {
                    $relatedPlayer->the_post(); 
                    ?>
                    <li class="player-card__list-item">
                        <a class="player-card" href="<?php the_permalink(); ?>">
                            <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                            <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                       </a>
                    </li>
<?php           }
                echo '</ul>';
            }
            wp_reset_postdata();

            $relatedLeague = get_field('related_league');      

            if ($relatedLeague) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Liga</h2>';
                echo '<ul class="link-list min-list">';
                foreach($relatedLeague as $league) { ?>
                    <li><a href="<?php echo get_the_permalink($league); ?>"><?php echo get_the_title($league); ?></a></li>
<?php               } 
                echo '</ul>'; 
            } ?>
        </div>
<?php }
    get_footer();
?>