
<?php
/*
Plugin Name: Test plugin
Description: A test plugin to demonstrate wordpress functionality
Author: Simon Lissack
Version: 0.1
*/
add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
	add_menu_page( 'Test Plugin Page', 'Test Plugin', 'manage_options', 'test-plugin', 'test_init' );
}

function test_init(){
	global $wpdb;
	if(isset($_GET['id'])) {
		delete_data($_GET['id']);
	}

	$result = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'testimonial ');

	echo '
	<table width="100%" style="padding:10px;border-collapse: collapse;border-spacing:0">
		<tr>
			<th style="padding:10px">Nama</th>
			<th style="padding:10px">Email</th>
			<th style="padding:10px">Phone</th>
			<th style="padding:10px">Message</th>
			<th style="padding:10px">Action</th>
		</tr>';
		foreach ($result as $item) {
			?>
			<tr>
				<td style="padding:10px"><?php echo $item->name ?></td>
				<td style="padding:10px"><?php echo $item->email ?></td>
				<td style="padding:10px"><?php echo $item->phone ?></td>
				<td style="padding:10px"><?php echo $item->message ?></td>
				<td style="padding:10px"><a href="<?php echo admin_url('admin.php?page=test-plugin&id='.$item->id); ?>">Delete</a></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}

function delete_data($id) {
	global $wpdb;
	$wpdb->query (
		$wpdb->prepare(
			"
			DELETE FROM wp_testimonial
			WHERE id = %d",$id
			)
		);
}
?>