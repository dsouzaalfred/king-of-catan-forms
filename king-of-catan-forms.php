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

// Include kocf-create-tables.php, use require_once to stop the script if kocf-create-tables.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-create-tables.php';

register_activation_hook( __FILE__, 'kocf_create_tables' );

// Include kocf-add-scripts.php, use require_once to stop the script if kocf-add-scripts.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-add-scripts.php';

// Include kocf-add-shortcodes.php, use require_once to stop the script if kocf-add-shortcodes.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-add-shortcodes.php';

// Include kocf-add-ajax-support.php, use require_once to stop the script if kocf-add-ajax-support.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/kocf-add-ajax-support.php';
