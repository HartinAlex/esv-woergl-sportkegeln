<?php
  get_header(); 
  pageBanner(array(
    'title' => 'Alle aktiven Spieler',
    'subtitle' => 'Hier findest du eine Liste unserer aktiven Sportkegler'
  ));
?>

  <div class="container container--narrow page-section">
    <ul class="player-cards">
<?php while(have_posts()) {
        the_post();  ?>
        <li class="player-card__list-item">
            <a href="<?php the_permalink(); ?>" class="player-card">
                <!-- <img class="player-card__image" src="<?php the_post_thumbnail_url('profile_picture'); ?>" />
                <?php the_title(); ?> -->
                <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
                <span class="player-card__list-item"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span><br>
                <span class="player-card__list-item"><?php echo get_field('pass_number'); ?></span><br>
                <span class="player-card__list-item"><?php echo get_field('gender'); ?></span>
            </a>
        </li>
<?php } ?> 
    </ul>
  </div>
<?php get_footer();
?>