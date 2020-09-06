<?php
/**
* Plugin Name: King of Catan Forms
* Plugin URI: https://www.kingofcatan.net/
* Description: This plugin handles the two forms for KoC
* Version: 1.0
* Author: Alfred DSouza
* Author URI: http://dsouzaalf.red/
**/

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!defined('KOCF_SIGNUP_TABLE' ))
    define('KOCF_SIGNUP_TABLE', 'kocf_signup');

if (!defined('KOCF_RESULTS_TABLE' ))
    define('KOCF_RESULTS_TABLE', 'kocf_results');

if (!defined('KOCF_VERSION_NUM'))
    define('KOCF_VERSION_NUM', '1.0.0');

// Include kocf-functions.php, use require_once to stop the script if kocf-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-create-tables.php';

register_activation_hook( __FILE__, 'kocf_create_tables' );

// Include kocf-functions.php, use require_once to stop the script if kocf-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-functions.php';
