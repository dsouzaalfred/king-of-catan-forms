<?php

// If this is called directly, abort,
if ( ! defined( 'WPINC' ) ) {
	die;
}

// register the menus
add_action( 'admin_menu', 'kocf_admin_menu' );
add_action('admin_menu', 'kocf_signup_admin_sub_menu');
add_action('admin_menu', 'kocf_results_admin_sub_menu');

// add the main menu
function kocf_admin_menu(){
  $kocf_am_page_title = 'King Of Catan - Form Data';
  $kocf_am_menu_title = 'KOC - Form Data';
  $kocf_am_capability = 'install_plugins';
  $kocf_am_menu_slug  = 'kocf-admin-menu';
  $kocf_am_function   = 'render_kocf_admin_menu';
  $kocf_am_icon_url   = 'dashicons-feedback';
  $kocf_am_position   = 4;
  add_menu_page(
		$kocf_am_page_title,
		$kocf_am_menu_title,
		$kocf_am_capability,
		$kocf_am_menu_slug,
		$kocf_am_function,
		$kocf_am_icon_url,
		$kocf_am_position
	);
}

// render the main menu
function render_kocf_admin_menu() {
	?>
		<div class="kocf-menu-content-wrapper">
			<h2><?php esc_html_e( 'King Of Catan - Form Data' ); ?></h2>
			<a href="<?php echo admin_url( 'admin.php?page=kocf-signup-admin-menu' ); ?>">
				<?php esc_html_e( 'Signup data'); ?>
			</a>
			<br />
			<a href="<?php echo admin_url( 'admin.php?page=kocf-results-admin-menu' ); ?>">
				<?php esc_html_e( 'Results data' ); ?>
			</a>
		</div>
	<?php
}

// add the sub menus
function kocf_signup_admin_sub_menu() {
	$kocf_su_am_parent_slug = 'kocf-admin-menu';
	$kocf_su_am_page_title = 'Signup data';
  $kocf_su_am_menu_title = 'Signup data';
	$kocf_su_am_capability = 'install_plugins';
	$kocf_su_am_menu_slug  = 'kocf-signup-admin-menu';
  $kocf_su_am_function   = 'kocf_render_signup_admin_menu';
  add_submenu_page(
    $kocf_su_am_parent_slug,
    $kocf_su_am_page_title,
    $kocf_su_am_menu_title,
    $kocf_su_am_capability,
    $kocf_su_am_menu_slug,
    $kocf_su_am_function
	);
}

function kocf_results_admin_sub_menu() {
	$kocf_rs_am_parent_slug = 'kocf-admin-menu';
	$kocf_rs_am_page_title = 'Results data';
  $kocf_rs_am_menu_title = 'Results data';
	$kocf_rs_am_capability = 'install_plugins';
	$kocf_rs_am_menu_slug  = 'kocf-results-admin-menu';
  $kocf_rs_am_function   = 'kocf_render_results_admin_menu';
  add_submenu_page(
    $kocf_rs_am_parent_slug,
    $kocf_rs_am_page_title,
    $kocf_rs_am_menu_title,
    $kocf_rs_am_capability,
    $kocf_rs_am_menu_slug,
    $kocf_rs_am_function
	);
}

// render the sub menus
function kocf_render_signup_admin_menu() {
	require_once plugin_dir_path(__FILE__) . './kocf-admin-signup-list.php';

	$kocf_signup_list_table = new Kocf_Admin_Signup_List();
	$kocf_signup_list_table->prepare_items();
	?>
	<div class="kocf-menu-content-wrapper">
			<h2>King Of Catan - Signup data</h2>
	<?php $kocf_signup_list_table->display(); ?>
	</div>
	<?php
}

function kocf_render_results_admin_menu() {
	require_once plugin_dir_path(__FILE__) . './kocf-admin-results-list.php';

	$kocf_results_list_table = new Kocf_Admin_Results_List();
	$kocf_results_list_table->prepare_items();
	?>
	<div class="kocf-menu-content-wrapper">
			<h2>King Of Catan - Results data</h2>
	<?php $kocf_results_list_table->display(); ?>
	</div>
	<?php
}
