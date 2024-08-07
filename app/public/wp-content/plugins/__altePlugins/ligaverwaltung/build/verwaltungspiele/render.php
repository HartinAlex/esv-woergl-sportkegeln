<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
global $wpdb;
$table = $wpdb->prefix . 'liga_leagues';

$query = "SELECT * FROM $table";

$allLeagues = $wp->query($wpdb->prepare($query));

print_r($allLeagues);
?>
<div data-wp-interactive="ligaverwaltung">
	<button data-wp-on--click="actions.test">Click me</button>
	<p <?php echo get_block_wrapper_attributes(); ?>>
		<?php esc_html_e( 'Verwaltung Spiele – hello from a dynamic block!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!', 'ligaverwaltung' ); ?>
	</p>
</div>


