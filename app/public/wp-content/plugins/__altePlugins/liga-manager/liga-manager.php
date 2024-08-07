<?php
/*
* Plugin Name: Liga Manager
* Description: Plugin zur Verwaltung eines Ligabetriebs.
* Version: 1.0
* Author: AlexH
*/

if (!defined('ABSPATH')) {
    exit;
}

function liga_manager_register_post_types() {

    // Post Type für die Mannschaften
    register_post_type('mannschaften', array(
        'capability_type' => 'mannschaft',
        'map_meta_cap' => true,
        'labels' => array(
            'name' => __('Mannschaften'),
            'singular_name' => __('Mannschaft'),
            'add_new_item' => __('Neue Mannschaft hinzufügen'),
            'edit_item' => __('Mannschaft bearbeiten'),
            'all_items' => __('Alle Mannschaften'),
            'add_new' => __('Neue Mannschaft hinzufügen')
        ),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'mannschaften'),
        'menu_icon' => 'dashicons-groups',
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail')
    ));

    // Post Type für die Spiele
    register_post_type('spiele', array(
        'capability_type' => 'spiel',
        'map_meta_cap' => true,
        'labels' => array(
            'name' => __('Spiele'),
            'singular_name' => __('Spiel'),
            'add_new_item' => __('Neues Spiel hinzufügen'),
            'edit_item' => __('Spiel bearbeiten'),
            'all_items' => __('Alle Spiele'),
            'add_new' => __('Neues Spiel hinzufügen')
        ),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'spiele'),
        'menu_icont' => 'dashicons-',
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'page-attributes')
    ));
}

add_action('init', 'liga_manager_register_post_types');

function liga_manager_add_meta_boxes() {
    add_meta_box(
        'spiel_details',
        __('Spiel Details'),
        'liga_manager_render_spiel_details',
        'spiel',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'liga_manager_add_meta_boxes');

function liga_manager_render_spiel_details($post) {
    wp_nonce_field(basename(__FILE__), 'liga_manager_nonce');
    $game_date = get_post_meta($post->ID, '_game_date', true);
    $home_team = get_post_meta($post->ID, '_home_team', true);
    $away_team = get_post_meta($post->ID, '_away_team', true);
    $result = get_post_meta($post->ID, '_result', true);
    ?>
    <p>
        <label for="game_date"><?php _e('Game Date:', 'liga_manager'); ?></label>
        <input type="date" id="game_date" name="game_date" value="<?php echo esc_attr($game_date); ?>" />
    </p>
    <p>
        <label for="home_team"><?php _e('Home Team:', 'liga_manager'); ?></label>
        <input type="text" id="home_team" name="home_team" value="<?php echo esc_attr($home_team); ?>" />
    </p>
    <p>
        <label for="away_team"><?php _e('Away Team:', 'liga_manager'); ?></label>
        <input type="text" id="away_team" name="away_team" value="<?php echo esc_attr($away_team); ?>" />
    </p>
    <p>
        <label for="result"><?php _e('Result:', 'liga_manager'); ?></label>
        <input type="text" id="result" name="result" value="<?php echo esc_attr($result); ?>" />
    </p>
    <?php
}

function liga_manager_save_game_details($post_id) {
    // Prüfe Nonce-Field
    if (!isset($_POST['liga_manager_nonce']) || !wp_verify_nonce($_POST['liga_manager_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Speichere Metadaten
    $game_date = sanitize_text_field($_POST['game_date']);
    $home_team = sanitize_text_field($_POST['home_team']);
    $away_team = sanitize_text_field($_POST['away_team']);
    $result = sanitize_text_field($_POST['result']);

    update_post_meta($post_id, '_game_date', $game_date);
    update_post_meta($post_id, '_home_team', $home_team);
    update_post_meta($post_id, '_away_team', $away_team);
    update_post_meta($post_id, '_result', $result);
}

add_action('save_post', 'liga_manager_save_game_details');

function liga_manager_games_shortcode($atts) {
    $args = array(
        'post_type' => 'game',
        'posts_per_page' => -1
    );
    $games = new WP_Query($args);
    $output = '<div class="liga-games">';
    while ($games->have_posts()) : $games->the_post();
        $game_date = get_post_meta(get_the_ID(), '_game_date', true);
        $home_team = get_post_meta(get_the_ID(), '_home_team', true);
        $away_team = get_post_meta(get_the_ID(), '_away_team', true);
        $result = get_post_meta(get_the_ID(), '_result', true);
        $output .= '<div class="game">';
        $output .= '<h2>' . get_the_title() . '</h2>';
        $output .= '<p>' . __('Date: ', 'liga_manager') . $game_date . '</p>';
        $output .= '<p>' . __('Home Team: ', 'liga_manager') . $home_team . '</p>';
        $output .= '<p>' . __('Away Team: ', 'liga_manager') . $away_team . '</p>';
        $output .= '<p>' . __('Result: ', 'liga_manager') . $result . '</p>';
        $output .= '</div>';
    endwhile;
    $output .= '</div>';
    wp_reset_postdata();
    return $output;
}
add_shortcode('liga_games', 'liga_manager_games_shortcode');