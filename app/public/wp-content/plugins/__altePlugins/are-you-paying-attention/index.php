<?php
    /*
        Plugin Name: Are You Paying Attention Plugin
        Description: Multiple Choice Question.
        Version: 1.0
        Author: Alex
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class AreYouPayingAttention {
        function __construct()
        {
            add_action('init', array($this, 'adminAssets'));
        }

        function adminAssets() {
            register_block_type(__DIR__, array(
                'render_callback' => array($this, 'theHTML')
            ));
        }

        function theHTML($attr) {
            // if(!is_admin()) {
            //     wp_enqueue_script('attentionfrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
            //     wp_enqueue_style('attentionfrontendstyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
            // }

            ob_start(); ?>
            <div class="paying-attention-update-me">
                <pre style="display: none;"><?php echo wp_json_encode($attr) ?></pre>
            </div>
<?php       return ob_get_clean();
        }
    }

    $areYouPayingAttention = new AreYouPayingAttention();