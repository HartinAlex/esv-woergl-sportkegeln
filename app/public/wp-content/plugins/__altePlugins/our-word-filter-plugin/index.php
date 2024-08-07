<?php
    /*
        Plugin Name: Our Word Filter Plugin
        Description: Replaces a list of words.
        Version: 1.0
        Author: Alex
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class OurWordFilterPlugin {
        function __construct() {
            add_action('admin_menu', array($this, 'ourMenu'));
            if (get_option('plugin_words_to_filter')) add_filter('the_content', array($this, 'filterlogic'));

            add_action('admin_init', array($this, 'ourSettings'));
        }

        function ourSettings() {
            add_settings_section('replacement-text-section', null, null, 'word-filter-options');
            register_setting('replacementFields', 'replacementText');
            add_settings_field('replacement-text', 'filteredText', array($this, 'replacementFieldHTML'), 'word-filter-options', 'replacement-text-section');
        }

        function replacementFieldHTML() { ?>
            <input type="text" name="replacementText" value="<?php echo esc_attr(get_option('replacementText', '***')); ?>">
            <p class="description">Nichts eingragen, um die gefilterten Wörter zu entfernen</p>
<?php   }

        function ourMenu() {
            //add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), plugin_dir_url(__FILE__) . 'custom.svg', 100);
            // in der folgenden Zeile wird der Code des SVG direkt reinkopiert. In Chrome-Browserconsole den Code mit btoa(``) erst in ASCII umwandeln
            $mainPageHook = add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+Cg==', 100);
            add_submenu_page('ourwordfilter', 'Words To Filter', 'Words List', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'));
            add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
            add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
        }

        function filterlogic($content) {
            $badwords = explode(',', get_option('plugin_words_to_filter'));
            $badwordstrimmed = array_map('trim', $badwords);
            return str_ireplace($badwordstrimmed, esc_html(get_option('replacementText', '****')), $content);
        }

        function mainPageAssets() {
            wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
        }

        function optionsSubPage() { ?>
            <div class="wrap">
                <h1>Word Filter Options</h1>
                <form action="options.php" method="POST">
<?php               settings_errors();
                    settings_fields('replacementFields');
                    do_settings_sections('word-filter-options');
                    submit_button();    ?>
                </form>
            </div>
<?php   }

        function handleForm() {
            if (wp_verify_nonce($_POST['ourNonce'], 'save_filter_words') AND current_user_can('manage_options')) {
                update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter'])); ?>
            <div class="updated">
                <p>Your filtered words were saved.</p>
            </div> 
<?php       } else { ?>
                <div class="error">
                    <p>Sorry, you do not have permission.</p>
                </div>
<?php        }
        }

        function wordFilterPage() { ?>
            <div class="wrap">
                <h1>Word Filter</h1>
    <?php       if (isset($_POST['justsubmitted']) == "true") $this->handleForm(); ?>
                <form method="POST">
                    <?php wp_nonce_field('save_filter_words', 'ourNonce'); ?>
                    <input type="hidden" name="justsubmitted" value="true">
                    <label for="plugin_words_to_filter"><p>Enter a <bold>comma-seperated</bold> list of words to filter from your site's contend</p></label>
                    <div class="word-filter__flex-container">
                        <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, awful, horrible"><?php echo esc_textarea(get_option('plugin_words_to_filter')); ?></textarea>
                    </div>
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </form>
            </div>
<?php   }
    }

    $ourWordFilterPlugin = new OurWordFilterPlugin();