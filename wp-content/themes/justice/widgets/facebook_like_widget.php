<?php
class Tpath_Facebook_Like_Widget extends WP_Widget {

	function Tpath_Facebook_Like_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_facebook_like_widget', 'description' => 'Displays Facebook Like Box.');
		$control_options = array('id_base' => 'tpath_facebook_like-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_facebook_like-widget', 'Facebook Like Box', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$page_url = !empty($instance['page_url']) ? $instance['page_url'] : "http://www.facebook.com/FacebookDevelopers";
		$width = !empty($instance['width']) ? $instance['width'] : "300";
		$height = !empty($instance['height']) ? $instance['height'] : "360";
		$show_stream = !empty($instance['show_stream']) ? 'true' : 'false';
		$show_faces = !empty($instance['show_faces']) ? 'true' : 'false';
		$show_header = !empty($instance['show_header']) ? 'true' : 'false';
		$color_scheme = !empty($instance['color_scheme']) ? $instance['color_scheme'] : 'light';
		$background = $instance['background'];
		$border_size = $instance['border_size'];
		$border_radius = !empty($instance['border_radius']) ? $instance['border_radius'] : '0';
		$border_color = $instance['border_color'];

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) {
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
		
		echo "<script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
             </script>
  ";
        echo "<div id='tpath_facebook_like_widget' class='tpath_facebook_like_box' style='max-width: $width";
        echo "px;'>
		<div class='fbCustom' style='background:$background; width:100%;";
        echo "border: $border_size";
        echo "px solid $border_color; border-radius: $border_radius";
        echo "px; -moz-border-radius: $border_radius";
		echo "px; -webkit-border-radius: $border_radius";
		echo "px; -ms-border-radius: $border_radius";
		echo "px; -o-border-radius: $border_radius";
		echo "px;'> <div class='FBWrap' style='height:$height";
        echo "px; overflow: hidden;'>
            <div class='fb-like-box'
                data-width='$width' data-height='$height' 
                data-href='$page_url'
                data-border-color='$border_color' data-show-faces='$show_faces'
                data-stream='$show_stream' data-header='$show_header' data-color-scheme='$color_scheme'>
            </div>
         </div>";
		echo "</div></div>";
		
		echo wp_kses( $after_widget, justice_wp_allowed_tags() );
		
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['height'] = $new_instance['height'];
		$instance['show_stream'] = $new_instance['show_stream'];
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['show_header'] = $new_instance['show_header'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['background'] = $new_instance['background'];
		$instance['border_size'] = $new_instance['border_size'];
		$instance['border_radius'] = $new_instance['border_radius'];
		$instance['border_color'] = $new_instance['border_color'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'page_url' => '', 'width' => '', 'height' => '', 'background' => '', 'border_size' => '', 'border_radius' => '', 'border_color' => '', 'show_stream' => '', 'show_faces' => '', 'show_header' => '', 'color_scheme' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function() {
			jQuery('.tpath-widget-color').each(function(){
				var $this = jQuery(this),
					id = $this.attr('id');
				jQuery('#' + id).wpColorPicker();
			});
		});
		//]]>
		</script>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('page_url') ); ?>"><?php _e('Facebook Page URL:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('page_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('page_url') ); ?>" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('width') ); ?>"><?php _e('Width:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('width') ); ?>" name="<?php echo esc_attr( $this->get_field_name('width') ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('height') ); ?>"><?php _e('Height:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('height') ); ?>" name="<?php echo esc_attr( $this->get_field_name('height') ); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_stream'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_stream') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_stream') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_stream') ); ?>"><?php _e('Show Stream', 'Templatepath'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_faces'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_faces') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_faces') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_faces') ); ?>"><?php _e('Show Faces', 'Templatepath'); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked(esc_attr( $instance['show_header'] ), 'on'); ?> id="<?php echo esc_attr( $this->get_field_id('show_header') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_header') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id('show_header') ); ?>"><?php _e('Show Header', 'Templatepath'); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('color_scheme') ); ?>"><?php _e('Color Scheme:', 'Templatepath'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('color_scheme' )); ?>" name="<?php echo esc_attr( $this->get_field_name('color_scheme') ); ?>" class="widefat" style="width:100%;">				
				<option value="light" <?php echo selected(esc_attr($instance['color_scheme']),'light', false); ?>>Light</option>
				<option value="dark" <?php echo selected(esc_attr($instance['color_scheme']),'dark', false); ?>>Dark</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('background') ); ?>"><?php _e('Background Color:', 'Templatepath'); ?></label>
			<input class="widefat tpath-widget-color" id="<?php echo esc_attr( $this->get_field_id('background') ); ?>" name="<?php echo esc_attr( $this->get_field_name('background') ); ?>" value="<?php echo esc_attr( $instance['background'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('border_size') ); ?>"><?php _e('Border Size:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('border_size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('border_size') ); ?>" value="<?php echo esc_attr( $instance['border_size'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('border_radius') ); ?>"><?php _e('Border Radius:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('border_radius') ); ?>" name="<?php echo esc_attr( $this->get_field_name('border_radius') ); ?>" value="<?php echo esc_attr( $instance['border_radius'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('border_color') ); ?>"><?php _e('Border Color:', 'Templatepath'); ?></label>
			<input class="widefat tpath-widget-color" id="<?php echo esc_attr( $this->get_field_id('border_color') ); ?>" name="<?php echo esc_attr( $this->get_field_name('border_color') ); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" />
		</p>
			
	<?php }
}

function tpath_load_color_picker_script()
{
	wp_enqueue_script( 'wp-color-picker' );
}
function tpath_load_color_picker_style()
{
	wp_enqueue_style( 'wp-color-picker' );
}
function tpath_facebook_like_widget_load()
{
	register_widget('Tpath_Facebook_Like_Widget');
}

add_action('admin_print_scripts-widgets.php', 'tpath_load_color_picker_script');
add_action('admin_print_styles-widgets.php', 'tpath_load_color_picker_style');
add_action('widgets_init', 'tpath_facebook_like_widget_load');
?>