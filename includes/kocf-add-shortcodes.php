<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

// get signup form
include( plugin_dir_path( __FILE__ ) . '/kocf-signup-form.php');
// get results form
include( plugin_dir_path( __FILE__ ) . '/kocf-results-form.php');

// add shortcodes
add_shortcode('kocf-show-singup-form', 'kocf_show_signup_form_code');
add_shortcode('kocf-show-results-form', 'kocf_show_results_form_code');
