<?php
class Tpath_Flickr_Widget extends WP_Widget {

	function Tpath_Flickr_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_flickr_widget', 'description' => 'Displays your recent photos from Flickr.');
		$control_options = array('id_base' => 'tpath_flickr_widget-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_flickr_widget-widget', 'Flickr', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);

		$user_id = $instance['user_id'];
		$photo_count = $instance['photo_count'];
		$api_key = $instance['api_key'];
		if(empty($api_key)) {
			$api_key = '9a0554259914a86fb9e7eb014e4e5d52';
		}
		$size = isset($instance['size']) ? $instance['size'] : 's';
		$title = apply_filters('widget_title', $instance['title']);

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		} 
		
		if( $user_id != '' ) {
			
			// Get Image Links
			$get_url = wp_remote_get('https://api.flickr.com/services/rest/?method=flickr.urls.getUserPhotos&api_key='.$api_key.'&user_id='.$user_id.'&format=json');
			
			if(is_array($get_url) && array_key_exists('body', $get_url))
			{
				$get_url = trim($get_url['body'], 'jsonFlickrApi()');
				$get_url = json_decode($get_url);				
			}		
			
			// Get Images
			$get_photos = wp_remote_get('https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key='.$api_key.'&user_id='.$user_id.'&per_page='.$photo_count.'&format=json');
			
			if(is_array($get_photos) && array_key_exists('body', $get_photos))
			{
				$get_photos = trim($get_photos['body'], 'jsonFlickrApi()');
				$get_photos = json_decode($get_photos);				
			}
			//$get_photos = trim($get_photos['body'], 'jsonFlickrApi()');
			//$get_photos = json_decode($get_photos);
			
			?>
			
			<ul class='tpath_flickr_widget list-unstyled'>
				<?php 
				foreach($get_photos->photos->photo as $photo) {					
					$photo = (array) $photo; ?>

					<li class='flickr_photo_item'>	
						<a href='<?php echo esc_url( $get_url->user->url ); ?><?php echo esc_attr($photo['id']); ?>' target='_blank' title="<?php echo esc_attr($photo['title']); ?>">	
							<img src='<?php $url = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "_".$size."" . ".jpg"; echo esc_url( $url ); ?>' alt='<?php echo esc_attr( $photo['title'] ); ?>' />	
						</a>	
					</li>

				<?php } ?>
			</ul>
		
		<?php } ?>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['user_id'] = $new_instance['user_id'];
		$instance['photo_count'] = $new_instance['photo_count'];
		$instance['api_key'] = $new_instance['api_key'];
		$instance['size'] = $new_instance['size'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'user_id' => '', 'photo_count' => '', 'api_key' => '', 'size' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
			
		$sizes = array(
			's' => esc_attr__( 'Standard', 'Templatepath' ),
			't' => esc_attr__( 'Thumbnail', 'Templatepath' ),
			'q' => esc_attr__( 'Large Square', 'Templatepath' ),
			'm' => esc_attr__( 'Medium', 'Templatepath' )
		);
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('user_id') ); ?>"><?php _e('Flickr ID:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('user_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('user_id') ); ?>" value="<?php echo esc_attr( $instance['user_id'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('photo_count') ); ?>"><?php _e('Number of Photos to show:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('photo_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('photo_count') ); ?>" value="<?php echo esc_attr( $instance['photo_count'] ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('api_key') ); ?>"><?php _e('API Key:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('api_key') ); ?>" name="<?php echo esc_attr( $this->get_field_name('api_key') ); ?>" value="<?php echo esc_attr( $instance['api_key'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('size') ); ?>"><?php _e( 'Sizes:', 'Templatepath' ); ?></label>			
			<select id="<?php echo esc_attr( $this->get_field_id('size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('size') ); ?>">
				<?php foreach ( $sizes as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['size'], $key ); ?>><?php echo esc_attr( $value ); ?></option>
				<?php } ?>
			</select>				
		</p>
	<?php }
}

function tpath_flickr_load()
{
	register_widget('Tpath_Flickr_Widget');
}

add_action('widgets_init', 'tpath_flickr_load');
?>