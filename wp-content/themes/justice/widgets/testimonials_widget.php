<?php
class Tpath_Testimonials_Widget extends WP_Widget {

	function Tpath_Testimonials_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_testimonial_widget', 'description' => 'Displays testimonials list in slider.');
		$control_options = array('id_base' => 'tpath_testimonial-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_testimonial-widget', 'Testimonial Slider', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		global $tpath_options, $post;

		extract($args);

		$categories = $instance['categories'];
		$posts_count = absint($instance['posts_count']) ? $instance['posts_count'] : '-1';
		$show_pagination = $instance['show_pagination'];
		$title = apply_filters('widget_title', $instance['title']);

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
		?>		
		<?php
		$args = array(
			'post_type' 	 => 'tpath_testimonial',
			'posts_per_page' => $posts_count,
			'orderby' 		 => 'menu_order',
			'order' 		 => 'ASC',
			'tax_query' 	 => array(
								   array(
									'taxonomy' => 'testimonial_categories',
									'field' => 'id',
									'terms' => $categories
								) )
		);
		
		$testimonial = new WP_Query($args);
		if( $testimonial->have_posts() ): ?>
		
			<div id="tpath_testimonial_widget_<?php echo esc_attr( $categories ); ?>" class="tpath-testimonial carousel slide" data-ride="carousel">
				<?php if( $show_pagination == 'on' ) { ?>
					<ol class="carousel-indicators">
						<?php $count = 0;					
						while( $testimonial->have_posts() ) : $testimonial->the_post(); ?>
							<li data-target="#tpath_testimonial_widget_<?php echo esc_attr( $categories ); ?>" data-slide-to="<?php echo esc_attr( $count ); ?>"></li>
						<?php $count++; endwhile; ?>					
					</ol>
				<?php } ?>
			
				<div class="carousel-inner">
				<?php while( $testimonial->have_posts( )): $testimonial->the_post(); 
					$testi_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');	?>
					
					<div class="item">	
						<div class="grid row">
							<?php if( $testi_img[0] != '' ) { ?>
								<div class="testimonial-author-img col-md-12">
									<img class="img-responsive img-rounded" src="<?php echo esc_url( $testi_img[0] ); ?>" alt="<?php the_title(); ?>" />
								</div>
							<?php } ?>
							<div class="testimonial-info col-md-12">
								<div class="testimonial-content"><?php the_excerpt(); ?></div>
							</div>
							<div class="testimonial-author col-md-12">
								<p class="author-link"><?php the_title(); ?></p>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>		
		<?php
		echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts_count'] = $new_instance['posts_count'];
		$instance['show_read_more'] = $new_instance['show_read_more'];
		$instance['read_more_text'] = $new_instance['read_more_text'];
		$instance['show_pagination'] = $new_instance['show_pagination'];		

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'categories' => '', 'posts_count' => '', 'show_read_more' => '', 'read_more_text' => '', 'show_pagination' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
		
		$testimonial_array = justice_get_taxonomy_terms_array('testimonial_categories', 'tpath_testimonial', 'Choose Category');
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php _e('Choose Category:', 'Templatepath'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('categories' )); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>" class="widefat" style="width:100%;">
				<?php foreach( $testimonial_array as $select_id => $option ) {
						$value = $select_id; ?>
						<option id="<?php echo esc_attr( $select_id ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo selected(esc_attr($instance['categories']), esc_attr($value), false); ?>><?php echo esc_attr( $option ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>"><?php _e('Number of posts to show:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" style="width: 35px;" id="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_count') ); ?>" value="<?php echo esc_attr( $instance['posts_count'] ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_pagination'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_pagination') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_pagination') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_pagination') ); ?>"><?php _e('Show Pagination', 'Templatepath'); ?></label>
		</p>		
	<?php }
}

function tpath_testimonials_load()
{
	register_widget('Tpath_Testimonials_Widget');
}

add_action('widgets_init', 'tpath_testimonials_load');

?>