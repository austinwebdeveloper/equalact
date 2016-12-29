<?php
class Tpath_Tabs_Widget extends WP_Widget {

	function Tpath_Tabs_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_tabs_widget', 'description' => 'Displays popular posts, recent posts and comments in tabs.');
		$control_options = array('id_base' => 'tpath_tabs-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_tabs-widget', 'Tabs', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		global $tpath_options, $post;

		extract($args);

		$show_popular_posts = $instance['show_popular_posts'];
		$show_recent_posts = $instance['show_recent_posts'];
		$show_comments = $instance['show_comments'];
		$posts_count = absint($instance['posts_count']) ? $instance['posts_count'] : 3;
		$recent_posts = absint($instance['recent_posts']) ? $instance['recent_posts'] : 3;
		$comments_count = absint($instance['comments_count']) ? $instance['comments_count'] : 3;

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		?>
		<div id="tpath-tabs-widget" class="tpath-tabs-widget">
			<div class="tpath-tabs-wrapper tabs">
				<ul id="tpath-tabs" class="nav nav-tabs" role="tablist">
					<?php if($show_popular_posts == 'on') { ?>
						<li class="active"><a href="#tab-popular" data-toggle="tab"><?php esc_html_e('Popular', 'Templatepath'); ?></a></li>
					<?php } ?>
					<?php if($show_recent_posts == 'on') { ?>
						<li><a href="#tab-recent" data-toggle="tab"><?php esc_html_e('Recent', 'Templatepath'); ?></a></li>
					<?php } ?>
					<?php if($show_comments == 'on') { ?>
						<li><a href="#tab-comments" data-toggle="tab"><i class="fa fa-comments-o"></i></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content tpath-tab-content">
					<?php if($show_popular_posts == 'on') { ?>
						<div id="tab-popular" class="tab-pane fade in active">
							<?php $order_string = '&meta_key=tpath_post_views_count&orderby=meta_value_num';
							
							$popular_posts = new WP_Query('showposts='.$posts_count.$order_string.'&order=DESC&ignore_sticky_posts=1');
							if($popular_posts->have_posts()) { ?>
								<ul class="widget-posts-list">
									<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
										<li>
											<?php if(has_post_thumbnail()) {
												$featured_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail'); ?>
												<div class="widget-entry-image entry-thumbnail">
													<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
														<img class="img-responsive" src="<?php echo esc_url( $featured_img[0] ); ?>" alt="<?php the_title(); ?>" />
													</a>
												</div>
											<?php } else { ?>
												<div class="widget-entry-image entry-thumbnail">
													<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
														<img src="<?php echo TEMPLATETHEME_URL; ?>/images/empty-150.jpg" class="img-responsive" alt="<?php the_title(); ?>" />											
													</a>
												</div>
											<?php } ?>
											<div class="widget-entry-content">
												<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
												<div class="widget-entry-meta comments-link">
													<?php if ( comments_open() ) {
														comments_popup_link( '<span class="leave-reply">' . __( '0', 'Templatepath' ) . '</span>', __( '1', 'Templatepath' ), __( '%', 'Templatepath' ) );
													} ?>													
												</div>
											</div>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php }
							wp_reset_postdata(); ?>
						</div>
					<?php } ?>
					<?php if($show_recent_posts == 'on') { ?>
						<div id="tab-recent" class="tab-pane fade">
							<?php $recent_posts = new WP_Query('showposts='.$recent_posts.'&ignore_sticky_posts=1');
							if($recent_posts->have_posts()) { ?>
								<ul class="widget-posts-list">
									<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
									<li>
										<?php if(has_post_thumbnail()) {
											$featured_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail'); ?>
											<div class="widget-entry-image entry-thumbnail">
												<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
													<img class="img-responsive" src="<?php echo esc_url( $featured_img[0] ); ?>" alt="<?php the_title(); ?>" />
												</a>
											</div>
										<?php } else { ?>
											<div class="widget-entry-image entry-thumbnail">
												<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-img-overlay">
													<img src="<?php echo TEMPLATETHEME_URL; ?>/images/empty-150.jpg" class="img-responsive" alt="<?php the_title(); ?>" />											
												</a>
											</div>
										<?php } ?>
										<div class="widget-entry-content">
											<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
											<div class="widget-entry-meta">
												<span class="entry-date"><?php the_time( $tpath_options['tpath_blog_date_format'] ); ?></span>
											</div>
										</div>										
									</li>
									<?php endwhile; ?>
								</ul>
							<?php } 
							wp_reset_postdata(); ?>
						</div>
					<?php } ?>
					<?php if($show_comments == 'on') { ?>
						<div id="tab-comments" class="tab-pane fade">
							<ul class="widget-posts-list">
								<?php
								$comments_query = new WP_Comment_Query();
								$comments = $comments_query->query( array( 'number' => $comments_count ) );
								if( $comments ) {
									foreach($comments as $comment) { ?>
										<li>
											<div class="widget-entry-image">
												<a class="author" href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>">
													<?php echo get_avatar( $comment->comment_author_email, '70' ); ?>
												</a>
											</div>
											<div class="widget-entry-content">
												<h5><a class="author" href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo strip_tags($comment->comment_author); ?>: </a></h5>
												<p><?php echo strip_tags( substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, 70 ) ); ?>...</p>												
											</div>
										</li>
									<?php } 
								} 
								wp_reset_postdata(); ?>
							</ul>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
		echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['show_popular_posts'] = $new_instance['show_popular_posts'];
		$instance['show_recent_posts'] = $new_instance['show_recent_posts'];
		$instance['show_comments'] = $new_instance['show_comments'];
		$instance['posts_count'] = $new_instance['posts_count'];
		$instance['recent_posts'] = $new_instance['recent_posts'];
		$instance['comments_count'] = $new_instance['comments_count'];	

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('show_popular_posts' => '', 'show_recent_posts' => '', 'show_comments' => '', 'posts_count' => '', 'recent_posts' => '', 'comments_count' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>		
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_popular_posts'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_popular_posts') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_popular_posts') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_popular_posts') ); ?>"><?php _e('Show Popular Posts', 'Templatepath'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_recent_posts'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_recent_posts') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_recent_posts') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_recent_posts') ); ?>"><?php _e('Show Recent Posts', 'Templatepath'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_comments'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_comments') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_comments') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_comments') ); ?>"><?php _e('Show Comments', 'Templatepath'); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>"><?php _e('Number of popular posts:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" style="width: 35px;" id="<?php echo esc_attr( $this->get_field_id('posts_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('posts_count') ); ?>" value="<?php echo esc_attr( $instance['posts_count'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('recent_posts') ); ?>"><?php _e('Number of recent posts:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" style="width: 35px;" id="<?php echo esc_attr( $this->get_field_id('recent_posts') ); ?>" name="<?php echo esc_attr( $this->get_field_name('recent_posts') ); ?>" value="<?php echo esc_attr( $instance['recent_posts'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('comments_count') ); ?>"><?php _e('Number of comments:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" style="width: 35px;" id="<?php echo esc_attr( $this->get_field_id('comments_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('comments_count') ); ?>" value="<?php echo esc_attr( $instance['comments_count'] ); ?>" />
		</p>
	<?php }
}

function tpath_tabs_load()
{
	register_widget('Tpath_Tabs_Widget');
}

add_action('widgets_init', 'tpath_tabs_load');

?>