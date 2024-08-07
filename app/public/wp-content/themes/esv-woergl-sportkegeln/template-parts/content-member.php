<li class="player-card__list-item">
    <a class="player-card" href="<?php the_permalink(); ?>">
        <img class="player-card__image" src="<?php the_post_thumbnail_url('memberLandscape'); ?>">
        <span class="player-card__name"><?php echo get_field('lastname') . ' ' . get_field('firstname'); ?></span>
    </a>
</li>