<?php
class Tpath_Instagram_Widget extends WP_Widget {

	function Tpath_Instagram_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_instagram_widget', 'description' => 'Displays your latest photos from Instagram.');
		$control_options = array('id_base' => 'tpath_instagram_widget-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_instagram_widget-widget', 'Instagram', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);

		$user_name = $instance['user_name'];
		$photo_count = isset($instance['photo_count']) ? $instance['photo_count'] : 6;
		$size = isset($instance['size']) ? $instance['size'] : 'thumbnail';
		$link_text = $instance['link_text'];
		$link_target = isset($instance['link_target']) ? $instance['link_target'] : '_self';
		$title = apply_filters('widget_title', $instance['title']);

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
		
		if ($user_name != '') {
		
			// Get Photos Array 
			$media_array = $this->scrape_instagram($user_name, $photo_count); ?>
			
			<ul class="tpath_instagram_widget list-unstyled">
				<?php foreach($media_array as $item) {
						echo '<li class="instagram-item"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $link_target ) .'"><img src="'. esc_url($item[$size]['url']) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a></li>';
					}
				?>
			</ul>
			
		<?php }
		
		if($link_text != '') { ?>
			<p class="instagram-link"><a href="http://instagram.com/<?php echo trim($user_name); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link_text ); ?></a></p>
		<?php } ?>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}
	
	// code modified from https://gist.github.com/cosmocatalano/4544576
	function scrape_instagram($user_name, $photos_count) {
	
		if(false === ($instagram = get_transient('tpath-instagram-'.sanitize_title_with_dashes($user_name)))) {
			
			// Get media array for user name
			$remote = wp_remote_get('http://instagram.com/'.trim($user_name));
			$shards = explode('window._sharedData = ', $remote['body']);
			$insta_json = explode(';</script>', $shards[1]);
			$insta_array = json_decode($insta_json[0], TRUE);

			$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];

			$instagram = array();

			foreach($images as $image) {				
				if($image['user']['username'] == $user_name && $image['type'] == 'image' ) {

					$image['link']                          = preg_replace( "/^http:/i", "", $image['link'] );
					$image['images']['thumbnail']           = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
					$image['images']['low_resolution'] 		= preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
					$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );

					$instagram[] = array(
						'description'   => $image['caption']['text'],
						'link'          => $image['link'],
						'time'          => $image['created_time'],
						'comments'      => $image['comments']['count'],
						'likes'         => $image['likes']['count'],
						'thumbnail'     => $image['images']['thumbnail'],
						'medium'        => $image['images']['standard_resolution'],
						'large'         => $image['images']['standard_resolution'],
						'type'          => $image['type']
					);
				}
			}

			$instagram = base64_encode( serialize( $instagram ) );
			set_transient('tpath-instagram-'.sanitize_title_with_dashes($user_name), $instagram, HOUR_IN_SECONDS * 2);
		}

		$instagram = unserialize( base64_decode( $instagram ) );

		return array_slice($instagram, 0, $photos_count);
	}


	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['user_name'] = $new_instance['user_name'];
		$instance['photo_count'] = $new_instance['photo_count'];
		$instance['size'] = $new_instance['size'];
		$instance['link_text'] = $new_instance['link_text'];
		$instance['link_target'] = $new_instance['link_target'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'user_name' => '', 'photo_count' => '', 'size' => '', 'link_text' => '', 'link_target' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
			
		$sizes = array(
			'thumbnail' => esc_attr__( 'Thumbnail', 'Templatepath' ),
			'medium' => esc_attr__( 'Medium', 'Templatepath' ),
			'large' => esc_attr__( 'Large', 'Templatepath' )			
		);
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('user_name') ); ?>"><?php _e('User name:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('user_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('user_name') ); ?>" value="<?php echo esc_attr( $instance['user_name'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('photo_count') ); ?>"><?php _e('Number of Photos to show:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('photo_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('photo_count') ); ?>" value="<?php echo esc_attr( $instance['photo_count'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('size') ); ?>"><?php _e( 'Sizes:', 'Templatepath' ); ?></label>			
			<select id="<?php echo esc_attr( $this->get_field_id('size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('size') ); ?>">
				<?php foreach ( $sizes as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['size'], $key ); ?>><?php echo esc_attr( $value ); ?></option>
				<?php } ?>
			</select>				
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('link_text') ); ?>"><?php _e('Link Text:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('link_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link_text') ); ?>" value="<?php echo esc_attr( $instance['link_text'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('link_target') ); ?>"><?php _e('Link Target:', 'Templatepath'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('link_target') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link_target') ); ?>" class="widefat" style="width:100%;">
				<option value="_blank" <?php echo selected(esc_attr($instance['link_target']), '_blank', false); ?>><?php _e('Open in a New Tab', 'Templatepath'); ?></option>
				<option value="_self" <?php echo selected(esc_attr($instance['link_target']), '_self', false); ?>><?php _e('Open in a Same Tab', 'Templatepath'); ?></option>				
			</select>
		</p>
	<?php }
}

function tpath_instagram_load()
{
	register_widget('Tpath_Instagram_Widget');
}

add_action('widgets_init', 'tpath_instagram_load');
?>