<?php 
/**
 * The Shortcode
 */
function tpath_twitter_shortcode( $atts, $content = null ) {

	$output = $username = $consumer_key = $consumer_secret = $access_token = $access_token_secret = $limit_tweets = $visible_tweets = $navigation = '';
	
	extract( 
		shortcode_atts( 
			array(
				'username' 				=> '',
				'consumer_key' 			=> '',
				'consumer_secret' 		=> '',				
				'access_token' 			=> '',
				'access_token_secret' 	=> '',
				'limit_tweets' 			=> '5',
				'visible_tweets' 		=> '1',
				'navigation' 			=> 'true'
			), $atts 
		) 
	);
	
	$tweets_data = $data_attr = '';
	
	// Include twitteroauth Library
	require_once( TEMPLATETHEME_DIR . '/widgets/twitter-widget/twitteroauth.php' );	
    
	$key = 'tpath_twitter_feeds';
		
	// expires every hour  
	$expiration = 60 * 60;
	$transient = get_transient($key);

	if( base64_encode(base64_decode($transient, true)) === $transient ) {
		$transient = base64_decode($transient);
		$transient = unserialize($transient);
	} else {
		delete_transient($key);
		$transient = false;
	}
	
	if( false === $transient ) {
		// Get Access Token
		$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);	
		
		$params = array(
		  'count' 		=> $limit_tweets,
		  'screen_name' => $username
		);				
		
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		
		// Get Response data
		$tweets = $connection->get($url, $params);
		
		if( !empty($tweets) ) {
			// Update transient
			tpath_twitter_transient($key, $tweets, $expiration);
			$tweets_data = $tweets;
		}
	} else {
		// Soft expiration. $transient = array( expiration time, data)  
		if( $transient[0] !== 0 && (int) $transient[0] <= time() ) {

			// Expiration time passed, get new data 
			// Get Access Token
			$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);	
			
			$params = array(
			  'count' 		=> $limit_tweets,
			  'screen_name' => $username
			);				
			
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			
			// Get Response data
			$new_tweets = $connection->get($url, $params);
			
			if( !empty($new_tweets) ) {
				// If successful return update transient and new data  
				tpath_twitter_transient($key, $new_tweets, $expiration);
				$tweets_data = $new_tweets;
			}
		} else {		
			$tweets_data = $transient[1];
		}
	}
	
	// Check tweets array
	if($tweets_data && is_array($tweets_data)) {
		
		$data_attr .= ' data-items="' . $visible_tweets . '" ';
		$data_attr .= ' data-slideby="1" ';
		$data_attr .= ' data-items-tablet="' . $visible_tweets . '" ';
		$data_attr .= ' data-items-mobile-landscape="1" ';
		$data_attr .= ' data-items-mobile-portrait="1" ';
		
		$data_attr .= ' data-pagination="false" ';
		$data_attr .= ' data-navigation="'. $navigation .'" ';
		$data_attr .= ' data-autoplay="true" ';
		$data_attr .= ' data-autoplay-timeout="5000" ';
	
		$output = '<div id="tpath-twitter-slider" class="tpath-owl-carousel owl-carousel tpath-twitter-slider"'.$data_attr.'>';			
			foreach($tweets_data as $tweet) {
				$output .= '<div class="tweet-item">';
					$tweet_time = strtotime($tweet['created_at']); 
					$time_ago = tpath_tweet_time($tweet_time);
					
					$output .= '<div class="tpath_tweet_text">';
						$tweet_text = $tweet['text'];
						$tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $tweet_text);
						$tweet_text = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $tweet_text);
						$output .= $tweet_text;
					$output .= '</div>';
							
					$output .= '<p class="tweet-user-name">';
						$output .= '<span class="tweet-time">'. esc_html__('posted ', 'Templatepath') . $time_ago . esc_html__(' by ', 'Templatepath') .'</span>';
						$output .= '<a href="http://twitter.com/'. $tweet['user']['screen_name'] .'/statuses/'. $tweet['id_str'] .'">';
						$output .= $tweet['user']['screen_name'];
						$output .= '</a>';
					$output .= '</p>';
				$output .= '</div>';
			}
		$output .= '</div>';
	}
	
	return $output;
}
add_shortcode( 'tpath_twitter_slider', 'tpath_twitter_shortcode' );

// Twitter Connection
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

// Set Twitter Transient
function tpath_twitter_transient($key, $data, $expiration) {
    // Time when transient expires  
    $expire = time() + $expiration;
    $transient = array($expire, $data);
    $transient = serialize($transient);
    $transient = base64_encode($transient);

    set_transient($key, $transient);
}

// Time Format
function tpath_tweet_time( $time ) {
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

/**
 * The VC Element Config Functions
 */
function tpath_vc_twitter_shortcode() {
	vc_map( 
		array(
			"icon" 			=> 'tpath-vc-block',
			"name" 			=> __("Twitter Feeds", "Templatepath"),
			"base" 			=> "tpath_twitter_slider",
			"category" 		=> __("Theme Addons", "Templatepath"),
			"params" 		=> array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Twitter Username", "Templatepath"),
					"param_name" 	=> "username",
					"value" 		=> '',
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Consumer Key", "Templatepath"),
					"param_name" 	=> "consumer_key",
					"value" 		=> '',
					"description" 	=> ''
				),				
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Consumer Secret", "Templatepath"),
					"param_name" 	=> "consumer_secret",
					"value" 		=> '',
					"description" 	=> ''
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Access Token", "Templatepath"),
					"param_name" 	=> "access_token",
					"value" 		=> '',
					"description" 	=> ''
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Access Token Secret", "Templatepath"),
					"param_name" 	=> "access_token_secret",
					"value" 		=> '',
					"description" 	=> ''
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Number of Tweets to load?", "Templatepath"),
					"param_name" 	=> "limit_tweets",
					"value" 		=> '',
					"description" 	=> ''
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> __("Number of Tweets to visible?", "Templatepath"),
					"param_name" 	=> "visible_tweets",
					"value" 		=> '',
					"description" 	=> ''
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> __( "Show Slider Navigation?", "Templatepath" ),
					"param_name" 	=> "navigation",
					"value" 		=> array_flip(array(									
									'false'  => 'No',
									'true' 	 => 'Yes'
									)),
				),
			)
		) 
	);
}
add_action( 'vc_before_init', 'tpath_vc_twitter_shortcode' );