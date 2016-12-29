<?php
class Tpath_About_Widget extends WP_Widget {

	function Tpath_About_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_about_widget', 'description' => 'Widget that displays an About widget.');
		$control_options = array('id_base' => 'tpath_about-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_about-widget', 'About Me', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);
		
		$author_name = $instance['author_name'];
		$image = $instance['image'];
		$description = $instance['description'];
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'About Me', 'Templatepath' ) : $instance['title'] );

		echo wp_kses($before_widget, justice_wp_allowed_tags() ); ?>
		
		<div id="tpath_about_widget" class="tpath-about-widget">
			
			<?php if( isset( $image ) && $image != '' ) { ?>
				<div class="widget-author-image">
					<img class="img-responsive" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $author_name ); ?>" />
				</div>
			<?php } ?>
			
			<?php if( isset( $author_name ) && $author_name != '' ) { ?>
				<h5 class="widget-author-name text-uppercase"><?php echo esc_html( $author_name ); ?></h5>
			<?php } ?>
			
			<?php if( isset( $description ) && $description != '' ) { ?>
				<div class="about-desc"><?php echo wp_kses_post( $description ); ?></div>
			<?php } ?>	
			
		</div>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['author_name'] = $new_instance['author_name'];
		$instance['image'] = $new_instance['image'];
		$instance['description'] = $new_instance['description'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'author_name' => '', 'image' => '', 'description' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
		$description = esc_textarea( $instance['description'] ); ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('author_name') ); ?>"><?php _e('Author Name:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('author_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('author_name') ); ?>" value="<?php echo esc_attr( $instance['author_name'] ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('image') ); ?>"><?php _e('Image URL:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>"><?php _e('Description:', 'Templatepath'); ?></label>
			<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
	<?php }
}

function tpath_about_widget_load()
{
	register_widget('Tpath_About_Widget');
}

add_action('widgets_init', 'tpath_about_widget_load');
?>