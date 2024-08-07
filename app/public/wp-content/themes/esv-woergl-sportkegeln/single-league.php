<?php
    get_header(); 
    while(have_posts()) {
        the_post(); 
        pageBanner(array(
            'title' => get_the_title(),
            'subtitle' => 'DONT FORGET TO REPLACE ME LATER - single-league.php'
        ));
        ?>

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('league')?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Meisterschaft
                    </a> 
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <!-- ##################################################################  -->
            <?php       
            $relatedTeam = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'team',
                'meta_key' => 'related_league',
                'orderby' => '',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'related_league',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"'
                    )
                )
            ));

            if ($relatedTeam->have_posts()) {
                while($relatedTeam->have_posts()) {
                    $relatedTeam->the_post(); ?>
                    <h2 class="headline headline--medium"><?php the_title(); ?></h2>    

  <?php              $relatedPlayer = new WP_Query(array(
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
                        echo '<h2 class="headline headline--small">Eingesetzte Spieler</h2>'; 
                        
                        echo '<ul class="player-cards">';
                        while ($relatedPlayer->have_posts()) {
                            $relatedPlayer->the_post(); 
                            ?>
                            <li class="player-card__list-item">
                                <a class="player-card" href="<?php the_permalink(); ?>">
                                    <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                                    <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
                                    <span class="player-card__name"><?php echo get_field('pass_number'); ?></span>
                            </a>
                            </li>
        <?php           }
                        echo '</ul>';
                        echo '<hr class="section-break">';
                    }
                }
            }
            
            
            wp_reset_postdata(); ?>

                    
            <h2 class="headline headline--medium"><strong>Runde</strong> F 1 </h2>
            <table class="league-table">
                    <tr>
                        <th>Heimteam</th>
                        <th>Gastteam</th>
                        <th>Satzpunkte</th>
                        <th>Mannschaftspunkte</th>
                        <th>Tabellenpunkte</th>
                    </tr>
<?php               for ($index = 1; $index < 5; $index++) { ?>
                        <tr  <?php if ($index % 2 == 0) { echo 'class="tr-bg-color"'; } ?>>
                            <td>ESV Wörgl</td>
                            <td>SPG SKVI Katzenberger II</td>
                            <td>8 : 4</td>
                            <td>6 : 2</td>
                            <td>2 : 0</td>
                        </tr>
<?php               } ?>
                </table>
                       
                <hr class="section-break">
                        
                <h2 class="headline headline--medium">Tabelle</h2>
                <table class="league-table">
                    <tr>
                        <th>Pl</th>
                        <th>Mannschaft</th>
                        <th>SP</th>
                        <th>S</th>
                        <th>U</th>
                        <th>N</th>
                        <th>SAP</th>
                        <th>Diff SAP</th>
                        <th>MAP</th>
                        <th>Diff MAP</th>
                        <th>Punkte</th>
                    </tr>
<?php               for ($index = 1; $index < 9; $index++) { ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td>ESV Wörgl</td>
                            <td>3</td>
                            <td>2</td>
                            <td>0</td>
                            <td>1</td>
                            <td>55:43</td>
                            <td>12</td>
                            <td>14:2</td>
                            <td>12</td>
                            <td>4</td>
                        </tr>
<?php               } ?>
                </table>
                        
        </div>
<?php
    }

    get_footer();
?>