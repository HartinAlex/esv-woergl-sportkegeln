<?php
/**
 * Plugin Name:       Ligaverwaltung Sportkegeln
 * Description:       Verwaltung der Ligen
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0
 * Author:            AlexH
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ligaverwaltung
 *
 * @package Verwaltung
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function verwaltung_ligaverwaltung_block_init() {
	register_block_type( __DIR__ . '/build/verwaltungspiele' );
	register_block_type( __DIR__ . '/build/verwaltungergebnisse' );
}
add_action( 'init', 'verwaltung_ligaverwaltung_block_init' );


function onActivate() {
	global $wpdb;
	$table_teams = $wpdb->prefix . 'liga_teams';
	$table_leagues = $wpdb->prefix . 'liga_leagues';
	$table_player = $wpdb->prefix . 'liga_players';
	$table_matches = $wpdb->prefix . 'liga_matches';
	$table_standing = $wpdb->prefix . 'liga_standing';
	$table_rounds = $wpdb->prefix . 'liga_rounds';
	$charset_collate = $wpdb->get_charset_collate();

	$sql_leagues = "CREATE TABLE $table_leagues (
        league_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        leaguename VARCHAR(100) NOT NULL,
        country VARCHAR(100)
      ) $charset_collate;";

      $sql_teams = "CREATE TABLE $table_teams (
        team_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        league_id INT,
        teamname VARCHAR(100) NOT NULL,
        team_location VARCHAR(100),
        FOREIGN KEY (league_id) REFERENCES $table_leagues(league_id)
      ) $charset_collate;";

      $sql_players = "CREATE TABLE $table_player (
        player_id INT AUTO_INCREMENT PRIMARY KEY,
        team_id INT,
        firstname VARCHAR(100) NOT NULL,
        lastname VARCHAR(100) NOT NULL,
        FOREIGN KEY (team_id) REFERENCES $table_teams(team_id)
      ) $charset_collate;";

      $sql_rounds = "CREATE TABLE $table_rounds (
        round_id INT AUTO_INCREMENT PRIMARY KEY,
        round_name VARCHAR(10)
      ) $charset_collate;";

      $sql_matches = "CREATE TABLE $table_matches (
        match_id INT AUTO_INCREMENT PRIMARY KEY,
        league_id INT,
        round_id INT,
        home_team_id INT,
        away_team_id INT,
        match_date Date,
        home_team_map FLOAT,
        away_team_map FLOAT,
        home_team_sap FLOAT,
        away_team_sap FLOAT,
        home_team_kegel INT,
        away_team_kegel INT,
        FOREIGN KEY  (league_id) REFERENCES $table_leagues(league_id),
        FOREIGN KEY  (round_id) REFERENCES $table_rounds(round_id),
        FOREIGN KEY  (home_team_id) REFERENCES $table_teams(team_id),
        FOREIGN KEY  (away_team_id) REFERENCES $table_teams(team_id)
      ) $charset_collate;";

      $sql_standing = "CREATE TABLE $table_standing (
        league_id INT,
        team_id INT,
        played INT DEFAULT 0,
        won INT DEFAULT 0,
        drawn INT DEFAULT 0,
        lost INT DEFAULT 0,
        map_for FLOAT DEFAULT 0.0,
        map_against FLOAT DEFAULT 0.0,
        sap_for FLOAT DEFAULT 0.0,
        sap_against FLOAT DEFAULT 0.0,
        points_for INT DEFAULT 0,
        points_against INT DEFAULT 0,
        PRIMARY KEY  (league_id, team_id),
        FOREIGN KEY  (league_id) REFERENCES $table_leagues(league_id),
        FOREIGN KEY  (team_id) REFERENCES $table_teams(team_id)
      ) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	dbDelta($sql_leagues);
	dbDelta($sql_teams);
	dbDelta($sql_players);
	dbDelta($sql_rounds);
	dbDelta($sql_matches);
	dbDelta($sql_standing);
}
register_activation_hook(__FILE__, 'onActivate');
//add_action('activate_ligaverwaltung/ligaverwaltung.php', array('onActivate'));
