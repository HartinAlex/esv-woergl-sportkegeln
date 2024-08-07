<?php
    get_header(); 

    while(have_posts()) {
        the_post(); 
        pageBanner(array(
            'title' => get_the_title(),
            'subtitle' => "page-aktive-spieler.php"
        ));
        ?>

            <div class="container container--narrow page-section">

<?php           $theParent = wp_get_post_parent_id(get_the_ID());
                if ($theParent) { ?>
                    <div class="metabox metabox--position-up metabox--with-home-link">
                        <p>
                            <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Zurück zu <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
                        </p>
                    </div>
<?php           }
                
                $testArray = get_pages(array(
                    'child_of' => get_the_ID()
                ));

                if ($theParent or $testArray) { ?>
                    <div class="page-links">
                        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent); ?></a></h2>
                        <ul class="min-list">
<?php
                            if ($theParent) { 
                                $findChildrenOf = $theParent;
                            } else {
                                $findChildrenOf = get_the_ID();
                            }

                            wp_list_pages(array(
                                'title_li' => NULL,
                                'child_of' => $findChildrenOf,
                                'sort_column' => 'menu_order'
                            ));
?>
                        </ul>
                    </div>
<?php           } ?>

                <div class="generic-content">
<?php
                    $relatedFemalePlayer = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'member',
                        'meta_key' => 'lastname',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'gender',
                            'compare' => '==',
                            'value' => 'female'
                            ),
                            array(
                                'key' => 'active_player',
                                'compare' => '==',
                                'value' => true
                            ),
                            array(
                                'key' => 'youth_player',
                                'compare' => '!=',
                                'value' => true
                            )
                        )
                    ));   

                    $relatedMalePlayer = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'member',
                        'meta_key' => 'lastname',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'gender',
                            'compare' => '==',
                            'value' => 'male'
                            ),
                            array(
                                'key' => 'active_player',
                                'compare' => '==',
                                'value' => true
                            ),
                            array(
                                'key' => 'youth_player',
                                'compare' => '!=',
                                'value' => true
                            )
                        )
                    )); 
                
                    if ($relatedFemalePlayer->have_posts()) {
                        echo '<h2 class="headline headline--small">Spielerinnen</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($relatedFemalePlayer->have_posts()) {
                            $relatedFemalePlayer->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                            </li>
                <?php           }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }
                
                    if ($relatedMalePlayer->have_posts()) {
                        echo '<h2 class="headline headline--small">Spieler</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($relatedMalePlayer->have_posts()) {
                            $relatedMalePlayer->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                            </li>
                <?php           }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }
                
                    wp_reset_postdata();
?>
                </div>
                
            </div>
<?php
    }
    get_footer();
?>