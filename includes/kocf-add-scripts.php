<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load styles & scripts
function kocf_styles() {
    wp_enqueue_style( 'kocf-styles',  plugin_dir_url( __FILE__ ) . 'css/kocf-sp-style.css' );
    wp_enqueue_script( 'kocfh_script', plugin_dir_url( __FILE__ ) . 'js/kocf-sp-index.js' , array('jquery'), null, true );

    // this is to set up API call URL
    wp_localize_script( 'kocfh_script', 'kocfhAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action( 'wp_enqueue_scripts', 'kocf_styles' );
