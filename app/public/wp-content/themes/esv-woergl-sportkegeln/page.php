<?php
    get_header(); 

    while(have_posts()) {
        the_post(); ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/esv-header-small.jpg') ?>)"></div>
                <div class="page-banner__content container container--narrow">
                    <h1 class="page-banner__title"><?php the_title(); ?></h1>
                    <div class="page-banner__intro">
                    <p>DONT FORGET TO REPLACE ME LATER</p>
                </div>
            </div>
        </div>

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
<?php               if ($theParent == 44) { ?>
                        <div>
                        <h2 class="headline headline--medium">Spieltag F1</h2>
                        <table>
                                <tr>
                                    <th>Heim</th>
                                    <th>Gast</th>
                                    <th>SP Heim</th>
                                    <th>SP Gast</th>
                                    <th>MAP Heim</th>
                                    <th>MAP Gast</th>
                                    <th>Punkte Heim</th>
                                    <th>Punkte Gast</th>
                                </tr>
<?php                           for ($index = 1; $index < 5; $index++) { ?>
                                    <tr  <?php if ($index % 2 == 0) { echo 'class="tr-bg-color"'; } ?>>
                                        <td>ESV Wörgl</td>
                                        <td>ESV Kufstein</td>
                                        <td>8</td>
                                        <td>4</td>
                                        <td>6</td>
                                        <td>2</td>
                                        <td>2</td>
                                        <td>0</td>
                                    </tr>
<?php                           } ?>
                            </table>
                        </div>    
                        <hr class="section-brake">
                        <div>
                        <h2 class="headline headline--medium">Tabelle</h2>
                            <table style="width: 100%">
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
<?php                           for ($index = 1; $index < 9; $index++) { ?>
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
<?php                           } ?>
                            </table>
                        </div>
<?php               }  
                    else {
                        the_content();
                    }
?>
                </div>
            </div>
<?php
    }
    get_footer();
?>