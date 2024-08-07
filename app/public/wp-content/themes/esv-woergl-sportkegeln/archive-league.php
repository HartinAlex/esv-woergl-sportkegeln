<?php
  get_header(); 
  pageBanner(array(
    'title' => 'Tabellen und Ergebnisse',
    'subtitle' => 'Hier findest du alle anstehenden Termine - archive-league.php'
  ));
?>

  <div class="container container--narrow page-section">
  <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_post_type_archive_link('league')?>">Meisterschaft</a></h2>
            <ul class="min-list">
<?php           
                wp_list_pages(array(
                    'title_li' => NULL,
                    'post_type' => 'league',
                    'sort_column' => 'menu_order'
                )); ?>
            </ul>
        </div>
        <div class="generic-content">
                Hier findest du alle Ergebnisse und Tabellen der einzelnen Ligen
        </div>
  </div>
<?php get_footer();
?>