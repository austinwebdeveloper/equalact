<?php
class tpath_social_links_Widget extends WP_Widget {
	
	function tpath_social_links_Widget()
	{				
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_social_links_widget', 'description' => 'Display Social links.');
		$control_options = array('id_base' => 'tpath_social_links_widget-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_social_links_widget-widget', 'Social Links', $widget_options, $control_options);
	
	}	

	function widget($args, $instance)
	{
		extract($args);
		
		$facebook 	= $instance['facebook'];
		$twitter 	= $instance['twitter'];
		$pinterest 	= $instance['pinterest'];
		$googleplus = $instance['googleplus'];
		$linkedin 	= $instance['linkedin'];
		$youtube 	= $instance['youtube'];
		$rss 		= $instance['rss'];
		$tumblr 	= $instance['tumblr'];
		$dribbble 	= $instance['dribbble'];
		$flickr 	= $instance['flickr'];
		$instagram 	= $instance['instagram'];
		$vimeo 		= $instance['vimeo'];
		$skype 		= $instance['skype'];
		$yahoo 		= $instance['yahoo'];
		
		$title = apply_filters('widget_title', $instance['title']);
		
		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
		
		$social_links = array();
		
		if( isset( $facebook ) && $facebook ) {
			$social_links['facebook'] = $facebook;
		}
		if( isset( $twitter ) && $twitter ) {
			$social_links['twitter'] = $twitter;
		}
		if( isset( $pinterest ) && $pinterest ) {
			$social_links['pinterest'] = $pinterest;
		}
		if( isset( $googleplus ) && $googleplus ) {
			$social_links['google-plus'] = $googleplus;
		}
		if( isset( $linkedin ) && $linkedin ) {
			$social_links['linkedin'] = $linkedin;
		}
		if( isset( $youtube ) && $youtube ) {
			$social_links['youtube'] = $youtube;
		}
		if( isset( $rss ) && $rss ) {
			$social_links['rss'] = $rss;
		}
		if( isset( $tumblr ) && $tumblr ) {
			$social_links['tumblr'] = $tumblr;
		}
		if( isset( $dribbble ) && $dribbble ) {
			$social_links['dribbble'] = $dribbble;
		}
		if( isset( $flickr ) && $flickr ) {
			$social_links['flickr'] = $flickr;
		}
		if( isset( $instagram ) && $instagram ) {
			$social_links['instagram'] = $instagram;
		}
		if( isset( $vimeo ) && $vimeo ) {
			$social_links['vimeo'] = $vimeo;
		}
		if( isset( $skype ) && $skype ) {
			$social_links['skype'] = $skype;
		}
		if( isset( $yahoo ) && $yahoo ) {
			$social_links['yahoo'] = $yahoo;
		}
		
		$icon_class = '';
		$li_html = '';
		
		if( isset( $social_links ) && is_array( $social_links ) ) {
			foreach( $social_links as $icon => $link ) {
				$icon_class = $icon;
				
				if( $icon == 'vimeo' ) {
					$icon = 'flaticon flaticon-social140';
				} else {
					$icon = 'fa fa-' . $icon;
				}
				
				$li_html .= '<li class="'.esc_attr( $icon_class ).'"><a target="_blank" href="'.esc_url( $link ).'"><i class="'.esc_attr( $icon ).'"></i></a></li>';
			}
		}
		
		if( isset( $li_html ) && $li_html != '' ) {
			echo '<ul class="tpath-social-icons widget-soc-icon">'. $li_html .'</ul>';
		} ?>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] 		= $new_instance['title'];
		$instance['icon_type'] 	= $new_instance['icon_type'];
		$instance['facebook'] 	= $new_instance['facebook'];
		$instance['twitter'] 	= $new_instance['twitter'];
		$instance['pinterest'] 	= $new_instance['pinterest'];
		$instance['googleplus'] = $new_instance['googleplus'];
		$instance['linkedin'] 	= $new_instance['linkedin'];
		$instance['youtube'] 	= $new_instance['youtube'];
		$instance['rss'] 		= $new_instance['rss'];
		$instance['tumblr'] 	= $new_instance['tumblr'];
		$instance['dribbble'] 	= $new_instance['dribbble'];
		$instance['flickr'] 	= $new_instance['flickr'];
		$instance['instagram'] 	= $new_instance['instagram'];
		$instance['vimeo'] 		= $new_instance['vimeo'];
		$instance['skype'] 		= $new_instance['skype'];
		$instance['yahoo'] 		= $new_instance['yahoo'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'icon_type' => '', 'facebook' => '', 'twitter' => '', 'pinterest' => '', 'googleplus' => '', 'linkedin' => '', 'youtube' => '', 'rss' => '', 'tumblr' => '', 'dribbble' => '', 'flickr' => '', 'instagram' => '', 'vimeo' => '', 'skype' => '', 'yahoo' => '' );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('facebook') ); ?>"><?php _e('Facebook URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('facebook') ); ?>" name="<?php echo esc_attr( $this->get_field_name('facebook') ); ?>" value="<?php echo esc_attr( $instance['facebook'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>"><?php _e('Twitter URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>" name="<?php echo esc_attr( $this->get_field_name('twitter') ); ?>" value="<?php echo esc_attr( $instance['twitter'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('pinterest') ); ?>"><?php _e('Pinterest URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('pinterest') ); ?>" name="<?php echo esc_attr( $this->get_field_name('pinterest') ); ?>" value="<?php echo esc_attr( $instance['pinterest'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('googleplus') ); ?>"><?php _e('Google Plus URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('googleplus') ); ?>" name="<?php echo esc_attr( $this->get_field_name('googleplus') ); ?>" value="<?php echo esc_attr( $instance['googleplus'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('linkedin') ); ?>"><?php _e('Linkedin URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('linkedin') ); ?>" name="<?php echo esc_attr( $this->get_field_name('linkedin') ); ?>" value="<?php echo esc_attr( $instance['linkedin'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('youtube') ); ?>"><?php _e('Youtube URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('youtube') ); ?>" name="<?php echo esc_attr( $this->get_field_name('youtube') ); ?>" value="<?php echo esc_attr( $instance['youtube'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('rss') ); ?>"><?php _e('Rss URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('rss') ); ?>" name="<?php echo esc_attr( $this->get_field_name('rss') ); ?>" value="<?php echo esc_attr( $instance['rss'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('tumblr') ); ?>"><?php _e('Tumblr URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('tumblr') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tumblr') ); ?>" value="<?php echo esc_attr( $instance['tumblr'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('dribbble') ); ?>"><?php _e('Dribbble URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('dribbble') ); ?>" name="<?php echo esc_attr( $this->get_field_name('dribbble') ); ?>" value="<?php echo esc_attr( $instance['dribbble'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('flickr') ); ?>"><?php _e('Flickr URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('flickr') ); ?>" name="<?php echo esc_attr( $this->get_field_name('flickr') ); ?>" value="<?php echo esc_attr( $instance['flickr'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('instagram') ); ?>"><?php _e('Instagram URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('instagram') ); ?>" name="<?php echo esc_attr( $this->get_field_name('instagram') ); ?>" value="<?php echo esc_attr( $instance['instagram'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('vimeo') ); ?>"><?php _e('Vimeo URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('vimeo') ); ?>" name="<?php echo esc_attr( $this->get_field_name('vimeo') ); ?>" value="<?php echo esc_attr( $instance['vimeo'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('skype') ); ?>"><?php _e('Skype URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('skype') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skype') ); ?>" value="<?php echo esc_attr( $instance['skype'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('yahoo') ); ?>"><?php _e('Yahoo URL:', 'tpath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('yahoo') ); ?>" name="<?php echo esc_attr( $this->get_field_name('yahoo') ); ?>" value="<?php echo esc_attr( $instance['yahoo'] ); ?>" />
		</p>
	<?php }
}

function tpath_social_links_load()
{
	register_widget('tpath_social_links_Widget');
}

add_action('widgets_init', 'tpath_social_links_load');
?>