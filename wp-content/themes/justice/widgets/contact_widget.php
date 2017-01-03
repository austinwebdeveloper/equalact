<?php
class Tpath_Contact_Info_Widget extends WP_Widget {

	function Tpath_Contact_Info_Widget()
	{
		/* Widget settings. */
		$widget_options = array('classname' => 'tpath_contact_info_widget', 'description' => 'Displays your contact info.');
		$control_options = array('id_base' => 'tpath_contact_info-widget');
		
		/* Create the widget. */
		parent::__construct('tpath_contact_info-widget', 'Contact Info', $widget_options, $control_options);
	}

	function widget($args, $instance)
	{
		extract($args);

		$address = $instance['address'];
		$website = $instance['website'];
		$telephone = $instance['telephone'];
		$phone = $instance['phone'];
		$fax = $instance['fax'];
		$email_1 = $instance['email_1'];
		$email_2 = $instance['email_2'];
		$title = apply_filters('widget_title', $instance['title']); 

		echo wp_kses( $before_widget, justice_wp_allowed_tags() );
		
		if($title) { 
			echo wp_kses( $before_title . $title . $after_title, justice_wp_allowed_tags() );
		}
		?>	
		
		<div id="tpath_contact_info_widget" class="tpath-contact_info">
			<div class="contact_info-inner">	
				<?php if( isset( $address ) && $address != '' ) { ?>
					<p class="address"><span class="contact-widget-title"><i class="fa fa-map-marker cinfo-icon"></i></span><span class="contact-widget-text"><?php echo esc_html( $address ); ?></span></p>
				<?php } ?>			
				<?php if( isset( $telephone ) && $telephone != '' ) { ?>
					<p class="telephone"><span class="contact-widget-title"><i class="fa fa-phone cinfo-icon"></i></span><span class="contact-widget-text"><?php echo esc_html( $telephone ); ?></span></p>
				<?php } ?>
				<?php if( isset( $phone ) && $phone != '' ) { ?>
					<p class="phone"><span class="contact-widget-title"><i class="fa fa-mobile cinfo-icon"></i></span><span class="contact-widget-text"><?php echo esc_html( $phone ); ?></span></p>
				<?php } ?>
				<?php if( isset( $fax ) && $fax != '' ) { ?>
					<p class="fax"><span class="contact-widget-title"><i class="fa fa-print cinfo-icon"></i></span><span class="contact-widget-text"><?php echo esc_html( $fax ); ?></span></p>
				<?php } ?>
				<?php if( isset( $email_1 ) && $email_1 != '' ) { ?>
					<p class="email_1"><span class="contact-widget-title"><i class="fa fa-envelope cinfo-icon"></i></span><span class="contact-widget-text"><a href="mailto:<?php echo esc_html( $email_1 ); ?>"><?php echo esc_html( $email_1 ); ?></a></span></p>
				<?php } ?>
				<?php if( isset( $email_2 ) && $email_2 != '' ) { ?>
					<p class="email_2"><span class="contact-widget-title"><i class="fa fa-envelope-o cinfo-icon"></i></span><span class="contact-widget-text"><a href="mailto:<?php echo esc_html( $email_2 ); ?>"><?php echo esc_html( $email_2 ); ?></a></span></p>
				<?php } ?>	
				<?php if( isset( $website ) &&  $website != '' ) { ?>
					<p class="website"><span class="contact-widget-title"><i class="fa fa-globe cinfo-icon"></i></span><span class="contact-widget-text"><a href="<?php echo esc_html( $website ); ?>" target="_blank"><?php echo esc_html( $website ); ?></a></span></p>
				<?php } ?>			
			</div>
		</div>
		
		<?php echo wp_kses( $after_widget, justice_wp_allowed_tags() );
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['address'] = $new_instance['address'];
		$instance['website'] = $new_instance['website'];
		$instance['telephone'] = $new_instance['telephone'];
		$instance['phone'] = $new_instance['phone'];
		$instance['fax'] = $new_instance['fax'];
		$instance['email_1'] = $new_instance['email_1'];
		$instance['email_2'] = $new_instance['email_2'];
		
	
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '', 'address' => '', 'website' => '', 'telephone' => '', 'phone' => '', 'email_1' => '', 'email_2' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Address:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('address') ); ?>" name="<?php echo esc_attr( $this->get_field_name('address') ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Website:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('website') ); ?>" name="<?php echo esc_attr( $this->get_field_name('website') ); ?>" value="<?php echo esc_attr( $instance['website'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Telephone:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('telephone') ); ?>" name="<?php echo esc_attr( $this->get_field_name('telephone') ); ?>" value="<?php echo esc_attr( $instance['telephone'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Phone:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('phone') ); ?>" name="<?php echo esc_attr( $this->get_field_name('phone') ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Fax:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('fax') ); ?>" name="<?php echo esc_attr( $this->get_field_name('fax') ); ?>" value="<?php echo esc_attr( $instance['fax'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Email 1:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('email_1') ); ?>" name="<?php echo esc_attr( $this->get_field_name('email_1') ); ?>" value="<?php echo esc_attr( $instance['email_1'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php _e('Email 2:', 'Templatepath'); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('email_2') ); ?>" name="<?php echo esc_attr( $this->get_field_name('email_2') ); ?>" value="<?php echo esc_attr( $instance['email_2'] ); ?>" />
		</p>


	<?php }
}

function tpath_contact_info_load()
{
	register_widget('Tpath_Contact_Info_Widget');
}

add_action('widgets_init', 'tpath_contact_info_load');
?>