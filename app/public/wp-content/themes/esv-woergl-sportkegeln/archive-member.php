<?php
  get_header(); ?>

  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/esv-header-small.jpg') ?>)"></div>
          <div class="page-banner__content container container--narrow">
              <h1 class="page-banner__title">Alle aktiven Spieler</h1>
              <div class="page-banner__intro">
              <p>Hier findest du eine Liste aller aktiven Sportkegler</p>
          </div>
      </div>
  </div>

  <div class="container container--narrow page-section">
    <ul class="player-cards">
<?php 
        // $activePlayer = new WP_Query(array(
        //     'posts_per_page' => -1,
        //     'post_type' => 'member',
        //     'meta_key' => 'active_player',
        //     'orderby' => 'meta_value',
        //     'order' => 'ASC',
        //     'meta_query' => array(
        //       array(
        //         'key' => 'active_player',
        //         'compare' => '==',
        //         'value' => true
        //       )
        //     )
        //   )); 
        while(have_posts()) {
            the_post();  ?>
            <li>
                <a href="<?php the_permalink(); ?>" class="player-card">
                    <img class="player-card__image" src="<?php the_post_thumbnail_url('profile_picture'); ?>" />
                    <?php the_title(); ?>
                </a>
            </li>
<?php   } ?> 
    </ul>
  </div>
<?php get_footer();
?>