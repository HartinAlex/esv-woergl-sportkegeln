<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left">
          <a href="<?php echo site_url() ?>"><strong>ESV Wörgl </strong> - Sportkegeln</a>
        </h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <ul>
              <li><a href="<?php echo site_url() ?>">Start</a></li>
              <li><a href="<?php echo site_url('/about-us') ?>">Unser Verein</a></li>
              <li><a href="<?php echo site_url('/meisterschaft'); ?>">Tabellen und Ergebnisse</a></li>
              <li><a href="<?php echo site_url('/gallerie'); ?>">Galerie</a></li>
              <li><a href="#">Kontakt</a></li>
            </ul>
<!-- <?php       wp_nav_menu(array(
              'theme_location' => 'headerMenuLocation'
            )); ?> -->
          </nav>
          <div class="site-header__util">
            <a href="<?php echo site_url('/wp-admin') ?>" target="_blank" class="btn btn--small btn--orange float-left push-right">Login</a>
            <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </header>