<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

function kocf_create_tables() {

	global $wpdb;
  $kocf_db_version = "1.0";
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	// signup table creation
	$signup_table_name = $wpdb->prefix . KOCF_SIGNUP_TABLE;

	$sql = "CREATE TABLE $signup_table_name (
		user_id smallint(9) NOT NULL AUTO_INCREMENT,
    user_email_id varchar(90) NOT NULL,
    catan_universe_name varchar(100) NULL,
    colonist_name varchar(100) NULL,
    catan_vr_name varchar(100) NULL,
    discord_name varchar(100) NOT NULL,
		time_stamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    game_modes varchar(400) NOT NULL,
    discord_server varchar(100) NOT NULL,
    user_active smallint(2) DEFAULT 1,
    add_to_newsletter smallint(2) DEFAULT 0,
		user_time_zone smallint(2) NOT NULL,
    PRIMARY KEY  (user_id),
    UNIQUE KEY user_email_id (user_email_id)
	) $charset_collate;";

	dbDelta( $sql );

	// Results table creation
	$results_table_name = $wpdb->prefix . KOCF_RESULTS_TABLE;

	$sql = "CREATE TABLE $results_table_name (
		result_id smallint(9) NOT NULL AUTO_INCREMENT,
    winner_email_id varchar(90) NOT NULL,
		player_two_email_id varchar(90) NOT NULL,
		player_three_email_id varchar(90) NULL,
		player_four_email_id varchar(90) NULL,
		other_players varchar(400) NULL,
    is_crown_game varchar(20) NOT NULL,
    game_mode varchar(40) NOT NULL,
    game_scenario varchar(60) NOT NULL,
    PRIMARY KEY  (result_id),
    FOREIGN KEY  (winner_email_id) REFERENCES $signup_table_name(user_email_id),
		FOREIGN KEY  (player_two_email_id) REFERENCES $signup_table_name(user_email_id),
		FOREIGN KEY  (player_three_email_id) REFERENCES $signup_table_name(user_email_id),
		FOREIGN KEY  (player_four_email_id) REFERENCES $signup_table_name(user_email_id)
	) $charset_collate;";

	dbDelta( $sql );

  add_option( 'KOCF_VERSION_NUM', KOCF_VERSION_NUM );
}
