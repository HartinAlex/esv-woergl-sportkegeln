<?php
  get_header(); 
  pageBanner(array(
    'title' => 'Alle Termine',
    'subtitle' => 'Hier findest du alle anstehenden Termine - archive-event.php'
  ));  
?>

  <div class="container container--narrow page-section">
<?php 
      while(have_posts()) {
        the_post(); 
        get_template_part('template-parts/content-event');  
      } 
  echo paginate_links();
?> 
<hr class="section-break">
<p>Für eine übersicht der vergangengenen Veranstaltungen klicke <a href="<?php echo site_url('/past-events'); ?>">hier</a></p>
  </div>
<?php get_footer();
?>