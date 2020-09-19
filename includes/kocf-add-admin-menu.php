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
			<h2>King Of Catan - Form Data</h2>
			<a href="<?php echo admin_url( 'admin.php?page=kocf-signup-admin-menu' ); ?>">
				<?php esc_html_e( 'Signup data', 'autoclose' ); ?>
			</a>
			<br />
			<a href="<?php echo admin_url( 'admin.php?page=kocf-results-admin-menu' ); ?>">
				<?php esc_html_e( 'Results data', 'autoclose' ); ?>
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
	global $wpdb;
	$kocf_signup_table_name = $wpdb->prefix . KOCF_SIGNUP_TABLE;
	$kocf_signup_query = "SELECT * FROM $kocf_signup_table_name ORDER BY time_stamp";
	$kocf_signup_query_results = $wpdb->get_results($kocf_signup_query);
	?>
		<div class="kocf-menu-content-wrapper">
			<h2>King Of Catan - Signup data</h2>
			<table id="kocf-signup-data-table">
				<tr>
					<th>Email</th>
					<th>Catan Universe Name</th>
					<th>Colonist Name</th>
					<th>Catan VR Name</th>
					<th>Discord Name</th>
					<th>Game Modes</th>
					<th>Discord server</th>
					<th>Add to newsletter</th>
					<th>Time zone</th>
					<th>Time stamp</th>
				</tr>
				<?php foreach ($kocf_signup_query_results as $row){ ?>
					<tr>
						<td><?php echo $row->user_email_id ?></td>
						<td><?php echo $row->catan_universe_name ?></td>
						<td><?php echo $row->colonist_name ?></td>
						<td><?php echo $row->catan_vr_name ?></td>
						<td><?php echo $row->discord_name ?></td>
						<td><?php echo $row->game_modes ?></td>
						<td><?php echo $row->discord_server ?></td>
						<td><?php echo $row->add_to_newsletter == 0 ? 'No' : 'Yes' ?></td>
						<td><?php echo $row->user_time_zone ?></td>
						<td><?php echo $row->time_stamp ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
	<?php
}

function kocf_render_results_admin_menu() {
	// global $wpdb;
	// $kocf_results_table_name = $wpdb->prefix . KOCF_RESULTS_TABLE;
	// $kocf_results_query = "SELECT * FROM $kocf_results_table_name ORDER BY time_stamp JOIN $kocf_signup_table_name ON ";
	// $kocf_results_query_results = $wpdb->get_results($kocf_results_query);
	?>
	<div class="kocf-menu-content-wrapper">
		<h2>King Of Catan - Results data</h2>
	</div>
	<?php
}
