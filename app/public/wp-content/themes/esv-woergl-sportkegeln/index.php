<?php
  get_header(); ?>

  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/esv-header-small.jpg') ?>)"></div>
          <div class="page-banner__content container container--narrow">
              <h1 class="page-banner__title">Willkommen in unserem Blog</h1>
              <div class="page-banner__intro">
              <p>Halten sie sich auf dem Laufenden...</p>
          </div>
      </div>
  </div>

  <div class="container container--narrow page-section">
<?php 
      while(have_posts()) {
        the_post(); ?>
        <div class="post-item">
          <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="metabox">
            <p>Erstellt von <?php the_author_posts_link(); ?> am <?php the_time('d.m.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
          </div>
          <div class="generic-content">
            <?php the_excerpt(); ?>
            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Mehr lesen >></a></p>
          </div>

        </div>
<?php } 
  echo paginate_links();
?> 
  </div>
<?php get_footer();
?>