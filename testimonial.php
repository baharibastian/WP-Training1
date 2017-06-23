<?php
/*
Plugin Name: testimonial
Plugin URI: http://example.com
Description: Simple non-bloated WordPress Contact Form
Version: 1.0
Author: Agbonghama Collins
Author URI: http://w3guy.com
*/
function create() {
	global $wpdb;
    // creates my_table in database if not exists
	$table = $wpdb->prefix . "testimonial"; 
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS $table (
	`name` varchar(50) NOT NULL,
	`email` text NOT NULL,
	`phone` text NOT NULL,
	`message` text NOT NULL
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'create' );

function html_form_code() {
	echo '<form action="" method="post">';
	echo '<p>';
	echo 'Your Name (required) <br/>';
	echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" size="40" required/>';
	echo '</p>';
	echo '<p>';
	echo 'Your Email (required) <br/>';
	echo '<input type="email" name="cf-email" size="40" required/>';
	echo '</p>';
	echo '<p>';
	echo 'Phone Number (required) <br/>';
	echo '<input type="text" name="cf-phone" pattern="[0-9]+" size="40" required/>';
	echo '</p>';
	echo '<p>';
	echo 'Your Message (required) <br/>';
	echo '<textarea rows="10" cols="35" name="cf-message" required></textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="submit" value="Send"></p>';
	echo '</form>';
}

function send() {
	if (isset($_POST['submit'])){
		global $wpdb;
		$tablename=$wpdb->prefix. "testimonial";
		$data=array(
			'name' => $_POST['cf-name'], 
			'email' => $_POST['cf-email'],
			'phone' => $_POST['cf-phone'], 
			'message' => $_POST['cf-message']
			);
		$wpdb->insert( $tablename, $data);
	}
}

function cf_shortcode() {
	ob_start();
	create();
	html_form_code();
	send();
	return ob_get_clean();
}

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

include_once('Foo_widget.php');
include_once('top_level.php');

?>