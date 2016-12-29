<?php
class Tpath_Popular_Posts_Widget extends WP_Widget {

	function Tpath_Popular_Posts_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_popular_posts_widget', 'description' => 'Displays latest posts based on categories.');
		$control_options = array('id_base' => 'tpath_popular_posts-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_popular_posts-widget', 'Popular Posts', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		global $tpath_options, $post;

		extract($args);

		$categories = absint($instance['categories']) ? $instance['categories'] : '';
		$posts_count = absint($instance['posts_count']) ? $instance['posts_count'] : 5;
		$show_thumb = $instance['show_thumb'];
		$show_date = $instance['show_date'];
		$title = apply_filters('widget_title', $instance['title']);

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
				
		$popular_args = array(
			'posts_per_page' 		=> $posts_count,
			'meta_key'		 		=> 'tpath_post_views_count',
			'orderby' 		 		=> 'meta_value_num',
			'order' 		 		=> 'DESC',
			'cat'			 		=> $categories,
			'ignore_sticky_posts' 	=> 1
		);
		
		$popular_posts = new WP_Query($popular_args);
		if( $popular_posts->have_posts() ): ?>
		
			<div id="tpath_latest_posts_widget" class="tpath-latest-posts">
				<ul class="latest-posts-menu list-unstyled">
				<?php while( $popular_posts->have_posts( )): $popular_posts->the_post();
					$featured_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');	?>
					
					<li class="posts-item clearfix">
						<?php if( $show_thumb == 'on' ) {
							if( $featured_img[0] != '' ) { ?>
								<div class="widget-entry-image entry-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
										<img class="img-responsive latest-post-img" src="<?php echo esc_url( $featured_img[0] ); ?>" alt="<?php the_title(); ?>" />
									</a>
								</div>
							<?php } else { ?>
								<div class="widget-entry-image entry-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
										<img src="<?php echo TEMPLATETHEME_URL; ?>/images/empty-150.jpg" class="img-responsive latest-post-img" alt="<?php the_title(); ?>" />											
									</a>
								</div>
							<?php } ?>				
						<?php } ?>
						<div class="widget-entry-content">
							<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
							<p><?php echo justice_custom_excerpts(12); ?></p>
							<?php if( $show_date == 'on' ) { ?>
								<span class="entry-date"><?php the_time( $tpath_options['tpath_blog_date_format'] ); ?></span>
							<?php } ?>
						</div>
					</li>

				<?php endwhile; ?>
				</ul>
			</div>
			<?php endif; ?>
		<?php wp_reset_postdata();
		echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts_count'] = $new_instance['posts_count'];
		$instance['show_thumb'] = $new_instance['show_thumb'];
		$instance['show_date'] = $new_instance['show_date'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'categories' => '', 'posts_count' => '', 'show_thumb' => '', 'show_date' => '');
		$instance = wp_parse_args((array) $instance, $defaults);	
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php _e('Choose Category:', 'Templatepath'); ?></label>			
			<?php $args = array(
					'show_option_all'    => 'All Categories',
					'id'                 => esc_attr( $this->get_field_id('categories' ) ),
					'name'               => esc_attr( $this->get_field_name('categories' ) ),
					'class'              => 'widefat',
					'orderby'            => 'NAME', 
					'order'              => 'ASC',	
					'selected'           => esc_attr($instance['categories']),				
					'hierarchical'       => 1,
					);
					
			wp_dropdown_categories($args); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>"><?php _e('Number of posts to show:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" style="width: 35px;" id="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_count') ); ?>" value="<?php echo esc_attr( $instance['posts_count'] ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_thumb'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_thumb') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_thumb') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_thumb') ); ?>"><?php _e('Show Thumbnail Image', 'Templatepath'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_date'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_date') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_date') ); ?>"><?php _e('Show Posted Date', 'Templatepath'); ?></label>
		</p>	
			
	<?php }
}

function tpath_popular_posts_load()
{
	register_widget('Tpath_Popular_Posts_Widget');
}

add_action('widgets_init', 'tpath_popular_posts_load');

?>