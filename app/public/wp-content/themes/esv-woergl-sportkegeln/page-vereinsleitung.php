<?php
    get_header(); 

    while(have_posts()) {
        the_post(); 
        pageBanner(array(
            'title' => get_the_title(),
            'subtitle' => "page-vereinsleitung.php"
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
<?php           } 

                $relatedVorstand = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'member',
                    'meta_key' => 'vereinsleitung',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'vereinsleitung',
                            'compare' => '!=',
                            'value' => 'none'
                        )
                    )
                ));   
                
                while ($relatedVorstand->have_posts()) {
                    $relatedVorstand->the_post(); 
                    if (get_field('vereinsleitung') == "1_section_leader") {
                        echo '<h2 class="headline headline--small-plus">Sektionsleiter</h2>';
                        echo '<ul class="player-cards">'; ?>
                        <li class="player-card__list-item">
                            <a class="player-card" href="<?php the_permalink(); ?>">
                                <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                        </li>
<?php                   echo '<hr class="section-break">';
                    }

                    if (get_field('vereinsleitung') == "2_temp_section_leader") {
                        echo '<h2 class="headline headline--small-plus">Stellver. Sektionsleiter</h2>';
                        echo '<ul class="player-cards">'; ?>
                        <li class="player-card__list-item">
                            <a class="player-card" href="<?php the_permalink(); ?>">
                                <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                        </li>
<?php                   echo '<hr class="section-break">';
                    }

                    if (get_field('vereinsleitung') == "3_writer") {
                        echo '<h2 class="headline headline--small-plus">Schriftführer</h2>';
                        echo '<ul class="player-cards">'; ?>
                        <li class="player-card__list-item">
                            <a class="player-card" href="<?php the_permalink(); ?>">
                                <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                        </li>
<?php                   echo '<hr class="section-break">';
                    }

                    if (get_field('vereinsleitung') == "4_kassa") {
                        echo '<h2 class="headline headline--small-plus">Kassierer</h2>';
                        echo '<ul class="player-cards">'; ?>
                        <li class="player-card__list-item">
                            <a class="player-card" href="<?php the_permalink(); ?>">
                                <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                            </a>
                        </li>
<?php                   echo '<hr class="section-break">';
                    }
                }
                echo '</ul>';
?>                
            </div>
<?php
    }
    get_footer();
?>