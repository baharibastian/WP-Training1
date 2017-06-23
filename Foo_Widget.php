<?php
/*
Plugin Name: Foo Widget
Description: Foo widget
Version: 1.0
Author: name
License: GPL2
*/
class Foo_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			esc_html__( 'Widget Title', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'A Foo Widget', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
		 	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		// echo esc_html__( 'Hello, World!', 'text_domain' );
		
		global $wpdb;
		$result = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'testimonial order by rand() LIMIT 0.1');
		$mylink = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'testimonial ORDER BY rand() LIMIT 1');
		?>
		<div style="font-weight: normal;font-style: italic;font-size: 16px">"<?php echo $mylink->message ?>"</div>
		<div style="font-weight: bold">- <?php echo $mylink->name ?></div>
		<?php
		echo $args['after_widget'];

	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

add_action( 'widgets_init', 'register_foo_widget' );
function register_foo_widget() {
    register_widget('Foo_Widget');
}

?>