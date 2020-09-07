<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

// get kocf_ajax
include( plugin_dir_path( __FILE__ ) . '/kocf_ajax.php');

// function that will handle ajax call
add_action( 'wp_ajax_nopriv_kocf_handle_ajax', 'kocf_handle_ajax' );
add_action( 'wp_ajax_kocf_handle_ajax', 'kocf_handle_ajax' );
