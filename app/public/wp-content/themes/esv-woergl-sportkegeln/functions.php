<?php
    require get_theme_file_path('/inc/search-route.php');

    function esv_custom_rest() {
        register_rest_field('post', 'authorName', array(
            'get_callback' => function() {return get_the_author();}
        ));
    }
    add_action('rest_api_init', 'esv_custom_rest');

    function pageBanner($args = NULL) {
         if (!isset($args['title'])) {
            $args['title'] = get_the_title();
         }

         if (!isset($args['subtitle'])) {
            $args['subtitle'] = get_field('page_banner_subtitle');
         }

         if (!isset($args['photo'])) {
            if (get_field('page_banner_background_image') AND !is_archive() AND !is_home()) {
                $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
            }
            else {
                $args['photo'] = get_theme_file_uri('/images/esv-header-small.jpg');
            }
         }
         ?>
         <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
                <div class="page-banner__content container container--narrow">
                    <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
                    <div class="page-banner__intro">
                    <p><?php echo $args['subtitle']; ?></p>
                </div>
            </div>
        </div>
<?php }

    function esv_files() {
        wp_enqueue_script('main-esv-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        //wp_enqueue_script('custom-esv-chart-js', get_theme_file_uri('/src/modules/GoogleChart.js'));
       // wp_enqueue_script('custom-esv-chart-js', 'https://www.gstatic.com/charts/loader.js');
        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('esv_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('esv_extra_styles', get_theme_file_uri('/build/index.css'));

        wp_localize_script('main-esv-js', 'esvData', array(
            'root_url' => get_site_url(),
            'nonce' => wp_create_nonce('wp_rest')
        ));

    }
    add_action('wp_enqueue_scripts', 'esv_files');

    function esv_features() {
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerLocationOne', 'Footer Location One');
        register_nav_menu('footerLocationTwo', 'Footer Location Two');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_image_size('memberLandscape', 400, 260, true);
        add_image_size('memberPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
    }
    add_action('after_setup_theme', 'esv_features');

    function esv_adjust_queries($query) {
        if (!is_admin() and is_post_type_archive('member') and $query->is_main_query() ) {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
            $query->set('meta_query', array(
                array(
                    'key' => 'active_player',
                    'compare' => '==',
                    'value' => true
                )
            ));
        }

        if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
            $today = date('Ymd');
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                )
                ));
        }
    }
    add_action('pre_get_posts','esv_adjust_queries');

    // Redirect subscriber accounts out of admin and onto homepage
    function redirectSubsToFrontend() {
        $currentUser = wp_get_current_user();
        if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
            wp_redirect(site_url('/'));
            exit;
        }
    }
    add_action('admin_init', 'redirectSubsToFrontend');

    function noSubsAdminBar() {
        $currentUser = wp_get_current_user();
        if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
            show_admin_bar(false);
        }
    }
    add_action('wp_loaded', 'noSubsAdminBar');

    // Customize Login Screen
    function customHeaderUrl() {
        return esc_url(site_url('/'));
    }
    add_filter('login_headerurl', 'customHeaderUrl');

    function customLoginCSS() {
        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('esv_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('esv_extra_styles', get_theme_file_uri('/build/index.css'));
    }
    add_action('login_enqueue_scripts', 'customLoginCSS');

    function customLoginTitle() {
        return get_bloginfo('name');
    }
    add_filter('login_headertitle', 'customLoginTitle');

    // Force note posts to be private
    function makeNotePrivate($data) {
        if ($data['post_type'] == 'note') {
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
            $data['post_status'] = "private";
        }
        
        return $data;
    }
    add_filter('wp_insert_post_data', 'makeNotePrivate');


