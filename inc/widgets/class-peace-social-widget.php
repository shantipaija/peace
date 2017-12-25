<?php

/**
 * Social  Widget
 * Peace
 */
class peace_Social_Widget extends WP_Widget {

	function __construct() {

					  $widget_ops = array(
						  'classname' => 'peace-social',
						  'description' => esc_html__( 'Peace Social Widget' ,'peace' ),
					  );
		  parent::__construct( 'peace-social', esc_html__( 'Peace Social Widget','peace' ), $widget_ops );

	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow us' , 'peace' );

		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		/**
		 * Widget Content
		 */ ?>

		<!-- social icons -->
		<div class="social-icons sticky-sidebar-social">

			<?php peace_social_icons(); ?>

		</div><!-- end social icons --><?php

		echo $args['after_widget'];
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Follow us' , 'peace' );
		} ?>

	  <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ','peace' ) ?></label>

	  <input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
						  name="<?php echo $this->get_field_name( 'title' ); ?>"
						  id="<?php $this->get_field_id( 'title' ); ?>"
						  class="widefat" />
	  </p><?php
	}

}
?>
