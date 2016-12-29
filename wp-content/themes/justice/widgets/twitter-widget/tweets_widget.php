<?php
class Tpath_Tweets_Widget extends WP_Widget {

	function Tpath_Tweets_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_tweets_widget', 'description' => 'Displays Twitter feeds.');
		$control_options = array('id_base' => 'tpath_tweets-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_tweets-widget', 'Twitter Feeds', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$twitter_id = $instance['twitter_id'];
		$consumer_key = $instance['consumer_key'];
		$consumer_secret = $instance['consumer_secret'];
		$access_token = $instance['access_token'];
		$access_token_secret = $instance['access_token_secret'];
		$tweet_count = (int) $instance['tweet_count'];
		$visible_tweets = (int) $instance['visible_tweets'];
		
		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		} 
		
		// Include Main Library File
		require_once( TEMPLATETHEME_DIR . '/widgets/twitter-widget/twitteroauth.php' );
		
		//set transient name
		$transient_name = 'tpath_list_tweets_' . strtolower($twitter_id);
		
		//refresh to delete transient
		delete_transient($transient_name);
		
		// Get Access Token
		$connection = $this->getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);				
			
		$params = array(
		  'count' => $tweet_count,
		  'screen_name' => $twitter_id
		);				
		
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		
		// Get Response data
		$tweets = $connection->get($url, $params);	
		
		// Set it to transient
		set_transient($transient_name, $tweets, 60 * 10);
		
		// Check tweets array
		if($tweets && is_array($tweets)) { 
		
			wp_enqueue_script( 'justice-easy-ticker-js' ); ?>
		
			<div class="tpath-twitter-widget tpath-twitter-slide" data-visible="<?php echo esc_attr( $visible_tweets ); ?>">
				<div class="twitter-box">
					<?php foreach($tweets as $tweet) { ?>
						<div class="tweet-item">
							<p class="tpath_tweet_text">
								<?php $tweet_text = $tweet['text'];
								$tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $tweet_text);
								$tweet_text = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $tweet_text);
								echo wp_kses_post( $tweet_text ); ?>
							</p>
							
							<?php $tweet_time = strtotime($tweet['created_at']); 
							$time_ago = tpath_tweet_time($tweet_time);  ?>
							<p class="tweet-user-name"><span class="tweet-time"># <?php echo esc_attr( $time_ago ); ?></span></p>								
						</div>
					<?php } ?>
				</div>
			</div>
			
		<?php } ?>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}
	
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) 
	{
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
	
	// Time Format
	function tpath_widget_tweet_time( $time ) {
		$periods = array( __( 'second', 'Templatepath' ), __( 'minute', 'Templatepath' ), __( 'hour', 'Templatepath' ), __( 'day', 'Templatepath' ), __( 'week', 'Templatepath' ), __( 'month', 'Templatepath' ), __( 'year', 'Templatepath' ), __( 'decade', 'Templatepath' ) );
		
		$lengths = array( '60', '60', '24', '7', '4.35', '12', '10' );
		$now = time();
		$difference = $now - $time;
		
		$tense = __( 'ago', 'Templatepath' );
	
		for( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths )-1; $j++ ) {
			$difference /= $lengths[$j];
		}
	
		$difference = round( $difference );
	
		if( $difference != 1 ) {
			$periods[$j] .= __( 's', 'Templatepath' );
		}
	
	   return sprintf('%s %s %s', $difference, $periods[$j], $tense );
	}

		
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['tweet_count'] = $new_instance['tweet_count'];
		$instance['visible_tweets'] = $new_instance['visible_tweets'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'twitter_id' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '', 'tweet_count' => '', 'visible_tweets' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('twitter_id') ); ?>"><?php _e('Twitter ID:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('twitter_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('twitter_id') ); ?>" value="<?php echo esc_attr( $instance['twitter_id'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('consumer_key') ); ?>"><?php _e('Consumer Key:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('consumer_key') ); ?>" name="<?php echo esc_attr( $this->get_field_name('consumer_key') ); ?>" value="<?php echo esc_attr( $instance['consumer_key'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('consumer_secret') ); ?>"><?php _e('Consumer Secret:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('consumer_secret') ); ?>" name="<?php echo esc_attr( $this->get_field_name('consumer_secret') ); ?>" value="<?php echo esc_attr( $instance['consumer_secret'] ); ?>" />
		</p>				
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('access_token') ); ?>"><?php _e('Access Token:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('access_token') ); ?>" name="<?php echo esc_attr( $this->get_field_name('access_token') ); ?>" value="<?php echo esc_attr( $instance['access_token'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('access_token_secret') ); ?>"><?php _e('Access Token Secret:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('access_token_secret') ); ?>" name="<?php echo esc_attr( $this->get_field_name('access_token_secret') ); ?>" value="<?php echo esc_attr( $instance['access_token_secret'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('tweet_count') ); ?>"><?php _e('Number of Tweets:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('tweet_count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tweet_count') ); ?>" value="<?php echo esc_attr( $instance['tweet_count'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('visible_tweets') ); ?>"><?php _e('Number of Visible Tweets:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('visible_tweets') ); ?>" name="<?php echo esc_attr( $this->get_field_name('visible_tweets') ); ?>" value="<?php echo esc_attr( $instance['visible_tweets'] ); ?>" />
		</p>	
			
	<?php }
}

function tpath_tweets_widget_load()
{
	register_widget('Tpath_Tweets_Widget');
}

add_action('widgets_init', 'tpath_tweets_widget_load');
?>