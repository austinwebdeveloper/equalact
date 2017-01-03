<?php 
/**
 * Register field types for metaboxes
 *
 * @package TemplatePath
 */
 
class TpathMetaboxFields { 
	
	public function render_fields( $fields ) 
	{
	
		global $post;
		
		foreach ( $fields as $field ) {

			switch ( $field['type'] ) {				
			
				case 'title':					
					echo '<hr><h1 class="tpath-field-title">';
					echo esc_attr( $field['name'] );
					echo '</h1>';
					if( isset( $field['desc'] ) && $field['desc'] != '' ) {
						echo '<p class="description">' . $field['desc'] . '</p>';
					}
					echo '<hr>';
					 
				break;
				
				case 'sub_title':								
					echo '<h2 class="tpath-field-sub-title">';
					echo esc_attr( $field['name'] );
					echo '</h2>';										 
				break;
				
				case 'button':					
					echo '<a href="#" class="'.$field['id'].' button-primary">';
					echo esc_attr( $field['name'] );
					echo '</a>';										 
				break;
			
				case 'text':
					$value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-text fields">';
						echo '<input type="text" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . esc_attr( $value ) . '" />';
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
						
					echo '</div>';					
					 
				break;
					
				case 'textarea':
					$value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-textarea fields">';
						echo '<textarea cols="70" rows="6" id="' . $field['id'] . '" name="' . $field['id'] . '">' . esc_attr( $value ) . '</textarea>';
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';						
					echo '</div>';
					
				break;
					
				case 'images':
				
					$i = 0;
					$selected_value = '';					
					$format = '';
					
					$selected_value = get_post_meta($post->ID, $field['id'], true);
	
					foreach( $field['options'] as $key => $option ) {
						
						 $i++;
	
						 $checked = '';
						 $selected = '';
						 
						 if( $selected_value != '' ) {
							if( '' != checked($selected_value, $key, false)) {
								$checked = checked($selected_value, $key, false);
								$selected = 'tpath-radio-img-selected'; 
							}
						}
						
						$format .= '<span>'; 
						$format .= '<input type="radio" id="tpath-radio-img-' . $field['id'] . $i . '" class="checkbox tpath-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . $field['id'] . '" ' . $checked . ' />';
						$format .= '<div class="tpath-radio-img-label">'. esc_attr( $key ) .'</div>';
						$format .= '<img src="' . esc_url( $option ) . '" alt="" class="tpath-radio-img-img '. $selected .'" onClick="document.getElementById(\'tpath-radio-img-'. $field['id'] . $i.'\').checked = true;" />';
						$format .= '</span>';
					
					}
					
					echo '<div class="tpath_metabox_field">';
						
						echo '<label class="radio" for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-images fields">'. $format .'';						
							if( isset( $field['desc'] ) && $field['desc'] != '' ) {
								echo '<p class="description">' . $field['desc'] . '</p>';
							}
						echo '</div>';
							
					echo '</div>';					
					
				break;
					
				case 'select':
				
					$selected_value = '';				
				
					$selected_value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="select_wrapper tpath_metabox_field">';
					
						echo '<label class="select" for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-select fields">';							
						echo '<select class="select-box" name="'.$field['id'].'" id="'. $field['id'] .'">';
						
						if( isset( $field['options'] ) ) {

							foreach( $field['options'] as $select_id => $option ) { 
								//$value = $option;
								
								//if (!is_numeric($select_id))
									$value = $select_id;
									
								echo '<option id="' . $select_id . '" value="'.$value.'" ' . selected($selected_value, $value, false) . ' />'.$option.'</option>';
							}
						
						}
						echo '</select>';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
					
					echo '</div></div>';					
					
				break;
				
				case 'multiselect':
				
					$selected_value = '';				
					
					echo '<div class="multiselect_wrapper tpath_metabox_field">';
					
						echo '<label class="multi-select" for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-multiselect fields">';							
						echo '<select multiple="multiple" class="multiselect-box" name="'.$field['id'].'[]" id="'. $field['id'] .'[]">';
						
						if( isset( $field['options'] ) ) { 

							foreach( $field['options'] as $select_id => $option ) { 
															
								if( is_array(get_post_meta($post->ID, $field['id'], true)) && in_array($select_id, get_post_meta($post->ID, $field['id'], true)) ) {
									$selected_value = $select_id;
								}
									
								echo '<option id="' . $select_id . '" value="'.$select_id.'" ' . selected($selected_value, $select_id, false) . ' />'.$option.'</option>';
							}
						
						}
						echo '</select>';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
					
					echo '</div></div>';
					
				break;
				
				case 'chosen':
				
					$selected_value = '';
					
					echo '<div class="chosen_select_wrapper tpath_metabox_field">';
					
						echo '<label class="chosen-select" for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-chosen fields">';							
						echo '<select class="chosen-select" multiple="multiple" style="width:350px;" name="'.$field['id'].'[]" id="'. $field['id'] .'[]">';
						
						echo '<option></option>';
						
						if( isset( $field['options'] ) ) {

							foreach( $field['options'] as $select_id => $option ) { 
							
								if( is_array(get_post_meta($post->ID, $field['id'], true)) && in_array($select_id, get_post_meta($post->ID, $field['id'], true)) ) {
									$selected_value = $select_id;
								}							
									
								echo '<option id="' . $select_id . '" value="'.$select_id.'" ' . selected($selected_value, $select_id, false) . ' >'.$option.'</option>';
							}
						
						}
						echo '</select>';
						
						echo '<input type="hidden" name="'.$field['id'].'[]" id="'.$field['id'].'[]" value="-1" />';
						
						echo '<input type="hidden" class="chosen-order" name="' . $field['hidden_id'] . '" id="' . $field['hidden_id'] . '" value="'.get_post_meta($post->ID, $field['hidden_id'], true).'" />';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
					
					echo '</div></div>';
										
				break;
				
				case 'media':
					$value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-upload fields">';						
						echo '<input type="text" class="tpath-meta-upload media_field" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . esc_url( $value ) . '" />';
						echo '<button type="button" class="tpath_meta_upload_button btn">'. __( 'Upload', 'Templatepath' ) .'</button>';
						echo '<button type="button" class="tpath_meta_remove_button btn">'. __( 'Remove', 'Templatepath' ) .'</button>';
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
						
					echo '</div>';
					 
				break;
				
				case 'color':
					$value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-color fields">';
						echo '<input type="text" class="tpath-meta-color" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . esc_attr( $value ) . '" />';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
						
					echo '</div>';
		 	
				break;
								
				case 'checkbox':
					
					$value = get_post_meta($post->ID, $field['id'], true);
					if( !$value ) {
						$value = 0;
					}
									
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-checkbox fields">';				
						
						echo '<input type="hidden" class="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="0" />';
						echo '<input type="checkbox" class="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="1" '. checked($value, 1, false) .' />';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
						
					echo '</div>';
										
				break;
				
				case 'editor':

					$value = get_post_meta($post->ID, $field['id'], true);
					if( ! $value ) {
						$value = '';
					}
					
					echo '<div class="tpath_metabox_field">';
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';					

						echo '<div class="field-editor fields">';

						wp_editor( $value, $field['id'], array( 'textarea_rows' => 8 ) );
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						
						echo '</div>';
					echo '</div>';						

				break;
				
				case 'iconpicker':
					
					$value = get_post_meta($post->ID, $field['id'], true);
					
					echo '<div class="tpath_metabox_field">';
						
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-iconpicker fields">';	
							echo '<div class="tpath-iconpicker">';
							foreach( $field['options'] as $select_id => $option ) {
								$class = '';
								if( $value == $select_id ) {
									$class = "selected";
								}
								echo '<i class="fa ' . $select_id . ' icon-tooltip ' . $class . '" data-toggle="tooltip" data-placement="top" title="' . $select_id . '"></i>';
							}
							echo '</div>';	
							echo '<input type="hidden" class="tpath-form-text tpath-input" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" />' . "\n";
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
					echo '</div>';

				break;
				
				case 'lineiconpicker':
					
					$value = get_post_meta($post->ID, $field['id'], true);
										
					echo '<div class="tpath_metabox_field">';
						
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-iconpicker fields">';	
							echo '<div class="tpath-iconpicker line-icons">';
							foreach( $field['options'] as $select_id => $option ) {
								$class = '';
								if( $value == $select_id ) {
									$class = "selected";
								}
								echo '<i class="simple-icon ' . $select_id . ' icon-tooltip ' . $class . '" data-toggle="tooltip" data-placement="top" title="' . $select_id . '"></i>';
							}
							echo '</div>';	
							echo '<input type="hidden" class="tpath-form-text tpath-input" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" />' . "\n";
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
					echo '</div>';
					
				break;
								
				case 'slider':
				
					$value = $min = $max = $step = $edit = $slider_data = '';
					
					$value = get_post_meta($post->ID, $field['id'], true);
					
					if(!isset($field['min'])) { $min  = '0'; } else { $min = $field['min']; }
					if(!isset($field['max'])) { $max  = $min + 1; } else { $max = $field['max']; }
					if(!isset($field['step'])) { $step  = '1'; } else { $step = $field['step']; }
										
					$edit = ' readonly="readonly"'; 
					
					if($value == '') {
						$value = $min;
					}
					
					//values
					$slider_data = 'data-id="'.$field['id'].'" data-val="'.$value.'" data-min="'.$min.'" data-max="'.$max.'" data-step="'.$step.'"';						
					
					echo '<div class="tpath_metabox_field">';
					
						echo '<label for="' . $field['id'] . '">';
						echo esc_attr( $field['name'] );
						echo '</label>';
						
						echo '<div class="field-sliderui fields">';				
						
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'. $value .'" class="tpath-slider-text" '. $edit .' />';
						echo '<div id="'.$field['id'].'-slider" class="tpath-rangeslider" '. $slider_data .'></div>';
						
						if( isset( $field['desc'] ) && $field['desc'] != '' ) {
							echo '<p class="description">' . $field['desc'] . '</p>';
						}
						echo '</div>';
						
					echo '</div>';
										
				break;
					
			} // End Switch Statement
			
		} // End foreach
	
	}
	
	public function tpath_get_sidebar() 
	{
		global $wp_registered_sidebars;
		$sidebar_options[0] = "Default";
       // for( $i=0; $i<1; $i++ ){
            $sidebars = $wp_registered_sidebars;
         
            if(is_array($sidebars) && !empty($sidebars)){
                foreach($sidebars as $sidebar){
                    $sidebar_options[$sidebar['id']] = $sidebar['name'];
                }
            }
       // }
		
		return $sidebar_options;
	}
	
	public function tpath_get_fontawesome()
	{
		// Fontawesome icons list
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$fontawesome_path = TEMPLATETHEME_DIR . '/css/font-awesome.css';
		if( file_exists( $fontawesome_path ) ) {
			$subject = file_get_contents($fontawesome_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$icons = array();
		
		foreach($matches as $match){
			$icons[$match[1]] = $match[2];
		}
		
		return $icons;
	}
	
	public function tpath_get_simplelineicon()
	{
		// Fontawesome icons list
		$pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$simplelineicons_path = TEMPLATETHEME_DIR . '/css/simple-line-icons.css';
		if( file_exists( $simplelineicons_path ) ) {
			$subject = file_get_contents($simplelineicons_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$line_icons = array();
		
		foreach($matches as $match){
			$line_icons[$match[1]] = $match[2];
		}
				
		return $line_icons;
	}	
	
	public function tpath_get_taxonomy_term_list($taxonomy, $post_type, $msg) 
	{
		$list_groups = get_categories('taxonomy='.$taxonomy.'&post_type='.$post_type.'');
		$groups_list[0] = $msg;
		if( !empty($list_groups) ) {
			foreach ($list_groups as $groups) {
				$group_name = $groups->name;
				$termid = $groups->term_id;		
				$groups_list[$termid] = $group_name;
			}
		}
	
		if( isset($groups_list) ) {
			return $groups_list;
		}
		
	}
	
	public function tpath_get_posts_list($post_type, $show_first = false) 
	{
		$list_posts = get_posts(array('post_type' => $post_type, 'numberposts' => -1));
		$posts_list = array();
		if( $show_first == true ) {
			$posts_list[0] = "Select";		
		}
		if( !empty($list_posts) ) {
			foreach ($list_posts as $item) {					
				$posts_list[$item->ID] = $item->post_title;
			}
		}
	
		if( isset($posts_list) ) {
			return $posts_list;
		}
		
	}
	
	// Add Post Options fields
	public function render_post_fields() 
	{
		$prefix = 'tpath_';
		$url =  ADMIN_DIR . 'assets/images/';		
		
		$fields = array(
		
			array(
				'name'		=> __( 'General Options', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Layout Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Theme Layout', 'Templatepath' ),				
				'id'		=> $prefix . 'theme_layout',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',			
								'fullwidth' => 'Full Width',
								'boxed' 	=> 'Boxed'
							),
				'type'		=> 'select'
			),
		
			array(
				'name'		=> __( 'Column Layouts', 'Templatepath' ),
				'id'		=> $prefix . 'layout',
				'options' 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',							
							),
				'desc'		=> '',
				'type'		=> 'images',
			),
			
			array(
				'name'		=> __( 'Header Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Header Transparency', 'Templatepath' ),				
				'id'		=> $prefix . 'header_transparency',
				'desc'		=> __('Choose header Transparency.', 'Templatepath'),
				'options' 	=> array(
								'default' 			=> 'Default',
								'no-transparent'	=> 'No Transparency',
								'transparent'		=> 'Transparent',
								'semi-transparent'	=> 'Semi Transparent',
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Sidebar Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Select Primary Sidebar', 'Templatepath' ),				
				'id'		=> $prefix . 'primary_sidebar',
				'desc'		=> 'Primary Sidebar works on two column & three column layouts',
				'options' 	=> $this->tpath_get_sidebar(),
				'type'		=> 'select'
			),						
			
			array(
				'name'		=> __( 'Page Title Bar Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Hide Page Title Bar', 'Templatepath' ),
				'id'		=> $prefix . 'hide_page_title_bar',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes',
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Show Page Title', 'Templatepath' ),
				'id'		=> $prefix . 'show_page_title',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Show Breadcrumbs', 'Templatepath' ),
				'id'		=> $prefix . 'show_breadcrumbs',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Page Header Image', 'Templatepath' ),				
				'id'		=> $prefix . 'page_header_image',
				'desc'		=> '',				
				'type'		=> 'media'
			),
			
			array(
				'name'		=> __( 'Post Options', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Video Embed Code', 'Templatepath' ),				
				'id'		=> $prefix . 'single_video_code',
				'desc'		=> 'Enter video embed code. Videos will show on top of post and also in grid layout only for Video Post Format.',
				'type'		=> 'textarea'
			),
			
			array(
				'name'		=> __( 'Audio Embed Code', 'Templatepath' ),				
				'id'		=> $prefix . 'single_audio_code',
				'desc'		=> 'Enter audio embed code. Audios will show on top of post and also in grid layout only for Audio Post Format.',
				'type'		=> 'textarea'
			),
						
			array(
				'name'		=> __( 'External Link URL', 'Templatepath' ),
				'id'		=> $prefix . 'external_link_url',
				'desc'		=> 'External Link URL will be displayed in Link Post Format.',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Additional Content Block', 'Templatepath' ),
				'id'		=> $prefix . 'additional_content_block',
				'desc'		=> 'You can optionally add some other blocks in bottom of page.',
				'options' 	=> $this->tpath_get_posts_list('tpath_block', true),
				'type'		=> 'select'
			),
						
			array(
				'name'		=> __( 'Background Options', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Boxed Mode Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Body Background Image', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_image',
				'desc'		=> '',				
				'type'		=> 'media'
			),
			
			array(
				'name'		=> __( 'Body Background Repeat', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_repeat',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',
								'repeat'	=> 'Repeat',
								'repeat-x'	=> 'Repeat-x',
								'repeat-y'	=> 'Repeat-y',
								'no-repeat' => 'No Repeat'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Body Background Attachment', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_attachment',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',
								'fixed'		=> 'Fixed', 
								'scroll'	=> 'Scroll'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Body Background Color', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( '100% Scale Background Image', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_full',
				'desc'		=> '',
				'std' 		=> 0,				
				'type'		=> 'checkbox'
			),
			
        );
		
		return $fields;
	
	}
	
	// Add Page Options fields
	public function render_page_fields() 
	{
		$prefix = 'tpath_';
		$url =  ADMIN_DIR . 'assets/images/';
		
		$fields = array(		
		
			array(
				'name'		=> __( 'General Options', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Layout Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Theme Layout', 'Templatepath' ),				
				'id'		=> $prefix . 'theme_layout',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',			
								'fullwidth' => 'Full Width',
								'boxed' 	=> 'Boxed'
							),
				'type'		=> 'select'
			),
		
			array(
				'name'		=> __( 'Column Layouts', 'Templatepath' ),
				'id'		=> $prefix . 'layout',
				'options' 	=> array(
							'one-col' 			=> $url . 'one-col.png',
							'two-col-right' 	=> $url . 'two-col-right.png',
							'two-col-left' 		=> $url . 'two-col-left.png',
							),
				'type'		=> 'images',
			),
			
			array(
				'name'		=> __( 'Header Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Header Transparency', 'Templatepath' ),				
				'id'		=> $prefix . 'header_transparency',
				'desc'		=> __('Choose header Transparency.', 'Templatepath'),
				'options' 	=> array(
								'default' 			=> 'Default',
								'no-transparent'	=> 'No Transparency',
								'transparent'		=> 'Transparent',
								'semi-transparent'	=> 'Semi Transparent',
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Page Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Hide Page Title Bar', 'Templatepath' ),
				'id'		=> $prefix . 'hide_page_title_bar',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes',
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Show Page Title', 'Templatepath' ),
				'id'		=> $prefix . 'show_page_title',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Show Breadcrumbs', 'Templatepath' ),
				'id'		=> $prefix . 'show_breadcrumbs',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Page Header Image', 'Templatepath' ),				
				'id'		=> $prefix . 'page_header_image',
				'desc'		=> '',				
				'type'		=> 'media'
			),
			
			array(
				'name'		=> __( 'Additional Content Block', 'Templatepath' ),				
				'id'		=> $prefix . 'additional_content_block',
				'desc'		=> 'You can optionally add some other blocks in bottom of page.',
				'options' 	=> $this->tpath_get_posts_list('tpath_block', true),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Sidebar Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Select Primary Sidebar', 'Templatepath' ),				
				'id'		=> $prefix . 'primary_sidebar',
				'desc'		=> 'Primary Sidebar works on two column & three column layouts',
				'options' 	=> $this->tpath_get_sidebar(),
				'type'		=> 'select'
			),
						
			array(
				'name'		=> __( 'Background Options', 'Templatepath' ),
				'type'		=> 'title'
			),
						
			array(
				'name'		=> __( 'Boxed Mode Options', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Body Background Image', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_image',
				'desc'		=> '',				
				'type'		=> 'media'
			),
			
			array(
				'name'		=> __( 'Body Background Repeat', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_repeat',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',
								'repeat'	=> 'Repeat',
								'repeat-x'	=> 'Repeat-x',
								'repeat-y'	=> 'Repeat-y',
								'no-repeat' => 'No Repeat'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Body Background Attachment', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_attachment',
				'desc'		=> '',
				'options' 	=> array(
								'default' 	=> 'Default',
								'fixed'		=> 'Fixed', 
								'scroll'	=> 'Scroll'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Body Background Color', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( '100% Scale Background Image', 'Templatepath' ),				
				'id'		=> $prefix . 'body_bg_full',
				'desc'		=> '',
				'std' 		=> 0,				
				'type'		=> 'checkbox'
			),
			
			array(
				'name'		=> __( 'Slider Options', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Revolution Slider Shortcode', 'Templatepath' ),
				'id'		=> $prefix . 'revslider_shortcode',
				'desc'		=> 'Insert Revolution Slider Shortcode.',	
				'type'		=> 'text'
			),			
			
			array(
				'name'		=> __( 'Parallax Sections', 'Templatepath' ),
				'type'		=> 'title',
				'desc'		=> 'Parallax settings are only affecting pages which are sections on the parallax page.',
			),
			
			array(
				'name'		=> __( 'Section Header', 'Templatepath' ),				
				'id'		=> $prefix . 'section_header_status',
				'desc'		=> '',
				'options' 	=> array(
								'show' 	=> 'Show',
								'hide' 	=> 'Hide'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Section Title', 'Templatepath' ),
				'id'		=> $prefix . 'section_title',
				'desc'		=> 'Include HTML tags but not allowed heading tags (H1, H2, H3, H4, H5, H6).',	
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Section Slogan', 'Templatepath' ),
				'id'		=> $prefix . 'section_slogan',
				'desc'		=> 'Include All HTML tags.',
				'type'		=> 'textarea'
			),
			
			array(
				'name'		=> __( 'Parallax Sections Styles', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Section Padding Top', 'Templatepath' ),
				'id'		=> $prefix . 'section_padding_top',
				'desc'		=> 'Enter padding top. Ex: 40px.',	
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Section Padding Bottom', 'Templatepath' ),
				'id'		=> $prefix . 'section_padding_bottom',
				'desc'		=> 'Enter padding bottom. Ex: 40px.',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Section Header Padding Bottom', 'Templatepath' ),
				'id'		=> $prefix . 'section_header_padding',
				'desc'		=> 'Enter header padding bottom. Ex: 20px.',	
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Section Title Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_title_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Section Slogan Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_slogan_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Section Text Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_text_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Section Content Heading Tags Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_content_heading_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Section Background Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_bg_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Parallax Background', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Parallax Mode', 'Templatepath' ),				
				'id'		=> $prefix . 'parallax_status',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Parallax Background Image', 'Templatepath' ),
				'id'		=> $prefix . 'parallax_bg_image',
				'desc'		=> '',
				'type'		=> 'media'
			),
			
			array(
				'name'		=> __( 'Background Repeat', 'Templatepath' ),
				'id'		=> $prefix . 'parallax_bg_repeat',
				'desc'		=> '',
				'options' 	=> array(
								''			=> 'Select',
								'repeat'	=> 'Repeat',
								'repeat-x'	=> 'Repeat-x',
								'repeat-y'	=> 'Repeat-y',
								'no-repeat' => 'No Repeat'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Background Attachment', 'Templatepath' ),
				'id'		=> $prefix . 'parallax_bg_attachment',
				'desc'		=> '',
				'options' 	=> array(
								''			=> 'Select',
								'fixed'		=> 'Fixed', 
								'scroll'	=> 'Scroll'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Background Position', 'Templatepath' ),
				'id'		=> $prefix . 'parallax_bg_postion',
				'desc'		=> '',
				'options' 	=> array(
				                ''				=> 'Select',
								'left top' 		=> 'Left Top',
								'left center' 	=> 'Left Center',
								'left bottom' 	=> 'Left Bottom',
								'center top' 	=> 'Center Top',
								'center center' => 'Center Center',
								'center bottom' => 'Center Bottom',
								'right top' 	=> 'Right Top',
								'right center' 	=> 'Right Center',
								'right bottom' 	=> 'Right Bottom',
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Background Size', 'Templatepath' ),				
				'id'		=> $prefix . 'parallax_bg_size',
				'desc'		=> '',
				'options' 	=> array(
				                ''		=> 'Select',
								'auto' 	=> 'Auto',
								'cover'	=> 'Cover'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Parallax Background Overlay', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Overlay', 'Templatepath' ),				
				'id'		=> $prefix . 'parallax_bg_overlay',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Overlay Pattern', 'Templatepath' ),				
				'id'		=> $prefix . 'overlay_pattern_status',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Overlay Pattern Style', 'Templatepath' ),
				'id'		=> $prefix . 'overlay_pattern_style',
				'options' 	=> array(
								'pattern-1' 	=> $url . 'patterns/pattern-1.png',
								'pattern-2' 	=> $url . 'patterns/pattern-2.png',
								'pattern-3' 	=> $url . 'patterns/pattern-3.png',
								'pattern-4' 	=> $url . 'patterns/pattern-4.png',
								'pattern-5' 	=> $url . 'patterns/pattern-5.png',								
							),
				'type'		=> 'images',
			),
			
			array(
				'name'		=> __( 'Section Overlay Color', 'Templatepath' ),				
				'id'		=> $prefix . 'section_overlay_color',
				'desc'		=> '',				
				'type'		=> 'color'
			),
			
			array(
				'name'		=> __( 'Overlay Color Opacity', 'Templatepath' ),				
				'id'		=> $prefix . 'overlay_color_opacity',
				'desc'		=> '',
				'min'		=> '0',
				'max' 		=> '1',
				'step' 		=> '0.1',
				'type'		=> 'slider',
			),
			
			array(
				'name'		=> __( 'Parallax Additional Sections', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Additional Sections', 'Templatepath' ),				
				'id'		=> $prefix . 'parallax_additional_sections',
				'hidden_id'	=> $prefix . 'parallax_additional_sections_order',
				'desc'		=> 'You can optionally add some other sections in parallax without adding section in a menu. Choosed sections will show below to this current section in choosen order.',
				'options' 	=> $this->tpath_get_posts_list('page', false),
				'type'		=> 'chosen'
			),			
			
        );
		
		return $fields;
	
	}
	
	// Add Product Options fields
	public function render_product_fields() 
	{
		$prefix = 'tpath_';
				
		$fields = array(	
			array(
				'name'		=> __( 'Hide Page Title Bar', 'Templatepath' ),
				'id'		=> $prefix . 'hide_page_title_bar',
				'desc'		=> '',
				'options' 	=> array(
								'no' 	=> 'No',
								'yes' 	=> 'Yes',
							),
				'type'		=> 'select'
			),
					
			array(
				'name'		=> __( 'Show Page Title', 'Templatepath' ),
				'id'		=> $prefix . 'show_page_title',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Show Breadcrumbs', 'Templatepath' ),
				'id'		=> $prefix . 'show_breadcrumbs',
				'desc'		=> '',
				'options' 	=> array(
								'yes' 	=> 'Yes',
								'no' 	=> 'No'
							),
				'type'		=> 'select'
			),
			
			array(
				'name'		=> __( 'Page Header Image', 'Templatepath' ),				
				'id'		=> $prefix . 'page_header_image',
				'desc'		=> '',				
				'type'		=> 'media'
			),
			
        );
		
		return $fields;
	
	}
	
	// Add Testimonial Options fields
	public function render_testimonial_fields() 
	{
		$prefix = 'tpath_';
		$url =  ADMIN_DIR . 'assets/images/';		
		
		$fields = array(
		
			array(
				'name'		=> __( 'Author Info', 'Templatepath' ),
				'type'		=> 'title'
			),
			
			array(
				'name'		=> __( 'Designation', 'Templatepath' ),				
				'id'		=> $prefix . 'author_designation',
				'desc'		=> 'Enter author designation.',
				'type'		=> 'text'
			),
									
			array(
				'name'		=> __( 'Company Name', 'Templatepath' ),
				'id'		=> $prefix . 'author_company_name',
				'desc'		=> 'Enter author company name.',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Company URL', 'Templatepath' ),
				'id'		=> $prefix . 'author_company_url',
				'desc'		=> 'Enter author company website URL.',
				'type'		=> 'text'
			),
			
        );
		
		return $fields;
	
	}
	
	// Portfolio Option Fields
	public function render_portfolio_fields() 
	{
	
		$prefix = 'tpath_';
		
		$fields = array(
			
			array(
				'name'		=> __( 'Client Name', 'Templatepath' ),
				'id'		=> $prefix . 'client_name',
				'desc'		=> 'Enter Client Name for the Portfolio.',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Portfolio Date', 'Templatepath' ),
				'id'		=> $prefix . 'portfolio_date',
				'desc'		=> 'Enter Date for the Portfolio.',
				'type'		=> 'text'
			)
			
        );
		
		return $fields;
	
	}	
	
	// Team Member Option Fields
	public function render_team_fields() 
	{
		$prefix = 'tpath_';
		$url =  ADMIN_DIR . 'assets/images/';
		
		$fields = array(
			
			array(
				'name'		=> __( 'Member Designation', 'Templatepath' ),
				'id'		=> $prefix . 'member_designation',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Member Overview', 'Templatepath' ),
				'id'		=> $prefix . 'member_overview',
				'desc'		=> '',
				'type'		=> 'editor'
			),
			
			array(
				'name'		=> __( 'Address', 'Templatepath' ),				
				'id'		=> $prefix . 'member_address',
				'desc'		=> '',
				'type'		=> 'textarea'
			),
			
			array(
				'name'		=> __( 'Latitude/ Longtitude', 'Templatepath' ),
				'id'		=> $prefix . 'member_latlng',
				'desc' 		=> __( "Add latitude/longtitude to show marker on map. Ex: -33.867139, 151.207114", "Templatepath" ),
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Phone Number', 'Templatepath' ),
				'id'		=> $prefix . 'member_phone',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Practise Area', 'Templatepath' ),
				'id'		=> $prefix . 'member_practise_area',
				'desc'		=> '',
				'type'		=> 'editor'
			),
			
			array(
				'name'		=> __( 'Office Hours', 'Templatepath' ),				
				'id'		=> $prefix . 'member_office_hours',
				'desc'		=> '',
				'type'		=> 'editor'
			),
			
			array(
				'name'		=> __( 'Social Links', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Facebook Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_facebook',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Twitter Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_twitter',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Linkedin Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_linkedin',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Pinterest Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_pinterest',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Google Plus Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_googleplus',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Dribbble Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_dribbble',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Flickr Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_flickr',
				'desc'		=> '',
				'type'		=> 'text'
			),
		
			array(
				'name'		=> __( 'Yahoo Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_yahoo',
				'desc'		=> '',
				'type'		=> 'text'
			),
			array(
				'name'		=> __( 'Email Link', 'Templatepath' ),
				'id'		=> $prefix . 'member_email',
				'desc'		=> '',
				'type'		=> 'text'
			),
			
			array(
				'name'		=> __( 'Content on Bottom', 'Templatepath' ),
				'type'		=> 'sub_title'
			),
			
			array(
				'name'		=> __( 'Content Block', 'Templatepath' ),				
				'id'		=> $prefix . 'additional_content_block',
				'desc'		=> 'You can optionally add some other blocks in bottom of page.',
				'options' 	=> $this->tpath_get_posts_list('tpath_block', true),
				'type'		=> 'select'
			),
		
        );
		
		return $fields;
	
	}
	
	// Client Option Fields
	public function render_client_fields() 
	{
		$prefix = 'tpath_';
		
		$fields = array(
			
			array(
				'name'		=> __( 'Client URL', 'Templatepath' ),
				'id'		=> $prefix . 'client_url',
				'desc'		=> 'Enter an URL for the client.',
				'type'		=> 'text'
			)
			
        );
		
		return $fields;
	
	}

}