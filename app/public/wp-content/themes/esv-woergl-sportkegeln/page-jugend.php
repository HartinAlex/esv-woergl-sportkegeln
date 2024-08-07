<?php
    get_header(); 

    while(have_posts()) {
        the_post(); 
        pageBanner(array(
            'title' => get_the_title(),
            'subtitle' => "page-jugend.php"
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
<?php               $youthPlayerU10 = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'member',
                        'meta_key' => 'lastname',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'altersklasse',
                            'compare' => '==',
                            'value' => 'U10'
                            ),
                            array(
                                'key' => 'youth_player',
                                'compare' => '==',
                                'value' => true
                            )
                        )
                    ));  

                    $youthPlayerU15 = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'member',
                        'meta_key' => 'lastname',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'altersklasse',
                            'compare' => '==',
                            'value' => 'U15'
                            ),
                            array(
                                'key' => 'youth_player',
                                'compare' => '==',
                                'value' => true
                            )
                        )
                    ));

                    $youthPlayerU19 = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'member',
                        'meta_key' => 'lastname',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'altersklasse',
                            'compare' => '==',
                            'value' => 'U19'
                            ),
                            array(
                                'key' => 'youth_player',
                                'compare' => '==',
                                'value' => true
                            )
                        )
                    ));

                    if ($youthPlayerU10->have_posts()) {
                        echo '<h2 class="headline headline--small">Altersklasse U10</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($youthPlayerU10->have_posts()) {
                            $youthPlayerU10->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                                </a>
                            </li>
<?php                   }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }  

                    if ($youthPlayerU15->have_posts()) {
                        echo '<h2 class="headline headline--small">Altersklasse U15</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($youthPlayerU15->have_posts()) {
                            $youthPlayerU15->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                                </a>
                            </li>
<?php                   }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }  

                    if ($youthPlayerU19->have_posts()) {
                        echo '<h2 class="headline headline--small">Altersklasse U19</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($youthPlayerU19->have_posts()) {
                            $youthPlayerU19->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                            </li>
<?php                   }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }

                    wp_reset_postdata(); ?>
                </div>
                
            </div>
<?php
    }
    get_footer();
?>