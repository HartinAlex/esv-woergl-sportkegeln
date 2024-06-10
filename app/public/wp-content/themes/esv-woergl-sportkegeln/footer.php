        <footer class="site-footer">
        <div class="site-footer__inner container container--narrow">
            <div class="group">
                <div class="site-footer__col-one">
                    <h1 class="school-logo-text school-logo-text--alt-color">
                    <a href="<?php echo site_url() ?>"><strong>ESV Wörgl</strong> - Sportkegeln</a>
                    </h1>
                    <p><a class="site-footer__link" href="#">555.555.5555</a></p>
                </div>

                <div class="site-footer__col-two-three-group">
                    <div class="site-footer__col-two">
                    <h3 class="headline headline--small">Explore</h3>
                    <nav class="nav-list">
                        <!-- <ul>
                        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 13) echo 'class="current-menu-item"'; ?>><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                        <li><a href="#">Programs</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Campuses</a></li>
                        </ul> -->
<?php                   wp_nav_menu(array(
                            'theme_location' => 'footerLocationOne'
                        )); ?>
                    </nav>
                    </div>

                    <div class="site-footer__col-three">
                    <h3 class="headline headline--small">Learn</h3>
                    <nav class="nav-list">
                        <!-- <ul>
                        <li><a href="#">Legal</a></li>
                        <li><a href="<?php echo site_url('/privacy-policy') ?>">Privacy</a></li>
                        <li><a href="#">Careers</a></li>
                        </ul> -->
<?php                   wp_nav_menu(array(
                            'theme_location' => 'footerLocationTwo'
                        )); ?>
                    </nav>
                    </div>
                </div>
            </div>
        </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>