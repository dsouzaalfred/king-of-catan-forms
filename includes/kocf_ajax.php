<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

function kocf_handle_ajax() {
  global $wpdb;
  $wpdb->hide_errors();
  // verify if it's WP AJAX request
  if ( isset($_REQUEST) ) {
    // get form type from request
    $form_type = $_REQUEST['form_type'];

    if ( $form_type == 'signup' ) {

      // get data from post request
      $data = $_POST;
      $signup_data = $data['signup_data'];

      if(is_email($signup_data['kocfSpEmailAddress']) == false) {
        wp_send_json_error("Invalid email Id");
      }
      // signup table name
      $signup_table_name = $wpdb->prefix . KOCF_SIGNUP_TABLE;

      // handle sign-up request
      $add_signup_record = $wpdb->insert($signup_table_name, array(
         "user_email_id" => sanitize_email($signup_data['kocfSpEmailAddress']),
         "catan_universe_name" => sanitize_text_field($signup_data['kocfSpCatanUniverseName']),
         "colonist_name" => sanitize_text_field($signup_data['kocfSpColonistName']),
         "catan_vr_name" => sanitize_text_field($signup_data['kocfSpCatanVrName']),
         "discord_name" => sanitize_text_field($signup_data['kocfSpDiscordName']),
         "game_modes" => sanitize_text_field($signup_data['kocfSpGameMode']),
         "discord_server" => sanitize_text_field($signup_data['kocfSpDiscordServer']),
         "user_time_zone" => sanitize_text_field($signup_data['kocfSpTimeZone']),
         "add_to_newsletter" => sanitize_text_field($signup_data['kocfSpNewsletter']),
         "time_stamp" => current_time( 'mysql' ), // insert current timestamp
      ));

      if($add_signup_record === false) {
        $signup_error = $wpdb->hide_errors();
        // error_log(print_r($signup_error, true)); log to debug.log
        // check if the error is related to email ID
        $check_check = stripos($signup_error, 'user_email_id');
        if(strlen($check_check) >= 0) {
          wp_send_json_error("Email Id already exists.");
        }
        wp_send_json_error('Error submitting the form, pleasea try again');
      } else {
				// send mail here
        $signup_success = array('message' => "Sign up successful");
        wp_send_json_success( __( $signup_success, 'kocfSignup' ) );
      }
    }

		if ( $form_type == 'results' ) {
			// get data from post request
      $data = $_POST;
      $signup_data = $data['results_data'];

			$results_table_name = $wpdb->prefix . KOCF_RESULTS_TABLE;

			$add_results_record = $wpdb->insert($results_table_name, array(
         "winner_user_id" => sanitize_text_field($signup_data['kocfRsWinner']),
         "player_two_user_id" => sanitize_text_field($signup_data['kocfRsPlayer2']),
         "player_three_user_id" => sanitize_text_field($signup_data['kocfRsPlayer3']),
         "player_four_user_id" => sanitize_text_field($signup_data['kocfRsPlayer4']),
         "other_players" => sanitize_text_field($signup_data['kocfRsOtherPlayers']),
         "is_crown_game" => sanitize_text_field($signup_data['kocfRsGameForCrown']),
         "game_mode" => sanitize_text_field($signup_data['kocfRsGameMode']),
         "game_scenario" => sanitize_text_field($signup_data['kocfRsGameScenario']),
         "time_stamp" => current_time( 'mysql' ), // insert current timestamp
      ));

			if($add_results_record === false) {
        wp_send_json_error('Error submitting the form, pleasea try again');
      } else {
				// send mail here
        $result_success = array('message' => "Results submitted.");
        wp_send_json_success( __( $result_success, 'kocfResults' ) );
      }
		}
    wp_send_json_error();
  }

}
